@extends('layouts.owner-base')

@section('css')
<link rel="stylesheet" href="{{ asset('css/shop_owner-form.css') }}">
@endsection

@section('content')
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="container">
        <h2 class="form-title">新規店舗登録</h2>
        <form action="{{ route('admin.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name"><i class="fa-solid fa-shop"></i>&nbsp;店舗名</label>
                <input type="text" id="name" name="name" value="{{ old('name', session('shop_inputs.name', '')) }}" placeholder="店舗名を入力して下さい" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="intro"><i class="fa-regular fa-comment"></i>&nbsp;店舗紹介</label>
                <textarea id="intro" name="intro" rows="5" placeholder="お店の紹介文を入力して下さい">{{ old('intro', session('shop_inputs.intro', '')) }}</textarea>
                @error('intro')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="image_url"><i class="fa-regular fa-image"></i>&nbsp;画像</label>
                <select id="image_url" name="image_url" required>
                    <option value="">画像を選択してください</option>
                    <option value="{{ asset('storage/images/italian.jpg') }}" {{ old('image_url', session('shop_inputs.image_url', '')) == asset('storage/images/italian.jpg') ? 'selected' : '' }}>italian.jpg</option>
                    <option value="{{ asset('storage/images/izakaya.jpg') }}" {{ old('image_url', session('shop_inputs.image_url', '')) == asset('storage/images/izakaya.jpg') ? 'selected' : '' }}>izakaya.jpg</option>
                    <option value="{{ asset('storage/images/ramen.jpg') }}" {{ old('image_url', session('shop_inputs.image_url', '')) == asset('storage/images/ramen.jpg') ? 'selected' : '' }}>ramen.jpg</option>
                    <option value="{{ asset('storage/images/sushi.jpg') }}" {{ old('image_url', session('shop_inputs.image_url', '')) == asset('storage/images/sushi.jpg') ? 'selected' : '' }}>sushi.jpg</option>
                    <option value="{{ asset('storage/images/yakiniku.jpg') }}" {{ old('image_url', session('shop_inputs.image_url', '')) == asset('storage/images/yakiniku.jpg') ? 'selected' : '' }}>yakiniku.jpg</option>
                </select>
                @error('image_url')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="image_upload-link" style="font-size: 12px; text-align: right; margin-top: -20px; padding-bottom:10px;">
                <a href="{{ route('admin.image_upload') }}">画像を追加する</a>
            </div>

            <div class="form-group">
                <label for="area_id"><i class="fa-solid fa-location-dot"></i>&nbsp;エリア</label>
                <select id="area_id" name="area_id" required>
                    <option value="">エリアを選択して下さい</option>
                    @foreach($areas as $area)
                        <option value="{{ $area->id }}">{{ $area->name }}</option>
                    @endforeach
                </select>
                @error('area_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="genre_id"><i class="fa-solid fa-utensils"></i>&nbsp;ジャンル</label>
                <select id="genre_id" name="genre_id" required>
                    <option value="">ジャンルを選択してください</option>
                    @foreach($genres as $genre)
                        <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                    @endforeach
                </select>
                @error('genre_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="button-group">
                <a href="{{ route('admin.menu') }}" class="btn btn-secondary border-secondary">戻る</a>
                <button type="submit" class="btn btn-primary">店舗を作成</button>
            </div>
        </form>
        <div class="mt-4 d-flex justify-content-end">
            <a href="{{ route('admin.csv_export') }}" class="btn btn-outline-secondary"
            style="padding: 10px 18px; margin-right: 10px; font-size: 14px;">CSVをインポート</a>
        </div>
    </div>
@endsection
