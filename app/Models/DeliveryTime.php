<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryTime extends Model
{
    protected $table = 'delivery_times';

    protected $fillable = [
        'curriculums_id',
        'delivery_from',
        'delivery_to',
    ];

    // （必要ならキャスト）
    protected $casts = [
        'delivery_from' => 'datetime',
        'delivery_to'   => 'datetime',
    ];

    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class, 'curriculums_id');
    }
}


