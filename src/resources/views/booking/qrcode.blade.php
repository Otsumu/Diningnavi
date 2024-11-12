@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/thanks.css') }}">
<link rel="stylesheet" href="{{ asset('css/qrcode.css') }}">
@endsection

@section('content')
<body>
    <h1>QRコード</h1>
    {!! $qrCode !!}
    <p>このQRコードを店舗に提示してください</p>
    <p>QRコードのURL: <a href="{{ $url }}">{{ $url }}</a></p>
</body>
@endsection