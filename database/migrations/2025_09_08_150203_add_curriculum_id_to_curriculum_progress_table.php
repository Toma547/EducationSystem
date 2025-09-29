<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('curriculum_progress', function (Blueprint $table) {
            // 一旦 null 許容で追加（既存データがあるので必須）
            $table->unsignedBigInteger('curriculum_id')->nullable()->after('user_id');

            // 外部キー制約を後で追加
            $table->foreign('curriculum_id')
                  ->references('id')
                  ->on('curriculums')
                  ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('curriculum_progress', function (Blueprint $table) {
            $table->dropForeign(['curriculum_id']);
            $table->dropColumn('curriculum_id');
        });
    }
};
