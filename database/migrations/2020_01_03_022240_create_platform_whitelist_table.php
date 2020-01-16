<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlatformWhitelistTable extends Migration
{
    private $table = 'platform_whitelist';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->mediumIncrements('id')->comment('PK');
            $table->unsignedSmallInteger('platform_id')->comment('平台Id(rel:platforms > id)');
            $table->string('ip', 46)->comment('允許Ip');
            $table->string('description', 30)->default('')->comment('Ip描述');
            $table->timestamps();

            $table->unique(['platform_id', 'ip'], 'uk_' . $this->table . '_1');
            $table->index('platform_id', 'idx_' . $this->table . '_1');
        });

        DB::statement("ALTER TABLE `".$this->table."` COMMENT '平台API串接IP白名單'");
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
