<div class="container">
    <h1>商品一覧画面</h1>

    <!-- 検索フォームエリア -->
    <form action="{{ route('products.index') }}" method="GET" class="search-form">
        <input type="text" name="keyword" placeholder="検索キーワード" value="{{ request('keyword') }}">
       
        <select name="maker_id">
            <option value="">メーカー名</option>
            <!-- ループ処理でデータベースからメーカーを出すのが一般的です -->
            <option value="1" {{ request('maker_id') == 1 ? 'selected' : '' }}>Coca-Cola</option>
            <option value="2" {{ request('maker_id') == 2 ? 'selected' : '' }}>サントリー</option>
        </select>
       
        <button type="submit">検索</button>
    </form>

    <!-- 「新規登録」ボタン -->
    <div style="margin: 10px 0; text-align: right;">
        <a href="{{ route('products.create') }}" class="btn-orange">新規登録</a>
    </div>

    <!-- 商品一覧テーブル -->
    <table class="product-table" border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>商品画像</th>
                <th>商品名</th>
                <th>価格</th>
                <th>在庫数</th>
                <th>メーカー名</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td><img src="{{ asset('storage/' . $product->image_path) }}" width="50" alt="商品画像"></td>
                <td>{{ $product->product_name }}</td>
                <td>¥{{ number_col($product->price) }}</td>
                <td>{{ $product->stock }}</td>
                <td>{{ $product->maker_name }}</td>
                <td>
                    <!-- 「詳細」ボタン -->
                    <a href="{{ route('products.show', $product->id) }}" class="btn-blue">詳細</a>
                   
                    <!-- 「削除」ボタン（安全のためFORMタグのPOST送信でDELETEを疑似再現します） -->
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('本当に削除しますか？')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-red">削除</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
