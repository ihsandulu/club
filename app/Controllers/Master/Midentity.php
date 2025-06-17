<?php

namespace App\Controllers\Master;


use App\Controllers\BaseController;

class Midentity extends BaseController
{

    protected $sesi_user;
    public function __construct()
    {
        $sesi_user = new \App\Models\Global_m();
        $sesi_user->ceksesi();
    }


    public function index()
    {
        $data = new \App\Models\Master\Midentity_m();
        $data = $data->data();
        return view('Master/midentity_v', $data);
    }
}
