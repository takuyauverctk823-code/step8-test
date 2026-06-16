<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // 商品モデル

class ProductController extends Controller
{
    // 商品一覧・検索処理
    public function index(Request $request)
    {
        // 1. 検索クエリの準備（初期状態は全件取得のベースを作成）
        $query = Product::query();

        // 2. 検索キーワードがある場合（商品名での部分一致検索）
        if ($request->filled('keyword')) {
            $query->where('product_name', 'like', '%' . $request->keyword . '%');
        }

        // 3. メーカー名が選択されている場合（完全一致検索）
        if ($request->filled('maker_id')) {
            $query->where('maker_id', $request->maker_id);
        }

        // 検索結果を取得
        $products = $query->get();

        // メーカー一覧を取得（セレクトボックス用、実務ではMakerモデル等から取得）
        // $makers = Maker::all();

        return view('products.index', compact('products'));
    }

    // 商品削除処理
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        // 削除後、一覧画面にリダイレクトしてメッセージを表示
        return redirect()->route('products.index')->with('success', '商品を削除しました。');
    }
}