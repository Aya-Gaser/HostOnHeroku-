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
            $table->integer('G1_acceptance_hours'); 
            $table->integer('G2_acceptance_hours'); 
            $table->dateTime('G1_acceptance_deadline'); 
            $table->dateTime('G2_acceptance_deadline');
            $table->unsignedBigInteger('vendor_id')->nullable();
           // $table->float('vendor_rate');
            $table->string('vendor_rateUnit');
            $table->float('vendor_rate');
            $table->integer('vendor_wordsCount')->default(0);
            $table->integer('vendor_qualityPoints')->default(0);
            $table->integer('required_docs');
            $table->integer('accepted_docs')->default(0);
            $table->dateTime('deadline');
            $table->longText('instructions')->default('None');; 
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
