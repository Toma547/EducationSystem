<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    public static function getLatestArticles()
    {
        return self::orderBy('posted_date', 'desc')
            ->take(5)
            ->get();
    }
}
