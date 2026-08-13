<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Article;

class TopController extends Controller
{
    /**
     * トップ画面表示
     */
    public function showTop()
    {
        $banners = Banner::orderBy('id')->get();

        $articles = Article::orderBy('posted_date', 'desc')
            ->take(5)
            ->get();

        return view('user.top', compact('banners', 'articles'));
    }
}
