<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>アップデート</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        form {
            background-color: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }

        input[type="text"], button {
            width: calc(100% - 10px);
            padding: 15px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 15px;
            box-sizing: border-box;
            text-align: center;
        }

        button {
            background-color: #007BFF;
            color: white;
            cursor: pointer;
            border: none;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<form action="{{ route('shop_owner.shops.save_image') }}" method="POST">
    @csrf
    <input type="text" name="image_url" placeholder="画像のURLを入力" required>
    <button type="submit">画像を保存</button>
    <a class="back" style="display: block; text-align: center; font-size: 12px;" href="{{ route('shop_owner.shops.menu') }}">メニューに戻る</a>
</form>
</body>
</html>