<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\Curriculum;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;


class CurriculumController extends Controller
{
    public function showCurriculumList(Request $request) {
        // リストのデータを取得
        $yearMonth = $request->input('month', date('Y-m'));
        $gradeId = $request->input('grade_id', 1); // デフォルトで1を設定
        // 学年データを取得
        $grade = Grade::find($gradeId);
        if(!$grade) {
            Log::warning('指定された学年が見つかりません。', ['gradeId' => $gradeId]);

            return response()->json(['error' => '指定された学年が見つかりません。'], 404);
        }

        $curriculums = Curriculum::getAllCurriculums();
        return view('user.curriculum_list', compact('yearMonth', 'gradeId', 'curriculums'));
    }

    // 年月の解析　月の開始日と終了日を取得
    public function schedules($yearMonth, $gradeId, Request $request){
        try {
            $startDate = Carbon::createFromFormat('Y-m', $yearMonth)->startOfMonth();
            $endDate = Carbon::createFromFormat('Y-m', $yearMonth)->endOfMonth();
        } catch (\Exception $e) {
            return response()->json(['error' => '日付の習得に失敗しました。'], 400);
        }

        // カリキュラムの取得
        $curriculumsAll = Curriculum::getCurriculumsSchedule($gradeId, $startDate, $endDate);

        // スケジュールデータの作成
        $schedules = [];
        $hasExpiredSchedules = false;

        foreach ($curriculumsAll as $curriculum) {
            foreach ($curriculum->deliveryTimes as $deliveryTime) {
                try {
                    // 配信開始、終了時間をcarbonインスタンスに変換
                    $deliveryFrom = $deliveryTime->delivery_from instanceof \Carbon\Carbon
                        ? $deliveryTime->delivery_from
                        : Carbon::parse($deliveryTime->delivery_from);
                    $deliveryTo = $deliveryTime->delivery_to instanceof \Carbon\Carbon
                        ? $deliveryTime->delivery_to
                        : Carbon::parse($deliveryTime->delivery_to);

                    // 常時公開フラグの処理
                    if ($curriculum->alway_delivery_flg == 1) {
                        $schedules[] = [
                            'title' => $curriculum->title,
                            'thumbnail' => $curriculum->thumbnail,
                            'date' => $deliveryFrom ? $deliveryFrom->format('n月j日') : '常時公開',
                            'time' => $deliveryFrom && $deliveryTo
                                        ? $deliveryFrom->format('H:i') . '〜' . $deliveryTo->format('H:i')
                                        :'常時公開',
                            'isExpired' => false,
                            'alway_delivery_flg' => $deliveryTime->alway_delivery_flg,
                        ];

                    } elseif (!$deliveryTo || Carbon::now()->lessThanOrEqualTo($deliveryTo)) {
                        // 配信期間内
                        $schedules[] = [
                            'title' => $curriculum->title,
                            'thumbnail' => $curriculum->thumbnail,
                            'date' => $deliveryFrom ? $deliveryFrom->format('n月j日') : '未設定',
                            'time' => $deliveryFrom && $deliveryTo
                                        ? $deliveryFrom->format('H:i') . '〜' . $deliveryTo->format('H:i')
                                        :'未設定',
                            'isExpired' => false,
                            'alway_delivery_flg' => $deliveryTime->alway_delivery_flg,
                        ];
                        } else {
                            $hasExpiredSchedules = true;
                        }
                } catch (\Exception $e) {
                    Log::error('スケジュールデータの取得に失敗しました。', ['error' => $e->getMessage()]);
            }
        }
    }

    // スケジュールがない場合の処理
    if (empty($schedules) && $hasExpiredSchedules) {
        return response()->json(['message' => '配信期限が過ぎました。'], 200);
        } elseif (empty($schedules)) {
            return response()->json(['message' => 'スケジュールがありません。'], 200);
        }

        return response()->json($schedules);

    }

    public function logout(Request $request) {
        auth()->guard('user')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('user/auth/login');
    }
}
