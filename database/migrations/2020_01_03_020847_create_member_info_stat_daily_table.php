<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberInfoStatDailyTable extends Migration
{
    private $table = 'member_info_stat_daily';
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
            $table->date('bet_at')->comment('統計日期(下注日期)');
            $table->unsignedDecimal('bet_total', 20, 4)->default(0)->comment('昨日下注點數總額');
            $table->unsignedDecimal('deposit_credit', 20, 4)->default(0)->comment('今日已儲值金額');
            $table->unsignedMediumInteger('transfer_interest')->default(0)->comment('今日已轉至平台利息');
            $table->unsignedDecimal('interest', 20, 10)->default(0)->comment('今日產生利息');
            $table->unsignedDecimal('closing_interest', 20, 10)->default(0)->comment('今日利息結餘');
            $table->timestamps();

            $table->unique(['member_id', 'bet_at'], 'uk_' . $this->table . '_1');
            $table->index(['bet_at', 'member_id', 'transfer_interest'], 'idx_' . $this->table . '_1');
        });

        DB::statement("ALTER TABLE `" . $this->table . "` COMMENT '會員每日儲值統計'");
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->table);
    }
}
