<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   
    public function up()
    {
        Schema::dropIfExists('projects');
        Schema::create('projects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('wo_id');
            $table->unsignedBigInteger('woTask_id');
            //$table->integer('numInWo');
            $table->string('name');
            $table->string('type');
            $table->dateTime('delivery_deadline');
            $table->boolean('isReadyToProof')->default(false);
            $table->boolean('isReadyToFinalize')->default(false);
           // $table->longText('instructions')->nullable(); instructions_editing
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('translator_id')->default(0);
            $table->unsignedBigInteger('editor_id')->default(0);
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
        Schema::dropIfExists('projects');
    }
}
