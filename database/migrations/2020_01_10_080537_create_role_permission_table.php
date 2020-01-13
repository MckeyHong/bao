<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolePermissionTable extends Migration
{
    private $table = 'role_permission';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->mediumIncrements('id')->comment('PK');
            $table->unsignedSmallInteger('role_id')->default(0)->comment('角色Id');
            $table->string('path', 50)->comment('功能路徑');
            $table->unsignedTinyInteger('is_get')->default(1)->comment('瀏覽狀態(1：啟用，2：停用)');
            $table->unsignedTinyInteger('is_post')->default(1)->comment('新增狀態(1：啟用，2：停用)');
            $table->unsignedTinyInteger('is_put')->default(1)->comment('編輯修改狀態(1：啟用，2：停用)');
            $table->unsignedTinyInteger('is_delete')->default(1)->comment('刪除狀態(1：啟用，2：停用)');
            $table->timestamps();

            $table->unique(['role_id', 'path'], 'uk_' . $this->table . '_1');
            $table->index('role_id', 'idx_' . $this->table . '_1');
        });

        DB::statement("ALTER TABLE `" . $this->table . "` COMMENT '後台權限角色功能設定'");
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
