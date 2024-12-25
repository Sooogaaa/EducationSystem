<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curriculum extends Model
{
    use HasFactory;

    protected $table = 'curriculums';

    protected $fillable = [
        'title',
        'thumbnail',
        'description',
        'video_url',
        'alway_delivery_flg',
        'grade_id',
    ];


    public function deliveryTimes() {
        return $this->hasMany(DeliveryTime::class);
    }

    public function grade() {
        return $this->belongsTo(Grade::class);
    }

    public static function getAllCurriculums() {
        return self::all();
    }

    public static function getCurriculumById($id) {
        return self::find($id);
    }

    public static function getCurriculumsSchedule($gradeId, $startDate, $endDate) {
        // 指定された学年と一致するものを絞り込む
        $curriculums = Self::where('grade_id', $gradeId)
        ->where(function ($query) use ($startDate, $endDate) {
            // 常時公開フラグ
            $query->where('alway_delivery_flg', 1)
            // 配信期間が表示月内
            ->orWhere(function ($query) use ($startDate, $endDate) {
                $query->whereHas('deliveryTimes', function ($query) use ($startDate, $endDate) {
                    $query->where('delivery_from', '<=', $endDate) //配信開始日が検索範囲以前
                        ->where('delivery_to', '>=', $startDate);  //配信終了日が検索範囲以降
                });
            });
        })
        // 配信終了日が検索範囲の開始日以降である配信時間だけを取得
        ->with(['deliveryTimes' => function ($query) use ($startDate, $endDate) {
            $query->where('delivery_from', '<=', $endDate)
                ->where('delivery_to', '>=', $startDate);
        }])
        ->get();

        return $curriculums;
    }
}
