<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliveryFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('delivery_files', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('wo_id'); 
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('stage_id');
            $table->unsignedBigInteger('sourceFile_id');
            $table->unsignedBigInteger('vendor_id');
            $table->string('file_name');
            $table->longText('file');
            $table->string('extension');
            $table->string('notes')->default("");
            $table->dateTime('deadline_difference');
            $table->boolean('isReceived')->default(false);
            $table->string('status');
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
        Schema::dropIfExists('delivery_files');
    }
}
