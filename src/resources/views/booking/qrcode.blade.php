@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/thanks.css') }}">
@endsection

@section('content')
<body>
    <h1>QRコード</h1>
    {!! $qrCode !!}
    <p>このQRコードを店舗に提示してください。</p>
</body>
@endsection