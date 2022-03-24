<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('auth_code')->unique()->nullable();
            $table->text('image')->nullable();
            $table->string('phone')->nullable()->unique();
            $table->unsignedBigInteger('status')->default(1);
            $table->datetime('auth_created')->nullable();
            $table->datetime('last_login')->nullable();
            $table->boolean('email_verified')->default(0);
            $table->datetime('activated_at')->nullable();
            $table->timestamps();

            $table->index('email');
            $table->index('status');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student');
    }
}
