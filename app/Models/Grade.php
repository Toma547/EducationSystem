<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    // カリキュラムとのリレーション（1対多）
    public function curriculums()
    {
        return $this->hasMany(Curriculum::class, 'grade_id');
    }
}
