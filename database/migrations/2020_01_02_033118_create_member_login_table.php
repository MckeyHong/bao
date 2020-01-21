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
            $table->unsignedSmallInteger('platform_id')->comment('平台Id(rel:platforms > id)');
            $table->unsignedBigInteger('member_id')->comment('會員Id(rel:members > id)');
            $table->string('member_account', 30)->comment('會員帳號(rel:members > account)');
            $table->string('member_name', 30)->comment('會員名稱(rel:members > name)');
            $table->string('login_ip', 46)->comment('登入Ip');
            $table->unsignedTinyInteger('device')->default(2)->comment('使用裝置(1：電腦，2：手機)');
            $table->json('device_info')->nullable()->comment('裝置詳細資訊');
            $table->string('area', 50)->nullable()->comment('地區');
            $table->timestamps();

            $table->index(['created_at'], 'idx_' . $this->table . '_1');
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
