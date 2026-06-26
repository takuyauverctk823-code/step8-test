<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    // ★これが「Controllerでリクエストを受け取る」メソッドです
    public function purchase(Request $request)
    {
        // ① 送られてきたリクエスト（データ）から商品IDを受け取る
        $productId = $request->input('product_id');

        // データベースの処理を安全に行うための設定（トランザクション）
        return DB::transaction(function () use ($productId) {
            
            // 商品データをデータベースから探して取得する
            $product = Product::lockForUpdate()->find($productId);

            // 【要件③】もし在庫が0なら、エラーを返して購入させない
            if (!$product || $product->stock <= 0) {
                return response()->json([
                    'error' => '在庫がありません。購入できません。'
                ], 400); // 400エラーを返す
            }

            // 【要件①】salesテーブルにレコード（売上履歴）を追加する
            Sale::create([
                'product_id' => $product->id,
            ]);

            // 【要件②】productsテーブルの在庫数を1つ減らす
            $product->decrement('stock'); 

            // 最後に「成功しました」という結果をまとめて返却する
            return response()->json([
                'message' => '購入処理が完了しました。',
                'product_name' => $product->product_name,
                'remaining_stock' => $product->stock
            ], 200); // 200 OK（成功）を返す
        });
    }
}