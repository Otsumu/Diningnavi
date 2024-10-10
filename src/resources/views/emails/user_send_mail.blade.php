@extends('layouts.owner-base')

@section('css')
<link rel="stylesheet" href="{{ asset('css/shop_owner-form.css') }}">

<style>
    .form-group {
        margin-bottom: 15px;
    }

    label {
        display: block;
        margin-bottom: 5px;
    }

    textarea {
        width: 100%;
        margin-left: 10px;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
    }

    .button-group {
        margin-top: 15px;
    }

    .btn-primary {
        width: 100%;
        margin-right: 5px;
    }
</style>
@endsection

@section('content')
    <div class="container">
        <h2 class="form-title">{{ $subject }}</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('send.bulk.email') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label for="body"><i class="fa-solid fa-comment"></i>&nbsp;メッセージ</label>
                <textarea id="body" name="body" rows="5" required>{{ old('body', '') }}</textarea>
                @error('body')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="button-group">
                <button type="submit" class="btn btn-primary">全顧客にメール送信</button>
            </div>
        </form>
    </div>
@endsection