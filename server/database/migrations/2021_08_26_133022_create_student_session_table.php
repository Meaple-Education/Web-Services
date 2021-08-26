<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentSessionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_session', function(Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('identifier');
            $table->string('ip')->nullable();
            $table->string('browser')->nullable();
            $table->string('os')->nullable();
            $table->string('reject_ip')->nullable();
            $table->string('reject_browser')->nullable();
            $table->string('reject_os')->nullable();
            $table->boolean('is_verify')->default(0);
            $table->unsignedBigInteger('wrong_attempted')->default(0);
            $table->boolean('is_valid')->default(1);
            $table->datetime('last_login');
            $table->timestamps();

            $table->index('parent_id');
            $table->foreign('parent_id')->references('id')->on('student')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_session');
    }
}
