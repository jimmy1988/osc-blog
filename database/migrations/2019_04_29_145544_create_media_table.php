<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media', function (Blueprint $table) {
            $table->integer('media_id')->autoIncrement();
            $table->string('media_title')->unique();
            $table->string('media_file_name')->unique();
            $table->string('media_file_type');
            $table->string('media_file_extension');
            $table->integer('media_type');
            $table->string('media_alt_text')->nullable();
            $table->mediumText('media_description')->nullable();
            $table->integer('media_uploaded_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('media');
    }
}
