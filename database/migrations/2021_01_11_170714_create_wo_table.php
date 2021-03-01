<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    
    public function up()
    {
        Schema::dropIfExists('wo');
        Schema::create('wo', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('client_id');
            $table->timestamp('deadline');
            //$table->float('client_rate'); 
            $table->string('po_number');            
            //$table->integer('quality_points');
            $table->string('from_language');
            $table->string('to_language');
            $table->string('client_instructions')->default('None');
            $table->string('general_instructions')->default('None');
            $table->boolean('isHandeled')->default(0); 
            $table->boolean('isReceived')->default(0);
            $table->integer('sent_docs');
            $table->unsignedBigInteger('created_by');
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
        Schema::dropIfExists('wo');
    }
}
