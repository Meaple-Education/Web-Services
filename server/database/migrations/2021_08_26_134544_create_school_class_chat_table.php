<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolClassChatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_class_chat', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_class_id')->nullable()->index();
            $table->unsignedBigInteger('school_teacher_id')->nullable()->index();
            $table->unsignedBigInteger('school_class_student_id')->nullable()->index();
            $table->text('message')->nullable();
            $table->text('attachement')->nullable();
            $table->unsignedInteger('status')->default(1);
            $table->timestamps();

            $table->foreign('school_class_id')->references('id')->on('school_class')->onDelete('restrict');
            $table->foreign('school_teacher_id')->references('id')->on('school_teacher')->onDelete('restrict');
            $table->foreign('school_class_student_id')->references('id')->on('school_class_student')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('school_class_chat');
    }
}
