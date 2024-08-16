<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    // モデルに関連付けるテーブル
    protected $table = 'articles';

    // テーブルに関連付ける主キー
    protected $primaryKey = 'id';

    //リクエストされたIDをもとにProductsテーブルのレコードを1件取得
    public function findProductById($id) {
        return Article::find($id);
    }
}
