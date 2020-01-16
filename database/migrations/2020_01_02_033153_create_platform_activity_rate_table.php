<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlatformActivityRateTable extends Migration
{
    private $table = 'platform_activity_rate';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedSmallInteger('platform_id')->comment('平台Id(rel:platforms > id)');
            $table->date('start_at')->comment('活動開始日期');
            $table->date('end_at')->comment('活動結束日期');
            $table->unsignedDecimal('rate', 5, 2)->comment('活動利率%');
            $table->unsignedTinyInteger('active')->default(1)->comment('狀態(1：啟用，2：停用)');
            $table->timestamps();

            $table->index('platform_id', 'idx_' . $this->table . '_1');
        });

        DB::statement("ALTER TABLE `" . $this->table . "` comment '平台活動利率'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->table);
    }
}
