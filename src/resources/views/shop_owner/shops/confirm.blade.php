@extends('layouts.owner-base')

@section('css')
<link rel="stylesheet" href="{{ asset('css/shop_owner-form.css') }}">
@endsection

@section('content')
    <div class="container">
      <h2 class="form-title">入力内容確認</h2>
      <p class="form-message" style="font-size: 16px; font-weight: bold; text-align: center;">
        こちらで登録してよろしいですか？</p>
        <form action="{{ route('shop_owner.shops.index') }}" method="post">
            @csrf
            <div class="form-group">
                <label for="name"><i class="fa-solid fa-shop"></i>&nbsp;shop</label>
                <input type="text" id="name" name="name" value="{{ $inputs['name'] ?? '' }}" readonly>
            </div>

            <div class="form-group">
                <label for="intro"><i class="fa-regular fa-comment"></i>&nbsp;Intro</label>
                <textarea id="intro" name="intro" rows="5" readonly>{{ $inputs['intro'] ?? '' }}</textarea>
            </div>

            <div class="form-group">
                <label for="image_url"><i class="fa-regular fa-image"></i>&nbsp;Image</label>
                <input type="text" id="image_url" name="image_url" value="{{ $inputs['image_url'] ?? '' }}" readonly>
                <div class="image-preview" style="margin-top: 10px;">
                    @if(isset($inputs['image_url']) && file_exists(public_path('storage/images/' . $inputs['image_url'])))
                        <img src="{{ asset('storage/images/' . $inputs['image_url']) }}" style="max-width: 100%; height: auto;">
                    @endif
                </div>
            </div>

            <div class="form-group">
                <label for="area_id"><i class="fa-solid fa-location-dot"></i>&nbsp;Area</label>
                <select id="area_id" name="area_id">
                    @foreach($areas as $area)
                        <option value="{{ $area->id }}" {{ (isset($inputs['area_id']) && $inputs['area_id'] == $area->id) ? 'selected' : '' }}>
                            {{ $area->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="genre_id"><i class="fa-solid fa-utensils"></i>&nbsp;Genre</label>
                <select id="genre_id" name="genre_id">
                    @foreach($genres as $genre)
                        <option value="{{ $genre->id }}" {{ (isset($inputs['genre_id']) && $inputs['genre_id'] == $genre->id) ? 'selected' : '' }}>
                            {{ $genre->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="button-group">
                <a href="{{ route('shop_owner.shops.form') }}" class="btn btn-cancel">戻る</a>
                <button type="submit" class="btn btn-primary">登録する</button>
            </div>
        </form>
    </div>
@endsection