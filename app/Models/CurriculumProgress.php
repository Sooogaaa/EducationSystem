<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use SebastianBergmann\CodeUnit\FunctionUnit;

class CurriculumProgress extends Model
{
    use HasFactory;

    protected $table = 'curriculum_progress';

    protected $fillable = [
        'curriculum_id',
        'users_id',
        'clear_flg',
        'created_at',
        'updated_at'
    ];

    public Function curriculums() {
        return $this->belongsTo(Curriculum::class);
    }

    public function getClearflg($id) {
        $user_id = Auth::id();
        return DB::table('curriculum_progress')
        ->where('curriculums_id', $id)
        ->where('users_id', $user_id)
        ->value('clear_flg');
    }

    public function updateClearflg($id) {
        $user_id = Auth::id();

        CurriculumProgress::updateOrCreate([
            'curriculums_id' => $id,
            'users_id' => $user_id
        ],
        [
            'Clear_flg' => 1,
        ]);
    }
}
