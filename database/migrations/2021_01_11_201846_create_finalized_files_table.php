<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinalizedFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       
        Schema::create('finalized_files', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('woTask_id');
           // $table->unsignedBigInteger('proofedFile_id');
            $table->unsignedBigInteger('created_by');
            $table->string('type');
            $table->string('file_name');
            $table->longText('file');
            $table->string('extension');
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
        Schema::dropIfExists('finalized_files');
    }
}
