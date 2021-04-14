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
            $table->id();
            $table->string('wx_open_id')->nullable()->comment('Wechat Open ID');
            $table->string('wx_union_id')->nullable()->comment('Wechat Union ID');

            $table->string('nickname')->nullable()->comment('Nickname');
            $table->string('realname')->nullable()->comment('Realname');
            $table->string('gender')->nullable()->comment('Gender');
            $table->string('bio')->nullable()->comment('Bio');
            $table->string('avatar')->default('images/users/default-avatar.jpg')->comment('User Avatar');
            $table->string('cover')->default('images/users/default-cover.jpg')->comment('Profile Cover');

            $table->string('phone')->nullable()->comment('Phone');
            $table->string('email')->nullable()->comment('Email');
            $table->string('password')->nullable()->comment('Password');

            $table->boolean('is_admin')->default(0)->comment('Is Admin');
            $table->tinyInteger('ugc_safety_level')->default(0)->comment('UGC Safety Level');

            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
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
