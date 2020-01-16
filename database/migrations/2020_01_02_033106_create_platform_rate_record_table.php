<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlatformRateRecordTable extends Migration
{
    private $table = 'platform_rate_record';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->smallIncrements('id')->comment('PK');
            $table->unsignedSmallInteger('platform_id')->comment('平台Id(rel:platforms > id)');
            $table->date('date_at')->comment('日期');
            $table->unsignedDecimal('present', 5, 2)->default(0)->comment('目前利率(%)');
            $table->unsignedDecimal('future', 5, 2)->default(0)->comment('預設利率(%)');
            $table->timestamps();

            $table->unique(['platform_id', 'date_at'], 'uk_' . $this->table . '_1');
        });

        DB::statement("ALTER TABLE `" . $this->table . "` COMMENT '平台利率紀錄'");
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
