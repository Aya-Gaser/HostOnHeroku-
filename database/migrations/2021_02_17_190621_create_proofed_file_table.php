<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProofedFileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proofed_file', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('woTask_id');
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('sourceFile_id');
            $table->unsignedBigInteger('created_by');
            $table->string('type');
            $table->string('file_name');
            $table->longText('file');
            $table->string('extension');
            $table->string('note')->default('None');

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
        Schema::dropIfExists('proofed_file');
    }
}
