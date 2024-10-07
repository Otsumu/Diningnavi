<form action="{{ route('shop_owner.shops.save_image') }}" method="POST">
    @csrf
    <input type="text" name="image_url" placeholder="画像のURLを入力" required>
    <button type="submit">画像を保存</button>
</form>