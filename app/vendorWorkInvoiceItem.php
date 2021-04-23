<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class vendorWorkInvoiceItem extends Model
{
    protected $table = 'vendor_work_invoice_item';

    public function vendorInvoice(){
        return $this->belongsTo('App\vendorInvoice');
    }
}
