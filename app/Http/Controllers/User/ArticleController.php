<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Article;

class ArticleController extends Controller
{
    public function __construct() {
        $this->article = new Article();
    }

    //お知らせ内容表示
    public function showArticle($id) {
        $article = $this->article->findArticleById($id);
        return view('user/article', compact('article'));
    }
}
