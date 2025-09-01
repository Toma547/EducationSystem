<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curriculum extends Model
{
    use HasFactory;

    // テーブル名を明示
    protected $table = 'curriculums';

    protected $fillable = [
        'title',
        'grade',
        'content'
    ];
    // content は授業の本文やURLなどを格納想定

    public function progresses()
    {
        return $this->hasMany(CurriculumProgress::class);
    }
}
