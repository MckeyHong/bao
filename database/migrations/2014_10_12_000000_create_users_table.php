<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    private $table = 'users';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->bigIncrements('id')->comment('PK');
            $table->unsignedSmallInteger('role_id')->default(0)->comment('角色Id(rel:roles > id)');
            $table->string('account', 30)->comment('帳號');
            $table->string('password', 60)->comment('密碼');
            $table->string('name', 30)->default('')->comment('名稱');
            $table->unsignedTinyInteger('active')->default(1)->comment('狀態(1：啟用，2：停用)');
            $table->rememberToken();
            $table->timestamps();
            $table->unique('account', 'uk_' . $this->table . '_1');
        });
        DB::statement("ALTER TABLE `" . $this->table . "` COMMENT '後台帳號資訊'");
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
