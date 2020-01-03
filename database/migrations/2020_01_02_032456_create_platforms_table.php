<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlatformsTable extends Migration
{
    private $table = 'platforms';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->smallIncrements('id')->comment('PK');
            $table->string('name', 20)->comment('平台名稱');
            $table->unsignedDecimal('present', 5, 2)->default(0)->comment('目前利率(%)');
            $table->unsignedDecimal('future', 5, 2)->default(0)->comment('預設利率(%)');
            $table->unsignedTinyInteger('active')->default(1)->comment('狀態(1：啟用，2：停用)');
            $table->json('api_info')->nullable()->comment('串接資訊');
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `" . $this->table . "` COMMENT '平台資訊'");
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
