<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    private $table = 'roles';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->smallIncrements('id')->comment('PK');
            $table->string('name', 20)->comment('名稱');
            $table->unsignedTinyInteger('active')->default(1)->comment('狀態(1：啟用，2：停用)');
            $table->timestamps();

            $table->unique('name', 'uk_' . $this->table . '_1');
        });

        DB::statement("ALTER TABLE `" . $this->table . "` COMMENT '後台周權限角色管理'");
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
