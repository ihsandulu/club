<?php

namespace App\Controllers\Master;


use App\Controllers\BaseController;

class Muser extends BaseController
{

    protected $sesi_user;
    public function __construct()
    {
        $sesi_user = new \App\Models\Global_m();
        $sesi_user->ceksesi();
    }


    public function index()
    {
        $data = new \App\Models\Master\Muser_m();
        $data = $data->data();
        $data["posisi"] = "administrator";
        $data["title"]="Master User";
        return view('Master/muser_v', $data);
    }

    public function admin()
    {
        $data = new \App\Models\Master\Muser_m();
        $data = $data->data();
        $data["posisi"] = "admin";
        $data["title"]="Master Admin";
        return view('Master/muser_v', $data);
    }

    public function member()
    {
        $data = new \App\Models\Master\Muser_m();
        $data = $data->data();
        $data["posisi"] = "member";
        $data["title"]="Master Member";
        return view('Master/muser_v', $data);
    }
}
