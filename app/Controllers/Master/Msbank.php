<?php

namespace App\Controllers\Master;


use App\Controllers\BaseController;

class Msbank extends BaseController
{

    protected $sesi_sbank;
    public function __construct()
    {
        $sesi_sbank = new \App\Models\Global_m();
        $sesi_sbank->ceksesi();
    }


    public function index()
    {
        $data = new \App\Models\Master\Msbank_m();
        $data = $data->data();
        return view('Master/msbank_v', $data);
    }
}
