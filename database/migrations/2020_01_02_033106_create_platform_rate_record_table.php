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
            $table->unsignedSmallInteger('platform_id')->comment('平台ID');
            $table->unsignedDecimal('present', 5, 2)->default(0)->comment('目前利率(%)');
            $table->timestamps();
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
