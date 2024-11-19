<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Article extends Model
{
    use HasFactory;

    // モデルに関連付けるテーブル
    protected $table = 'articles';

    // テーブルに関連付ける主キー
    protected $primaryKey = 'id';

    // 登録・更新可能なカラムの指定
    protected $fillable = [
        'title',
        'posted_date',
        'article_contents',        
    ];

    //Articlesテーブルのレコード全件取得
    public function searchArticle($request) {
        return Article::all();
    }

    //リクエストされたIDをもとにArticlesテーブルのレコードを1件取得
    public function findArticleById($id) {
        return Article::find($id);
    }    

    //新規登録処理
    public function insertArticle($request) {
        DB::beginTransaction();

        try{
            //リクエストデータを基に商品情報を登録する
            $result = $this->create([
                'posted_date' => $request->posted_date,
                'title' => $request->title,
                'article_contents' => $request->article_contents
            ]);

            DB::commit();
            return $result;

        } catch (\Exception $e) {
            DB::rollback();
            return back();
        }        
    }

    //更新処理
    public function fillArticle($request, $id) {
        DB::beginTransaction();

        try{
            //更新対象のデータ取得
            $update = Article::find($id);

            //リクエストデータを基に商品情報を更新する
            $result = $update->fill([
                'posted_date' => $request->posted_date,
                'title' => $request->title,
                'article_contents' => $request->article_contents
            ])->save();

            DB::commit();
            return $result;

        } catch (\Exception $e) {
            DB::rollback();
            return back();
        }        
    }

    //削除処理
    public function deleteArticle($id) {
        DB::beginTransaction();

        try{
            $result = $this->destroy($id);
            DB::commit();
            return $result;

        } catch (\Exception $e) {
            DB::rollback();
            return back();
        }
    }    
}
