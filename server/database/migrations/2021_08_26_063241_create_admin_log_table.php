<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_log', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('old_data')->nullable();
            $table->longText('new_data')->nullable();
            $table->text('description');
            $table->unsignedBigInteger('admin_id')->nullable()->index();
            $table->unsignedBigInteger('action_by')->nullable()->index();
            $table->timestamps();

            $table->foreign('admin_id')->references('id')->on('admin')->onDelete('set null');
            $table->foreign('action_by')->references('id')->on('admin')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_log');
    }
}
