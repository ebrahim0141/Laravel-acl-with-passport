<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUrlToRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('url_to_roles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('url_id');
            $table->unsignedBigInteger('role_id');
            $table->timestamps();

            $table->foreign('url_id')->references('id')->on('urls')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('url_to_roles');
    }
}
