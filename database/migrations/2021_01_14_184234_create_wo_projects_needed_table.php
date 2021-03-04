<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWoProjectsNeededTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('wo_tasks_needed');
        Schema::create('wo_tasks_needed', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('wo_id');
            $table->string('type');
            $table->integer('client_wordsCount')->default(0);
            $table->string('client_rateUnit');
            $table->float('client_rateValue');
            $table->string('vendor_suggest_rateUnit')->nullable();
            $table->float('vendor_suggest_rateValue')->default(0);
            $table->boolean('has_proofAndFinalize');
            $table->string('status')->default('pending');
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
        Schema::dropIfExists('wo_projects_needed');
    }
}
