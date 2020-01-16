<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBalanceTransferTable extends Migration
{
    private $table = 'balance_transfer';

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
            $table->string('no', 50)->comment('單號');
            $table->unsignedTinyInteger('type')->default(1)->comment('轉帳狀態(1：轉入，2：轉出)');
            $table->unsignedDecimal('credit_before', 30, 10)->default(0)->comment('轉帳前額度');
            $table->unsignedDecimal('credit', 30, 10)->default(0)->comment('轉帳額度');
            $table->unsignedDecimal('credit_after', 30, 10)->default(0)->comment('轉帳後額度');
            $table->string('memo', 50)->default('')->comment('參照資訊');
            $table->timestamps();

            $table->unique(['platform_id', 'no'], 'uk_' . $this->table . '_1');
        });

        DB::statement("ALTER TABLE `".$this->table."` COMMENT '會員平台間轉帳紀錄'");
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
