<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品情報詳細画面</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5" style="max-width: 600px;">
    <h2>商品情報詳細画面</h2>

    <div class="card mt-4">
        <div class="card-body">
            <div class="mb-3">
                <strong>商品情報ID:</strong> {{ $product->id }}
            </div>
            <div class="mb-3">
                <strong>商品画像:</strong><br>
                @if($product->image_path)
                    <img src="{{ asset('storage/' . $product->image_path) }}" alt="商品画像" class="img-thumbnail mt-2" style="max-width: 200px;">
                @else
                    <span class="text-muted">画像なし</span>
                @endif
            </div>
            <div class="mb-3">
                <strong>商品名:</strong> {{ $product->product_name }}
            </div>
            <div class="mb-3">
                <strong>メーカー:</strong> {{ $product->company->company_name ?? '未設定' }}
            </div>
            <div class="mb-3">
                <strong>価格:</strong> {{ number_format($product->price) }}円
            </div>
            <div class="mb-3">
                <strong>在庫数:</strong> {{ $product->stock }}
            </div>
            <div class="mb-3">
                <strong>コメント:</strong>
                <p class="mt-1 p-2 bg-light rounded" style="white-space: pre-wrap;">{{ $product->comment ?? 'コメントはありません。' }}</p>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">編集</a>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">戻る</a>
    </div>
</div>
</body>
</html>