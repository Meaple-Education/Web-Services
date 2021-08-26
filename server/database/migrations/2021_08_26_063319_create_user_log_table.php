<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_log', function (Blueprint $table) {
            $table->id();
            $table->longText('old_data')->nullable();
            $table->longText('new_data')->nullable();
            $table->text('description');
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->unsignedBigInteger('action_by')->nullable()->index();
            $table->unsignedBigInteger('admin_action_by')->nullable()->index();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('user')->onDelete('set null');
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
        Schema::dropIfExists('user_log');
    }
}
