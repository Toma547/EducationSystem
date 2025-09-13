<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     *  お知らせ一覧
     */
    public function index()
    {
        // 投稿日が新しい順に並べる
        $articles = Article::orderBy('posted_date', 'desc')->get();

        return view('user.layouts.article_index', compact('articles'));
    }

    /**
     *  お知らせ詳細
     */
    public function show($id)
    {
        $article = Article::findOrFail($id);

        return view('user.layouts.article', compact('article'));
    }
}
