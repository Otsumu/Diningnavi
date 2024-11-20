<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Shop Owner List</title>
    <link rel="stylesheet" href="{{ asset('css/adminIndex.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    @yield('css')
</head>
<body>
    <main>
    <div class="container">
        <h1>口コミ一覧</h1>

        @if(session('success'))
            <div class="alert alert-success" style="background-color: #cce5ff; color: #004085; padding: 7px; font-size: 12px; border-radius: 5px; border: 1px solid #b8daff; margin-bottom: 5px;">
                {{ session('success') }}</div>
        @endif
        <a href="{{ route('admin.menu') }}" class="page-back">戻る</a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>投稿日</th>
                    <th>ユーザー名</th>
                    <th>飲食店名</th>
                    <th>評価</th>
                    <th>口コミ内容</th>
                    <th>アクション</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($comments as $comment)
                    <tr>
                        <td>{{ $comment->created_at->format('Y/m/d') }}</td>
                        <td>{{ $comment->user->name }}</td>
                        <td>{{ $comment->shop->name }}</td>
                        <td>{{ $comment->rating }}</td>
                        <td>{{ $comment->content }}</td>
                        <td>
                            <form action="{{ route('admin.comments.delete', $comment->id) }}" method="POST" onsubmit="return confirm('本当に削除してもよろしいですか？');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">削除</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if ($comments->hasPages())
            <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <li class="page-item {{ $comments->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $comments->previousPageUrl() }}" rel="prev">&laquo;</a>
                </li>

                @foreach ($comments->links()->elements as $element)
                    @if (is_string($element))
                        <li class="disabled page-item"><span class="page-link">{{ $element }}</span></li>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            <li class="page-item {{ $page == $comments->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endforeach
                    @endif
                @endforeach

                <li class="page-item {{ $comments->hasMorePages() ? '' : 'disabled' }}">
                    <a class="page-link" href="{{ $comments->nextPageUrl() }}" rel="next">&raquo;</a>
                </li>
            </ul>
            </nav>
        @endif
    </main>
</body>
</html>
