<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorWorkInvoiceItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('vendor_work_invoice_item');
        Schema::create('vendor_work_invoice_item', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('stageId');
            $table->unsignedBigInteger('invoiceId');
            $table->dateTime('completion_date')->nullable();
            $table->string('rate_unit');
            $table->integer('unit_count');
            $table->float('rate');
            $table->float('amount');
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
        Schema::dropIfExists('vendor_work_invoice_item');
    }
}
