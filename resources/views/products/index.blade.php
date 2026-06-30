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
            <form action="{{ route('products.index') }}" method="GET" class="row g-3" id="search-form"> <!-- ← idを追加 -->
                <!-- 価格 範囲検索（追加） -->
<div class="col-md-3">
    <input type="number" name="min_price" class="form-control" placeholder="価格（下限）" value="{{ request('min_price') }}">
</div>
<div class="col-md-3">
    <input type="number" name="max_price" class="form-control" placeholder="価格（上限）" value="{{ request('max_price') }}">
</div>

<!-- 在庫数 範囲検索（追加） -->
<div class="col-md-3">
    <input type="number" name="min_stock" class="form-control" placeholder="在庫数（下限）" value="{{ request('min_stock') }}">
</div>
<div class="col-md-3">
    <input type="number" name="max_stock" class="form-control" placeholder="在庫数（上限）" value="{{ request('max_stock') }}">
</div>
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
        <tbody id="product-table-body">
            @if($products->count() > 0)
                @foreach($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>
                            @if($product->image_path)
                                <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->product_name }}" style="max-width: 50px; height: auto;">
                            @else
                                <span class="text-muted">なし</span>
                            @endif
                        </td>
                        <td>{{ $product->product_name }}</td>
                        <td>{{ number_format($product->price) }}円</td>
                        <td>{{ $product->stock }}</td>
                        <td>{{ $product->company->company_name ?? '不明' }}</td>
                        <td>
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-info btn-sm text-white">詳細</a>
                        </td>
                        <td>
                           <!-- ↓ class="delete-form" を追加します -->
<form action="{{ route('products.destroy', $product->id) }}" method="POST" class="delete-form" onsubmit="return confirm('本当に削除しますか？');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">削除</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="8" class="text-center">該当する商品が見つかりませんでした。</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>

<!-- ========================================== -->
<!-- JavaScriptとjQueryは、完全にHTML（divやtable）の外側に配置します -->
<!-- ========================================== -->
<!-- jQueryの読み込み -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    console.log('jQueryの読み込み完了。フォームの監視を開始します。');

    // ==========================================
    // ① 商品検索の非同期（Ajax）処理
    // ==========================================
    $('#search-form').on('submit', function(e) {
        e.preventDefault(); // 通常のページ更新をブロック
        console.log('検索ボタンが押されました。非同期通信を開始します。');

        let formData = $(this).serialize();

        $.ajax({
            url: "{{ route('products.index') }}", 
            type: "GET",
            data: formData,
            dataType: "json",
        })
        .done(function(data) {
            console.log('検索通信成功:', data);
            
            let $tableBody = $('#product-table-body');
            $tableBody.empty(); // 現在のテーブルをクリア

            if (!data.products || data.products.length === 0) {
                $tableBody.append('<tr><td colspan="8" class="text-center">該当する商品が見つかりません。</td></tr>');
                return;
            }

            // ループ処理で新しいテーブル行を生成
            $.each(data.products, function(index, product) {
                let imageHtml = product.image_path 
                    ? `<img src="/storage/${product.image_path}" alt="${product.product_name}" style="max-width: 50px; height: auto;">`
                    : '<span class="text-muted">なし</span>';

                let companyName = product.company ? product.company.company_name : '不明';

                // ★検索後に出力される削除フォームにも class="delete-form" を付与します
                let row = `
                    <tr>
                        <td>${product.id}</td>
                        <td>${imageHtml}</td>
                        <td>${product.product_name}</td>
                        <td>${Number(product.price).toLocaleString()}円</td>
                        <td>${product.stock}</td>
                        <td>${companyName}</td>
                        <td>
                            <a href="/products/${product.id}" class="btn btn-info btn-sm text-white">詳細</a>
                        </td>
                        <td>
                            <form action="/products/${product.id}" method="POST" class="delete-form">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-danger btn-sm">削除</button>
                            </form>
                        </td>
                    </tr>
                `;
                $tableBody.append(row);
            });
        })
        .fail(function(xhr, status, error) {
            console.error('【検索Ajax通信エラー詳細】', error);
            alert('検索処理に失敗しました。');
        });
    });

    // ==========================================
    // ② 商品削除の非同期（Ajax）処理
    // ==========================================
    // $(document).on を使うことで、後から検索結果で増えた削除ボタンも100%確実にキャッチします
    $(document).on('submit', '.delete-form', function(e) {
        e.preventDefault(); // ページが「/products/ID」へ移動するのを絶対に阻止！

        // JavaScript側で確認ダイアログを表示
        if (!confirm('本当に削除しますか？')) {
            return false;
        }

        let $form = $(this);
        let $tr = $form.closest('tr'); 
        let actionUrl = $form.attr('action'); 
        let token = $form.find('input[name="_token"]').val(); 

        console.log('削除通信を開始します。対象URL:', actionUrl);

        $.ajax({
            url: actionUrl,
            type: "POST", 
            data: {
                _token: token,
                _method: "DELETE"
            },
            dataType: "json",
        })
        .done(function(data) {
            console.log('削除通信成功:', data);
            
            if (data.success) {
                // 画面はそのままで、対象の行（tr）だけをフェードアウトして消去
                $tr.fadeOut(400, function() {
                    $(this).remove();
                    
                    // テーブルが空っぽになったらメッセージを出す
                    if ($('#product-table-body tr').length === 0) {
                        $('#product-table-body').append('<tr><td colspan="8" class="text-center">該当する商品が見つかりませんでした。</td></tr>');
                    }
                });
                
                // お望みのプリティプリント（綺麗に整形されたJSON）形式でアラート表示
                let prettyJson = JSON.stringify(data, null, 2);
                alert("削除に成功しました！\n" + prettyJson); 
            } else {
                alert(data.message || '削除に失敗しました。');
            }
        })
        .fail(function(xhr) {
            console.error('削除通信エラー:', xhr.responseText);
            alert('削除処理に失敗しました。');
        });
    });
});
</script>