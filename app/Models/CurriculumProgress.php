<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Curriculum;

class CurriculumProgress extends Model
{
    use HasFactory;

    protected $table = 'curriculum_progress';

    protected $fillable = [
        'curriculum_id',
        'user_id',
        'clear_flg',
    ];

    /**
     * ユーザーとのリレーション
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * カリキュラムとのリレーション
     */
    public function curriculum()
    {
        return $this->belongsTo(CurriculumProgress::class, 'curriculum_id');
    }
}
