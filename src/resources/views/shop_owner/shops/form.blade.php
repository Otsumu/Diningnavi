@extends('layouts.owner-base')

@section('css')
<link rel="stylesheet" href="{{ asset('css/shop_owner-form.css') }}">
@endsection

@section('content')
    <div class="container">
      <h2 class="form-title">新規店舗登録</h2>
        <form action="{{ route('shop_owner.shops.confirm') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name"><i class="fa-solid fa-shop"></i>&nbsp;shop</label>
                <input type="text" id="name" name="name" value="{{ old('name', session('shop_inputs.name', '' )) }}" placeholder="店舗名を入力して下さい" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
            </div>

            <div class="form-group">
                <label for="intro"><i class="fa-regular fa-comment"></i>&nbsp;Intro</label>
                <textarea id="intro" name="intro" rows="5" placeholder="お店の紹介文を入力して下さい">{{ old('intro', session('shop_inputs.intro', '')) }} </textarea>
                    @error('intro')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
            </div>

            <div class="form-group">
                <label for="image_url"><i class="fa-regular fa-image"></i>&nbsp;Image</label>
                <select id="image_url" name="image_url" required>
                    <option value="">画像を選択してください</option>
                    @foreach ($imageFiles as $file)
                        <option value="{{ $file }}" {{ old('image_url', session('shop_inputs.image_url', '')) == $file ? 'selected' : '' }}>
                            {{ basename($file) }}
                        </option>
                    @endforeach
                </select>
                @error('image_url')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="image_upload-link" style="font-size: 12px; text-align: right; margin-top: -20px; padding-bottom:10px;">
                <a href="{{ route('shop_owner.shops.image_upload') }}">画像をダウンロードする</a>
            </div>

            <div class="form-group">
                <label for="area_id"><i class="fa-solid fa-location-dot"></i>&nbsp;Area</label>
                <select id="area_id" name="area_id" required>
                    <option value="">選択して下さい</option>
                        @foreach($areas as $area)
                            <option value="{{ $area->id }}">{{ $area->name }}</option>
                        @endforeach
                </select>
                @error('area_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="genre_id"><i class="fa-solid fa-utensils"></i>&nbsp;Genre</label>
                <select id="genre_id" name="genre_id" required>
                    <option value="">選択してください</option>
                        @foreach($genres as $genre)
                    <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                    @endforeach
                </select>
                @error('genre_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="button-group">
                <button type="submit" class="btn btn-primary">確認する</button>
            </div>
        </form>
    </div>
@endsection