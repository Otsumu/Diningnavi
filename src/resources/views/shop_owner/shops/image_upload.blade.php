<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/image_upload.css') }}">
    <title>アップデート</title>
</head>
<body>
<form action="{{ route('shop_owner.shops.save_image') }}" method="POST">
    @csrf
    <input type="text" name="image_url" placeholder="画像のURLを入力" required>
    <button type="submit">画像を保存</button>
    <a class="back" style="display: block; text-align: center; font-size: 12px;" href="{{ url()->previous() }}">戻る</a>
</form>
</body>
</html>