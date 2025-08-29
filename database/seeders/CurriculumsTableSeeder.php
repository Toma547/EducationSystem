<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurriculumsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 学年リスト（12ブロック）
        $grades = [
            '小学校1年生', '小学校2年生', '小学校3年生',
            '小学校4年生', '小学校5年生', '小学校6年生',
            '中学校1年生', '中学校2年生', '中学校3年生',
            '高校1年生', '高校2年生', '高校3年生'
        ];

        foreach ($grades as $gradeId => $gradeName) {
            for ($i = 1; $i <= 5; $i++) { //各学年 5授業固定
                DB::table('curriculums')->insert([
                    'grade_id'   => $gradeId,
                    'title'   => "授業タイトル{$i}", //固定タイトル
                    'thumbnail' => 'noimage.png', 
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }        
    }
}
