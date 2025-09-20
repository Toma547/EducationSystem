<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreArticleRequest;
use App\Http\Requests\Admin\UpdateArticleRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Article;
use Carbon\Carbon;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     // 一覧表示
    public function index()
    {
        $articles = Article::orderBy('posted_date', 'desc')->get();
        return view('admin.layouts.article_list', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

     // 新規作成フォーム
    public function create()
    {
        return view('admin.layouts.article_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     // 保存処理
    public function store(StoreArticleRequest $request)
    {
        DB::transaction(function() use ($request) {
            Article::create($request->validated());
        });
        
        return redirect()
            ->route('admin.articles.index')
            ->with('success', 'お知らせを登録しました');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //public function show($id)
    //{
        //
    //}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    // 編集フォーム 
    public function edit($id)
    {
        $article = Article::findOrFail($id);
        return view('admin.layouts.article_edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    // 更新処理 
    public function update(UpdateArticleRequest $request, $id)
    {
        DB::transaction(function() use ($request, $id) {
            $article = Article::findOrFail($id);
            $article->update($request->validated());
        });

        return redirect()
            ->route('admin.articles.index')
            ->with('success', 'お知らせを更新しました');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    // 削除処理 
    public function destroy($id)
    {
        DB::transaction(function() use ($id) {
            $article = Article::findOrFail($id);
            $article->delete();
        });

        return redirect()
            ->route('admin.articles.index')
            ->with('success', 'お知らせを削除しました');
    }
}
