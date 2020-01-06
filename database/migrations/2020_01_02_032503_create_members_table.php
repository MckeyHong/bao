<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    private $table = 'members';
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
            $table->string('account', 30)->comment('帳號');
            $table->string('password', 60)->comment('密碼');
            $table->string('name', 30)->default('')->comment('名稱');
            $table->decimal('credit', 30, 10)->default(0)->comment('餘額寶錢包額度');
            $table->unsignedDecimal('today_deposit', 20, 4)->default(0)->comment('今日已儲值金額');
            $table->unsignedDecimal('interest', 20, 10)->default(0)->comment('利息');
            $table->longText('token')->comment('登入Token');
            $table->unsignedTinyInteger('active')->default(1)->comment('狀態(1：啟用，2：停用)');
            $table->string('last_session', 40)->default('')->comment('登入session id');
            $table->timestamps();

            $table->unique(['platform_id', 'account'], 'uk_' . $this->table . '_1');
            $table->index('platform_id', 'idx_' . $this->table . '_1');
        });

        DB::statement("ALTER TABLE `" . $this->table . "` COMMENT '會員資訊'");
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
