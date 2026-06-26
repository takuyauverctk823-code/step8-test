<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品新規登録画面</title>
    <!-- 必要に応じてBootstrapなどのCSSを読み込んでください -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>商品新規登録画面</h2>

    <!-- 成功メッセージの表示 -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- 登録フォーム -->
    <!-- ※画像アップロードを行うため、enctype="multipart/form-data" が必須です -->
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- 商品名（必須） -->
        <div class="mb-3">
            <label for="product_name" class="form-label">商品名 <span class="text-danger">*</span></label>
            <input type="text" class="form-content form-control @error('product_name') is-invalid @enderror" 
                   id="product_name" name="product_name" value="{{ old('product_name') }}">
            @error('product_name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- メーカー名（必須・セレクトボックス） -->
        <div class="mb-3">
            <label for="company_id" class="form-label">メーカー <span class="text-danger">*</span></label>
            <select class="form-select @error('company_id') is-invalid @enderror" id="company_id" name="company_id">
                <option value="">メーカーを選択してください</option>
                @foreach($companies as $company)
                    <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>
                        {{ $company->company_name }}
                    </option>
                @endforeach
            </select>
            @error('company_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- 価格（必須・半角数字） -->
        <div class="mb-3">
            <label for="price" class="form-label">価格 <span class="text-danger">*</span></label>
            <input type="number" class="form-control @error('price') is-invalid @enderror" 
                   id="price" name="price" value="{{ old('price') }}">
            @error('price')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- 在庫数（必須・半角数字） -->
        <div class="mb-3">
            <label for="stock" class="form-label">在庫数 <span class="text-danger">*</span></label>
            <input type="number" class="form-control @error('stock') is-invalid @enderror" 
                   id="stock" name="stock" value="{{ old('stock') }}">
            @error('stock')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- コメント（任意・テキストエリア） -->
        <div class="mb-3">
            <label for="comment" class="form-label">コメント</label>
            <textarea class="form-control @error('comment') is-invalid @enderror" 
                      id="comment" name="comment" rows="3">{{ old('comment') }}</textarea>
            @error('comment')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- 商品画像（任意・ファイル） -->
        <div class="mb-3">
            <label for="product_image" class="form-label">商品画像</label>
            <input type="file" class="form-control @error('product_image') is-invalid @enderror" 
                   id="product_image" name="product_image">
            @error('product_image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- ボタン類 -->
        <div class="mt-4">
            <button type="submit" class="btn btn-primary">登録</button>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">戻る</a>
        </div>
    </form>
</div>
</body>
</html>