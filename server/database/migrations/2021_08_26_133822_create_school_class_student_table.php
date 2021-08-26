<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolClassStudentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_class_student', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_class_id')->nullable()->index();
            $table->unsignedBigInteger('school_student_id')->nullable()->index();
            $table->unsignedInteger('status')->default(1);
            $table->timestamps();

            $table->unique(['school_class_id', 'school_student_id'])->index();

            $table->foreign('school_class_id')->references('id')->on('school_class')->onDelete('restrict');
            $table->foreign('school_student_id')->references('id')->on('school_student')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('school_class_student');
    }
}
