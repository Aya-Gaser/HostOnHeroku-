<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectStagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   
    public function up()
    {
        Schema::create('project_stages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('wo_id');
            $table->unsignedBigInteger('project_id');
            $table->boolean('lastIn_project');
            $table->string('type'); 
            $table->timestamps('G1_acceptance_deadline');
            $table->timestamps('G2_acceptance_deadline');
            $table->unsignedBigInteger('vendor_id')->nullable();
            $table->integer('required_docs');
            $table->integer('accepted_docs');
            $table->dateTime('deadline');
            $table->longText('instructions')->nullable(); 
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
        Schema::dropIfExists('project_stages');
    }
}
