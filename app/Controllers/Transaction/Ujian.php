<?php

namespace App\Controllers\Transaction;


use App\Controllers\BaseController;

class Ujian extends BaseController
{

    protected $sesi_mbti;
    public function __construct()
    {
        $sesi_mbti = new \App\Models\Global_m();
        $sesi_mbti->ceksesi();
    }


    public function index()
    {
        $data = new \App\Models\Transaction\ujian_m();
        $data = $data->data();
        $data["title"]="Ujian";
        return view('Transaction/ujian_v', $data);
    }
}
