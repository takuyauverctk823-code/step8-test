<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品情報編集画面</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>商品情報編集画面</h2>

    @if (session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="mt-4">
        @csrf
        @method('PUT') <!-- 更新処理には PUT または PATCH が必要です -->

        <div class="mb-3">
            <label class="form-label">商品情報ID</label>
            <input type="text" class="form-control bg-light" value="{{ $product->id }}" readonly>
        </div>

        <div class="mb-3">
            <label for="product_name" class="form-label">商品名 <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('product_name') is-invalid @enderror" 
                   id="product_name" name="product_name" value="{{ old('product_name', $product->product_name) }}">
            @error('product_name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="company_id" class="form-label">メーカー <span class="text-danger">*</span></label>
            <select class="form-select @error('company_id') is-invalid @enderror" id="company_id" name="company_id">
                <option value="">メーカーを選択してください</option>
                @foreach($companies as $company)
                    <option value="{{ $company->id }}" {{ old('company_id', $product->company_id) == $company->id ? 'selected' : '' }}>
                        {{ $company->company_name }}
                    </option>
                @endforeach
            </select>
            @error('company_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">価格 <span class="text-danger">*</span></label>
            <input type="number" class="form-control @error('price') is-invalid @enderror" 
                   id="price" name="price" value="{{ old('price', $product->price) }}">
            @error('price')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="stock" class="form-label">在庫数 <span class="text-danger">*</span></label>
            <input type="number" class="form-control @error('stock') is-invalid @enderror" 
                   id="stock" name="stock" value="{{ old('stock', $product->stock) }}">
            @error('stock')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="comment" class="form-label">コメント</label>
            <textarea class="form-control @error('comment') is-invalid @enderror" 
                      id="comment" name="comment" rows="3">{{ old('comment', $product->comment) }}</textarea>
            @error('comment')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="product_image" class="form-label">商品画像</label>
            @if($product->image_path)
                <div class="mb-2">
                    <small class="text-muted">現在の画像:</small><br>
                    <img src="{{ asset('storage/' . $product->image_path) }}" alt="現在の画像" style="max-width: 100px;">
                </div>
            @endif
            <input type="file" class="form-control @error('product_image') is-invalid @enderror" id="product_image" name="product_image">
            @error('product_image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">更新</button>
            <a href="{{ route('products.show', $product->id) }}" class="btn btn-secondary">戻る</a>
        </div>
    </form>
</div>
</body>
</html>