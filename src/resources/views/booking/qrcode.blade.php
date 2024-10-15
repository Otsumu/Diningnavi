@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/thanks.css') }}">
<style>
    body {
        margin: 15px;
        text-align: center ;
    }

    p {
        font-size: 16px;
        font-weight: bold;
    }
</style>
@endsection

@section('content')
<body>
    <h1>QRコード</h1>
    {!! $qrCode !!}
    <p>このQRコードを店舗に提示してください</p>
    <p>QRコードのURL: <a href="{{ $url }}">{{ $url }}</a></p>
</body>
@endsection