<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/image_upload.css') }}">
    <title>csv</title>
</head>
<body>
    <div class="container">
        @if (session('success'))
        <div class="alert alert-success mt-3" style="text-align: center; font-size:18px; color: blue; font-weight: bold;">
            {{ session('success') }}
        </div>
        @endif
        @if (session('error'))
        <div class="alert alert-danger mt-3" style="text-align: center; font-size:18px; color: red; font-weight: bold;">
            {{ session('error') }}
        </div>
        @endif
        <h1 style="text-align: center;">CSVインポート</h1>
        <form action="{{ route('admin.csv_import.process') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="csv_file" style="font-size: 16px;">CSVファイルを選択:</label>
                <input type="file" name="csv_file" id="csv_file" class="form-control" style="font-size: 16px; margin-top:10px;" required>
            </div>
            <button type="submit" class="btn btn-primary mt-3" style="margin-top: 20px;">インポート</button>
            <a class="back" style="display: block; text-align: center; font-size: 12px;" href="{{ route('admin.menu') }}">戻る</a>
        </form>
    </div>
</body>
</html>