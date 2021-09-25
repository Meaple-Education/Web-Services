<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('auth_code')->unique();
            $table->text('image')->nullable();
            $table->string('phone')->nullable()->unique();
            $table->unsignedBigInteger('role_id')->nullable();
            $table->unsignedBigInteger('status')->default(1);
            $table->datetime('auth_created');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->datetime('last_login')->nullable();
            $table->boolean('email_verified')->default(0);
            $table->datetime('activated_at')->nullable();
            $table->timestamps();

            $table->index('role_id');
            $table->index('email');
            $table->index('status');
            $table->index('created_by');
            $table->index('created_at');

            $table->foreign('role_id')->references('id')->on('role')->onDelete('restrict');
            $table->foreign('created_by')->references('id')->on('admin')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin');
    }
}
