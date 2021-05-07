<?php

namespace App\Http\Controllers\invoice;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class invoiceReportsController extends Controller
{
    public function __construct()
      {
          $this->middleware('auth');
      } 
}
