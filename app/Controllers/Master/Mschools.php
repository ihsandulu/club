<?php

namespace App\Controllers\Master;


use App\Controllers\BaseController;

class Mschools extends BaseController
{

    protected $sesi_schools;
    public function __construct()
    {
        $sesi_schools = new \App\Models\Global_m();
        $sesi_schools->ceksesi();
    }


    public function index()
    {
        $data = new \App\Models\Master\Mschools_m();
        $data = $data->data();
        // dd($data);
        return view('Master/mschools_v', $data);
    }
}
