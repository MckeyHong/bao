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
            $table->string('code', 20)->comment('平台代碼');
            $table->string('name', 30)->comment('平台名稱');
            $table->unsignedDecimal('present', 5, 2)->default(0)->comment('目前利率(%)');
            $table->unsignedDecimal('future', 5, 2)->default(0)->comment('預設利率(%)');
            $table->unsignedTinyInteger('active')->default(1)->comment('狀態(1：啟用，2：停用)');
            $table->string('api_key', 36)->comment('平台APIkey');
            $table->string('encrypt_key', 16)->comment('平台加密key');
            $table->timestamps();

            $table->unique(['code'], 'uk_' . $this->table . '_1');
            $table->unique(['api_key', 'encrypt_key'], 'uk_' . $this->table . '_2');
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
