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

    public static function getCurriculumsSchedule($gradeId, $startDate, $endDate)
    {
        $query = self::with(['deliveryTimes' => function ($query) use ($startDate, $endDate) {
            $query->where(function ($query) use ($startDate, $endDate) {
                // 配信期間内
                $query->whereBetween('delivery_from', [$startDate, $endDate])
                    ->orWhereBetween('delivery_to', [$startDate, $endDate]);
            });
        }])

        // 表示学年で常時公開がON or 表示学年で配信期間が表示月内
        ->where(function ($query) use ($gradeId, $startDate, $endDate) {
            $query->where(function ($query) use ($gradeId) {
            // 表示学年
            $query->whereHas('grade', function ($query) use ($gradeId) {
                $query->where('id', $gradeId);
            })
            // 常時公開flgがON
            ->whereHas('deliveryTimes', function ($query) {
                $query->where('alway_delivery_flg', 1);
                });
            })

            // 学年が表示学年かつ配信期間が表示月内
            ->orWhere(function ($query) use ($gradeId, $startDate, $endDate) {
                $query->whereHas('grade', function ($query) use ($gradeId) {
                    $query->where('id', $gradeId);
                })
                ->whereHas('deliveryTimes', function ($query) use ($startDate, $endDate) {
                    $query->whereBetween('delivery_from', [$startDate, $endDate])
                        ->orWhereBetween('delivery_to', [$startDate, $endDate]);
                });
            });
        });

        return $query->get();
    }
}
