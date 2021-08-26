<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKeyValueInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('key_value_info', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('key_value_id')->nullable()->index();
            $table->unsignedBigInteger('language_id')->nullable()->index();
            $table->text('value')->nullable();
            $table->timestamps();

            $table->foreign('key_value_id')->references('id')->on('key_value')->onDelete('restrict');
            $table->foreign('language_id')->references('id')->on('language')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('key_value_info');
    }
}
