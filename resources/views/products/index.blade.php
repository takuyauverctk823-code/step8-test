<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品情報一覧画面</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>商品情報一覧画面</h2>

    <!-- 削除成功などのメッセージ表示 -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- 検索フォーム -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('products.index') }}" method="GET" class="row g-3">
                <!-- 商品名検索 -->
                <div class="col-md-4">
                    <input type="text" name="keyword" class="form-control" placeholder="商品名（部分一致）" value="{{ $keyword }}">
                </div>
                
                <!-- メーカー検索 -->
                <div class="col-md-4">
                    <select name="company_id" class="form-select">
                        <option value="">すべてのメーカー</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}" {{ isset($companyId) && $companyId == $company->id ? 'selected' : '' }}>
                                {{ $company->company_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- 検索ボタン -->
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">検索</button>
                    <a href="{{ route('products.index') }}" class="btn btn-secondary">クリア</a>
                </div>
            </form>
        </div>
    </div>

    <!-- 新規登録リンク -->
    <div class="mb-3 text-end">
        <a href="{{ route('products.create') }}" class="btn btn-success">新規登録</a>
    </div>

    <!-- 商品情報一覧テーブル -->
    <table class="table table-striped table-hover align-middle">
        <thead class="table-dark">
            <tr>
                <th>id</th>
                <th>商品画像</th>
                <th>商品名</th>
                <th>価格</th>
                <th>在庫数</th>
                <th>メーカー名</th>
                <th>詳細表示</th>
                <th>削除</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
                <tr>
                    <!-- ID -->
                    <td>{{ $product->id }}</td>
                    
                    <!-- 商品画像 -->
                    <td>
                        @if($product->image_path)
                            <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->product_name }}" style="max-width: 50px; height: auto;">
                        @else
                            <span class="text-muted">なし</span>
                        @endif
                    </td>
                    
                    <!-- 商品名 -->
                    <td>{{ $product->product_name }}</td>
                    
                    <!-- 価格 -->
                    <td>{{ number_format($product->price) }}円</td>
                    
                    <!-- 在庫数 -->
                    <td>{{ $product->stock }}</td>
                    
                    <!-- メーカー名（リレーション設定が必要です） -->
                    <td>{{ $product->company->company_name ?? '不明' }}</td>
                    
                    <!-- 詳細表示ボタン -->
                    <td>
                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-info btn-sm text-white">詳細</a>
                    </td>
                    
                    <!-- 削除ボタン（JavaScriptでダイアログ確認を行います） -->
                    <td>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">削除</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">該当する商品が見つかりませんでした。</td>
                </tr>
            @endempty
        </tbody>
    </table>
</div>
</body>
</html>