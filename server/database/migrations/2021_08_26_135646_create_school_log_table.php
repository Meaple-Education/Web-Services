<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_log', function (Blueprint $table) {
            $table->id();
            $table->longText('old_data')->nullable();
            $table->longText('new_data')->nullable();
            $table->text('description');
            $table->unsignedBigInteger('school_id')->nullable()->index();
            $table->unsignedBigInteger('action_by')->nullable()->index();
            $table->unsignedBigInteger('admin_action_by')->nullable()->index();
            $table->timestamps();

            $table->foreign('school_id')->references('id')->on('school')->onDelete('set null');
            $table->foreign('action_by')->references('id')->on('user')->onDelete('set null');
            $table->foreign('admin_action_by')->references('id')->on('admin')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('school_log');
    }
}
