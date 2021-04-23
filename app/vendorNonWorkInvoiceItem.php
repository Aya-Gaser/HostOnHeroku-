<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class vendorNonWorkInvoiceItem extends Model
{
    protected $table = 'vendor_non_work_invoice_item';

    public function vendorInvoice(){
        return $this->belongsTo('App\vendorInvoice');
    }
}
