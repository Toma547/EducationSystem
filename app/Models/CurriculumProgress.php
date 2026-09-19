<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurriculumProgress extends Model
{
    protected $fillable = [
        'user_id',
        'curriculum_id',
        'clear_flg',
    ];
}
