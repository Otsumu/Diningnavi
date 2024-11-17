<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/image_upload.css') }}">
    <title>csv</title>
</head>
<body>
<div class="mt-4">
    <a href="{{ route('admin.csv_export') }}" class="btn btn-outline-secondary">
        CSVをエクスポートする
    </a>
</div>
</body>
</html>
