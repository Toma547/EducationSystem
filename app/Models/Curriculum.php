<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Curriculum extends Model
{
    use HasFactory;

    public static function getAvailableGrades()
    {
        $grades = DB::table('grades')
            ->whereIn('id', function ($query) {
                $query->select('grade_id')
                      ->from('classes_clear_checks')
                      ->where('clear_flg', 1);
            })
            ->get();

        foreach ($grades as $grade) {
            if (Str::startsWith($grade->name, '小学校')) {
                $grade->class = 'elementary';
            } elseif (Str::startsWith($grade->name, '中学校')) {
                $grade->class = 'junior';
            } elseif (Str::startsWith($grade->name, '高校')) {
                $grade->class = 'high';
            } else {
                $grade->class = '';
            }
        }
        return $grades;
    }

    public static function getCurriculumsByGrades($gradeId)
    {
        return DB::table('curriculums')
            ->where('grade_id', $gradeId)
            ->get();
    }

    public static function getDeliveryTimes($curriculumIds, $startMonth, $endMonth)
    {
        return DB::table('delivery_times')
            ->whereBetween('delivery_from', [$startMonth, $endMonth])
            ->whereIn('curriculums_id', $curriculumIds)
            ->get()
            ->groupBy('curriculums_id');
    }

    public static function filterVisibleCurriculums($curriculums, $deliveryTimes)
    {
        return $curriculums->filter(function ($curriculum) use ($deliveryTimes) {
            if ($curriculum->alway_delivery_flg == 1) {
                return true;
            }
            return isset($deliveryTimes[$curriculum->id]) && $deliveryTimes[$curriculum->id]->isNotEmpty();
        });
    }

    public static function formatDeliveryTimes($visibleCurriculums, $deliveryTimes)
    {
        $format = [];

        foreach ($deliveryTimes as $curriculumId => $times) {
            if (!$visibleCurriculums->pluck('id')->contains($curriculumId)) continue;

            $format[$curriculumId] = collect($times)->map(function ($time) {
                $from = Carbon::parse($time->delivery_from)->format('n月j日 H:i');
                $to = Carbon::parse($time->delivery_to)->format('H:i');
                return "{$from} ~ {$to}";
            })->take(4);
        }
        return $format;
    }
}
