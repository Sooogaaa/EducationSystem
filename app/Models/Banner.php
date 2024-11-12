<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    public function getBanners()
    {
        $banners = Banner::orderBy('id', 'desc')->take(5)->get();
        return $banners;
    }
}
