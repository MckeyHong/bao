<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('PK');
            $table->string('email', 100)->comment('信箱');
            $table->timestamp('email_verified_at')->nullable()->comment('信箱驗證時間');
            $table->string('name', 20)->comment('名稱');
            $table->string('password', 60)->comment('密碼');
            $table->rememberToken();
            $table->timestamps();

            $table->unique('email', 'uk_users_1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
