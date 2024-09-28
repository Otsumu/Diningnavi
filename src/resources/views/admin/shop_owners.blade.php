@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin-shopowners.css') }}">
<link rel="stylesheet" href="{{ asset('css/pagination.css') }}">
@endsection

@section('content')
<main>
    <h2 class="page-title">Shop Owners List</h2>
    
    <a href="{{ route('admin.menu') }}" class="btn btn-back">戻る</a>

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
            @foreach($shopOwners as $shopOwner)
                <tr>
                    <td>{{ $shopOwner->id }}</td>
                    <td>{{ $shopOwner->name }}</td>
                    <td>{{ $shopOwner->email }}</td>
                    <td>
                        @if($shopOwner->shops->isNotEmpty())
                            @foreach($shopOwner->shops as $shop)
                                <a href="{{ route('shop.detail', $shop->id) }}">{{ $shop->name }}</a><br>
                            @endforeach
                        @else
                            <span>店舗がありません</span>
                        @endif
                    </td>
                    <td>
                    <form action="{{ route('admin.confirm', $shopOwner->id) }}" method="GET" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-primary">編集する</button>
                    </form>
                    <form action="{{ route('admin.shop_owner.delete', $shopOwner->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('削除してよろしいですか?');">削除する</button>
                    </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $shopOwners->links() }}
    </div>
</main>
@endsection