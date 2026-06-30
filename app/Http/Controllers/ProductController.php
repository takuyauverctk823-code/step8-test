<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use App\Models\Product;
use App\Models\Company; // セレクトボックス用にCompanyモデルをインポート
// 作成したFormRequestをインポート
use App\Http\Requests\ProductRegisterRequest; 
use App\Http\Requests\ProductUpdateRequest;
use Illuminate\Support\Facades\Storage; // 画像削除・保存用

class ProductController extends Controller
{
    /**
     * 3-3. 商品情報一覧画面（検索機能付き）
     */
public function index(Request $request)
{
    // パラメーターの取得
    $keyword = $request->input('keyword');
    $companyId = $request->input('company_id');
    $minPrice = $request->input('min_price');
    $maxPrice = $request->input('max_price');
    $minStock = $request->input('min_stock');
    $maxStock = $request->input('max_stock');

    // クエリビルダの開始
    $query = Product::query();

    // 商品名検索
    if (!empty($keyword)) {
        $query->where('product_name', 'LIKE', "%{$keyword}%");
    }

    // メーカー検索
    if (!empty($companyId)) {
        $query->where('company_id', $companyId);
    }

    // 価格（下限）検索
    if (!empty($minPrice)) {
        $query->where('price', '>=', $minPrice);
    }

    // 価格（上限）検索
    if (!empty($maxPrice)) {
        $query->where('price', '<=', $maxPrice);
    }

    // 在庫数（下限）検索
    if (!empty($minStock)) {
        $query->where('stock', '>=', $minStock);
    }

    // 在庫数（上限）検索
    if (!empty($maxStock)) {
        $query->where('stock', '<=', $maxStock);
    }

    // ★リレーション（company）を一緒に、確実に取得する
    $products = $query->with('company')->get();
    $companies = Company::all();

    // Ajaxリクエストの場合はJSONデータを返す
    if ($request->ajax()) {
        return response()->json([
            'products' => $products
        ]);
    }

    // 通常の画面表示（必要な変数をすべて compact で渡します）
    return view('products.index', compact('products', 'companies', 'keyword', 'companyId'));
}

    /**
     * 3-4. 商品情報登録画面（表示）
     */
    public function create()
    {
        // 登録画面のセレクトボックスに表示するために、全メーカーを取得して渡す
        $companies = Company::all();
        return view('products.create', compact('companies'));
    }

    /**
     * 商品情報登録処理（保存実行）
     */
    public function store(ProductRegisterRequest $request) // フォームリクエストに変更
    {
        // フォームリクエストでバリデーション済みのデータを取得
        $validated = $request->validated();

        // 画像のアップロード処理
        $imagePath = null;
        if ($request->hasFile('product_image')) {
            // storage/app/public/products フォルダに保存（シンボリックリンクの設定が必要です）
            $imagePath = $request->file('product_image')->store('products', 'public');
        }

        // データベースに登録
        Product::create([
            'product_name' => $validated['product_name'],
            'company_id'   => $validated['company_id'],
            'price'        => $validated['price'],
            'stock'        => $validated['stock'],
            'comment'      => $validated['comment'] ?? null,
            'image_path'   => $imagePath, // 各自のDB定義のカラム名に合わせて調整してください
        ]);

        return redirect()->route('products.create')->with('success', '商品を登録しました。');
    }

    /**
     * 3-5. 商品情報詳細画面
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
    }


/**
     * 3-6. 商品情報編集画面（表示）
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $companies = Company::all();
        return view('products.edit', compact('product', 'companies'));
    }

    /**
     * 商品情報編集処理（更新実行）
     */
    public function update(ProductUpdateRequest $request, $id)
    {
        $validated = $request->validated();
        $product = Product::findOrFail($id);

        $imagePath = $product->image_path;
        if ($request->hasFile('product_image')) {
            if ($product->image_path) {
                Storage::disk('public')->delete($product->image_path);
            }
            $imagePath = $request->file('product_image')->store('products', 'public');
        }

        $product->update([
            'product_name' => $validated['product_name'],
            'company_id'   => $validated['company_id'],
            'price'        => $validated['price'],
            'stock'        => $validated['stock'],
            'comment'      => $validated['comment'] ?? null,
            'image_path'   => $imagePath,
        ]);

        return redirect()->route('products.edit', $id)->with('success', '商品情報を更新しました。');
    }

    /**
     * 商品情報削除処理
     */

public function destroy($id)
{
    try {
        // 1. 対象のレコードを取得
        $product = Product::findOrFail($id);

        // 2. 画像ファイルが存在すればストレージから削除
        if ($product->image) {
            Storage::disk('public')->delete($product->image); 
        }

        // 3. データベースからレコードを削除
        $product->delete();

        // 4. 非同期（Ajax）に正常終了のJSONを返す
        return response()->json(['success' => true, 'message' => '商品を削除しました。']);

    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => '削除に失敗しました。'], 500);
    }
}
}