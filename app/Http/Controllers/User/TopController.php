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
        $banners = Banner::getBanners();
        $articles = Article::getLatestArticles();

        return view('user.top', compact('banners', 'articles'));
    }
}
