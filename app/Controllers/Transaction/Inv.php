<?php

namespace App\Controllers\Transaction;


use App\Controllers\BaseController;

class Inv extends BaseController
{

    protected $sesi_mbti;
    public function __construct()
    {
        $sesi_mbti = new \App\Models\Global_m();
        $sesi_mbti->ceksesi();
    }


    public function index()
    {
        $data = new \App\Models\Transaction\inv_m();
        $data = $data->data();
        $data["title"]="Peinvan";
        return view('Transaction/inv_v', $data);
    }
}
