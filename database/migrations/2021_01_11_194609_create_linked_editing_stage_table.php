<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinkedEditingStageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('linked_editing_stage', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('project_id');
            $table->dateTime('delivery_deadline');
            $table->dateTime('G1_acceptance_deadline');
            $table->dateTime('G2_acceptance_deadline');
            $table->float('vendor_rate');
            $table->bigInteger('words_count');
           // $table->longText('instructions')->nullable();
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
        Schema::dropIfExists('linked_editing_stage');
    }
}
