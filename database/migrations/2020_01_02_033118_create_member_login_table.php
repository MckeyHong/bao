<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberLoginTable extends Migration
{
    private $table = 'member_login';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->bigIncrements('id')->comment('PK');
            $table->unsignedSmallInteger('platform_id')->comment('平台ID');
            $table->unsignedBigInteger('member_id')->comment('會員ID');
            $table->string('member_account', 30)->comment('會員帳號');
            $table->string('member_name', 50)->comment('會員暱稱');
            $table->string('login_ip', 46)->comment('登入IP');
            $table->unsignedTinyInteger('device')->default(2)->comment('使用裝置(1：電腦，2：手機)');
            $table->json('device_info')->nullable()->comment('裝置詳細資訊');
            $table->string('area', 50)->nullable()->comment('地區');
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `".$this->table."` COMMENT '會員登入紀錄'");
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