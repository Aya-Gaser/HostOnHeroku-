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
        Schema::create('wo', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('client_id');
            $table->timestamp('deadline');
            $table->float('client_rate'); 
            $table->bigInteger('words_count');            
            $table->integer('quality_points');
            $table->string('from_language');
            $table->string('to_language');
            $table->string('client_instructions')->nullable();
            $table->longText('general_instructions')->nullable();
            $table->boolean('isHandeled'); 
            $table->boolean('isReceived')->default(0);
            $table->unsignedBigInteger('created_by_id');
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
