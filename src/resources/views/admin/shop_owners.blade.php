@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin-shopowners.css') }}">
@endsection

@section('content')
<main>
    <h2 class="page-title">Shop Owners List</h2>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="container">
    <table class="table">
        <thead>
            <tr>
                <th><i class="fa-solid fa-id-card-clip"></i>&nbsp;ID</th>
                <th><i class="fa-solid fa-user"></i>&nbsp;Name</th>
                <th><i class="fa-solid fa-envelope"></i>&nbsp;Email</th>
                <th><i class="fa-solid fa-shop"></i>&nbsp;Shops Owned</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($shopOwners as $owner)
            <tr>
                <td>{{ $owner->id }}</td>
                <td>{{ $owner->name }}</td>
                <td>{{ $owner->email }}</td>
                <td>
                    @if($owner->shops->isEmpty())
                        <p>店舗がありません</p>
                    @else
                        <ul>
                        @foreach($owner->shops as $shop)
                            <li>{{ $shop->name }}</li>
                        @endforeach
                        </ul>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.confirm', $owner->id) }}" class="btn btn-primary">編集する</a>
                    <form action="{{ route('admin.shop_owner.delete', $owner->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('削除してよろしいですか?');">削除する</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</main>
@endsection