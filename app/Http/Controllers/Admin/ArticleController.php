<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Article;

class ArticleController extends Controller
{
    public function __construct(Article $article) {
        $this->article = $article;
    } 

    //お知らせ新規登録画面表示
    public function showArticleCreate(Request $request) {
        return view('article_create');
    }
    
    //お知らせ新規登録処理
    public function storeArticle(Request $request) {
        $validatedData = $request->validate([
            'posted_date' => 'required|date',
            'title' => 'required|max:255',
            'article_contents' => 'required',
        ], [
            'posted_date.required' => '投稿日時は必須入力項目です。',
            'posted_date.date' => '投稿日時は日付の形式で入力してください。',
            'title.required' => 'タイトルは必須入力項目です。',
            'title.max' => 'タイトルは255文字以内で入力してください。',
            'article_contents.required' => '本文は必須入力項目です。',
        ]);

        $registerArticle = $this->article->insertArticle($request);
        return redirect()->route('show.article.create');
    }
    
    //お知らせ編集画面表示
    public function showArticleEdit($id) {
        $article = $this->article->findArticleById($id);
        return view('article_create', compact('article'));
    }

    //お知らせ編集処理
    public function updateArticle(Request $request, $id) {
        $validatedData = $request->validate([
            'posted_date' => 'required|date',
            'title' => 'required|max:255',
            'article_contents' => 'required',
        ], [
            'posted_date.required' => '投稿日時は必須入力項目です。',
            'posted_date.date' => '投稿日時は日付の形式で入力してください。',
            'title.required' => 'タイトルは必須入力項目です。',
            'title.max' => 'タイトルは255文字以内で入力してください。',
            'article_contents.required' => '本文は必須入力項目です。',
        ]);

        $updateArticle = $this->article->fillArticle($request, $id);
        return redirect()->route('show.article.edit', ['id'=> $id]);
    }
}
