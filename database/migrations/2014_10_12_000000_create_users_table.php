<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Hash;

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
            $table->integer('user_id')->autoIncrement();
            $table->string('user_first_name');
            $table->string('user_surname');
            $table->string('user_email')->unique();
            $table->string('user_email_verify_token')->unique();
            $table->dateTime('email_verified_at')->nullable();
            $table->string('user_password');
            $table->string('password_reset_token')->nullable()->unique();
            $table->dateTime('password_reset_token_last_sent')->nullable();
            $table->dateTime('password_last_reset')->nullable();
            $table->rememberToken();
            $table->mediumText('user_profile_image');
            $table->integer('user_level')->default(0);
            $table->integer('user_status')->default(1);
            $table->timestamp('user_created')->useCurrent();
            $table->dateTime('user_last_updated')->nullable();
            $table->dateTime('user_deleted')->nullable();
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
