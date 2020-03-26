<?php

namespace MayIFit\Core\Permission\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoleUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_user', function (Blueprint $table) {
            $table->unsignedBigInteger('role_id')->references('id')->on('roles');
            $table->unsignedBigInteger('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('created_by')->references('id')->on('users')->default(1);;
            $table->unsignedBigInteger('updated_by')->nullable()->references('id')->on('users');
            $table->primary(['role_id', 'user_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_user');
    }
}
