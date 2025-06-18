<?php

namespace App\Controllers\Transactionm;


use App\Controllers\BaseController;

class Pay extends BaseController
{

    protected $sesi_ist;
    public function __construct()
    {
        $sesi_ist = new \App\Models\Global_m();
        $sesi_ist->ceksesi();
    }


    public function index()
    {
        $data = new \App\Models\Transactionm\Pay_m();
        $data = $data->data();
        return view('Transactionm/pay_v', $data);
    }
}
