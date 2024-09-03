@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('header')
<form class="header__right" action="/" method="get">
    <div class="header__search">
      <div class="select-box">
        <label class="select-box-label"></label>
            <select name="area" class="select-box-item">
                <option value="">All area</option>
                    @if(isset($areas))
                      @foreach($areas as $area)
                      <option value="{{ $area->id }}" {{ request('area') == $area->id ? 'selected' : '' }}>
                      {{ $area->name }}</option>
                      @endforeach
                    @endif
            </select>
        </div>

        <div class="select-box">
        <label class="select-box-label"></label>
            <select name="genre" class="select-box-item">
                <option value="">All genre</option>
                @if(isset($genres))
                    @foreach($genres as $genre)
                        <option value="{{ $genre->id }}" {{ request('genre') == $genre->id ? 'selected' : '' }}>
                            {{ $genre->name }}
                        </option>
                    @endforeach
                @endif
            </select>
        </label>
      </div>

      <div class="search__item">
        <div class="search__item-button">  
          <i class="fa-solid fa-magnifying-glass"></i></div>
          <label class="search__item-label">
            <input type="text" name="keyword" class="search__item-input" placeholder="Search ..." value="{{ request('keyword') }}">
          </label>
      </div>
    </div>
</form>

@endsection

@section('content')
