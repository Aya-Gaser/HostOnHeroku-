<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImprovedFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('improved_files', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('deliveryFile_id');
            $table->unsignedBigInteger('created_by');
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
        Schema::dropIfExists('improved_files');
    }
}
