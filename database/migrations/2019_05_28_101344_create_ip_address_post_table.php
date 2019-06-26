<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIpAddressPostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ip_address_post', function (Blueprint $table) {
            $table->integer('ip_address_post_id')->autoIncrement();
            $table->string('ip_address')->nullable();
            $table->integer('post')->nullable();
            $table->timestamp('date_time_accessed')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ip_address_post');
    }
}
