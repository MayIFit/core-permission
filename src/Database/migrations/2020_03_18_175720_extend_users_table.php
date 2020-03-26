<?php

namespace MayIFit\Core\Permission\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PermissionExtendUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('real_name')->nullable();
            $table->unsignedBigInteger('created_by')->references('id')->on('users')->default(1);
            $table->unsignedBigInteger('updated_by')->references('id')->on('users')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['profile', 'created_by', 'updated_by']);
            $table->dropSoftDeletes();
        });
    }
}
