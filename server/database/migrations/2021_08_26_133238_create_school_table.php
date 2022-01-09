<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school', function (Blueprint $table) {
            $table->id();
            $table->text('logo')->nullable();
            $table->string('name');
            $table->unsignedTinyInteger('status')->default(1);
            $table->text('description')->nullable();
            $table->text('address')->nullable();
            $table->text('phone_numbers')->nullable();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('user')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('school');
    }
}
