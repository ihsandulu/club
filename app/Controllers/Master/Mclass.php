<?php

namespace App\Controllers\Master;


use App\Controllers\BaseController;

class Mclass extends BaseController
{

    protected $sesi_class;
    public function __construct()
    {
        $sesi_class = new \App\Models\Global_m();
        $sesi_class->ceksesi();
    }


    public function index()
    {
        $data = new \App\Models\Master\Mclass_m();
        $data = $data->data();
        return view('Master/mclass_v', $data);
    }
}
