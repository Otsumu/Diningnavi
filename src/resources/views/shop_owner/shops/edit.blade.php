@extends('layouts.owner-base')

@section('css')
<link rel="stylesheet" href="{{ asset('css/shop_owner-form.css') }}">
@endsection

@section('content')
    <div class="container">
        <h2 class="form-title">入力内容編集</h2>
        <p class="form-message" style="font-size: 16px; font-weight: bold; text-align: center;">内容を変更されますか？</p>
        <form action="{{ route('shop_owner.shops.update', $shop->id) }}" method="post">
            @csrf
            @method('PATCH')
            <div class="form-group">
                <label for="name"><i class="fa-solid fa-shop"></i>&nbsp;shop</label>
                <input type="text" id="name" name="name" value="{{ old('name', $shop->name) }}" >
            </div>

            <div class="form-group">
                <label for="intro"><i class="fa-regular fa-comment"></i>&nbsp;Intro</label>
                <textarea id="intro" name="intro" rows="5" >{{ old('intro', $shop->intro) }}</textarea>
            </div>

            <div class="form-group">
                <label for="image_url"><i class="fa-regular fa-image"></i>&nbsp;Image URL</label>
                <input type="url" id="image_url" name="image_url" value="{{ old('image_url', $shop->image_url) }}" >
            </div>
            <div class="image_upload-link" style="font-size: 12px; text-align: right; margin-top: -20px; padding-bottom:10px;">
                <a href="{{ route('shop_owner.shops.image_upload') }}">画像を追加する</a>
            </div>

            <div class="form-group">
                <label for="area_id"><i class="fa-solid fa-location-dot"></i>&nbsp;Area</label>
                <select id="area_id" name="area_id">
                    @foreach($areas as $area)
                        <option value="{{ $area->id }}"{{ old('area_id', $shop->area_id) == $area->id? 'selected': '' }}>
                            {{ $area->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="genre_id"><i class="fa-solid fa-utensils"></i>&nbsp;Genre</label>
                <select id="genre_id" name="genre_id">
                    @foreach($genres as $genre)
                        <option value="{{ $genre->id }}"{{ old('genre_id', $shop->genre_id) == $genre->id? 'selected': '' }}>
                            {{ $genre->name}}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="button-group">
                <a href="{{ route('shop_owner.shops.index') }}" class="btn btn-cancel">戻る</a>
                <button type="submit" class="btn btn-primary">更新する</button>
            </div>
        </form>
    </div>
@endsection