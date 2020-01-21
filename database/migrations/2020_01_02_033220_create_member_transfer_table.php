<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberTransferTable extends Migration
{
    private $table = 'member_transfer';
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
            $table->unsignedTinyInteger('type')->default(1)->comment('異動類型(1:轉入、2:轉出、3:系統結算、4:系統轉出)');
            $table->decimal('credit_before', 30, 10)->default(0)->comment('異動前額度');
            $table->decimal('credit', 30, 10)->default(0)->comment('轉換額度');
            $table->decimal('credit_after', 30, 10)->default(0)->comment('異動後額度');
            $table->unsignedDecimal('interest', 20, 10)->default(0)->comment('產生利息');
            $table->unsignedDecimal('rate', 5, 2)->default(0)->comment('目前利率(%)');
            $table->timestamps();

            $table->index(['created_at'], 'idx_' . $this->table . '_1');
            $table->index(['platform_id', 'member_id', 'created_at'], 'idx_' . $this->table . '_2');
        });

        DB::statement("ALTER TABLE `" . $this->table . "` COMMENT '會員餘額寶儲值歷程'");
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
