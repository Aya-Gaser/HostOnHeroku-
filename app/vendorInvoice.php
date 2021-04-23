<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class vendorInvoice extends Model
{
    protected $table = 'vendor_invoice';

    public function vendorWorkInvoiceItem(){
        return $this->hasMany('App\vendorWorkInvoiceItem','invoiceId');
     }

     public function vendorNonWorkInvoiceItem(){
        return $this->hasMany('App\vendorNonWorkInvoiceItem','invoiceId');
     }
}
