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
        Schema::create('projects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('wo_id');
            $table->integer('numInWo');
            $table->string('name');
            $table->string('type');
            $table->dateTime('delivery_deadline');
            $table->float('vendor_rate');
           // $table->longText('instructions')->nullable(); instructions_editing
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('translator_id')->nullable();
            $table->unsignedBigInteger('editor_id')->nullable();
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
