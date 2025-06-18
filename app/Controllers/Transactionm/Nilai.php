<?php

namespace App\Controllers\Transactionm;


use App\Controllers\BaseController;

class Nilai extends BaseController
{

    protected $sesi_ist;
    public function __construct()
    {
        $sesi_ist = new \App\Models\Global_m();
        $sesi_ist->ceksesi();
    }


    public function index()
    {
        $data = new \App\Models\Transactionm\Nilai_m();
        $data = $data->data();
        return view('Transactionm/nilai_v', $data);
    }
}
