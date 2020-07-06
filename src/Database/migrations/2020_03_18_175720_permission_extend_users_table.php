<?php

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
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('real_name')->nullable();
                $table->string('avatar')->nullable();
                $table->string('about')->nullable();
                $table->string('provider')->nullable();
                $table->string('provider_id')->nullable();
                $table->boolean('approved')->default(false);
                $table->foreignId('created_by')->nullable()->references('id')->on('users');
                $table->foreignId('updated_by')->nullable()->references('id')->on('users');
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn(['real_name', 'created_by', 'updated_by', 'avatar', 'about', 'provider', 'provider_id']);
                $table->dropSoftDeletes();
            });
        }
    }
}
