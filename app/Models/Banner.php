<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Banner extends Model
{
    protected $table = 'banners';

    public function getAllBanners()
    {
        return DB::table($this->table)->get();
    }

    public function deleteAll()
    {
        return DB::table($this->table)->truncate();
    }

    public function insertBanner($path)
    {
        return DB::table($this->table)->insert([
            'image' => $path,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
