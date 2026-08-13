<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class GradesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        $grades = [
            '小学校1年生',
            '小学校2年生',
            '小学校3年生',
            '小学校4年生',
            '小学校5年生',
            '小学校6年生',
            '中学校1年生',
            '中学校2年生',
            '中学校3年生',
            '高校1年生',
            '高校2年生',
            '高校3年生',
        ];

        foreach ($grades as $name) {
            DB::table('grades')->insert([
                'name' => $name,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
        
    }
}
