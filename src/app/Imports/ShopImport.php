<?php

namespace App\Imports;

use App\Models\Shop;
use App\Models\Genre;
use App\Models\Area;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ShopImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row) {

        $genre = Genre::where('name', $row['genre'])->first();
        $area = Area::where('name', $row['area'])->first();

        if (!$genre || !$area) {
            throw new \Exception("Invalid genre or area for shop: " . $row['name']);
        }

        $userId = Auth::id();

        $shopOwnerId = $userId;

        return new Shop([
            'name' => $row['name'],
            'genre_id' => $genre->id,
            'area_id' => $area->id,
            'intro' => $row['intro'],
            'image_url' => $row['image_url'],
            'user_id' => $userId,
            'shop_owner_id' => $shopOwnerId,
        ]);
    }
}