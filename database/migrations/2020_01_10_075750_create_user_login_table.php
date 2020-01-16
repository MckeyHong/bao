<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserLoginTable extends Migration
{
    private $table = 'user_login';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->increments('id')->comment('PK');
            $table->unsignedSmallInteger('user_id')->default(0)->comment('後台帳號Id(rel:users > id)');
            $table->string('user_account', 30)->default('')->comment('後台帳號(rel:users > account)');
            $table->string('user_name', 30)->default('')->comment('後台帳號名稱(rel:users > name)');
            $table->string('login_ip', 46)->default('')->comment('登入Ip');
            $table->string('area', 50)->default('')->comment('地區');
            $table->unsignedTinyInteger('status')->default(1)->comment('狀態(1:登入成功, 2:正常登出, 3:強制登出, 4:登入失敗)');
            $table->timestamps();

            $table->index(['user_id', 'created_at'], 'idx_' . $this->table . '_1');
        });

        DB::statement("ALTER TABLE `" . $this->table . "` COMMENT '後台登入日誌'");
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
