<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserOperationTable extends Migration
{
    private $table = 'user_operation';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->increments('id')->comment('PK');
            $table->unsignedSmallInteger('user_id')->default(0)->comment('後台帳號Id (rel:users > id)');
            $table->string('user_account', 30)->default('')->comment('後台帳號 (rel:users > account)');
            $table->string('user_name', 30)->default('')->comment('後台帳號名稱 (rel:users > name)');
            $table->string('ip', 46)->default('')->comment('操作者IP');
            $table->unsignedSmallInteger('func_key')->default(0)->comment('功能Key');
            $table->unsignedBigInteger('func_id')->default(0)->comment('功能Id');
            $table->unsignedTinyInteger('type')->default(1)->comment('狀態(1:新增,2:編輯修改,3:刪除)');
            $table->string('targets', 100)->comment('操作對象');
            $table->text('content')->comment('操作內容');
            $table->timestamps();

            $table->index(['user_id', 'func_key', 'created_at'], 'idx_' . $this->table . '_1');
            $table->index(['func_key', 'func_id', 'type'], 'idx_' . $this->table . '_2');
        });

        DB::statement("ALTER TABLE `" . $this->table . "` COMMENT '後台操作日誌'");
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
