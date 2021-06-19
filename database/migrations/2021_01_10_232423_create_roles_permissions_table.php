<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
/// php artisan migrate:refresh --path=/database/migrations/2021_01_11_202857_create_clients_table.php
//2021_02_01_221424_create_wo_files_table
class CreateRolesPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('roles_permissions');
        Schema::create('roles_permissions', function (Blueprint $table) {
            $table->bigIncrements('id'); 
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('permission_id');

             //FOREIGN KEY CONSTRAINTS
             $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
             $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');

             //SETTING THE PRIMARY KEYS
            // $table->primary(['role_id','permission_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles_permissions');
    }
}
