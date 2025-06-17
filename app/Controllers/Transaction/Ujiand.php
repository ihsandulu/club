<?php

namespace App\Controllers\Transaction;


use App\Controllers\BaseController;

class Ujiand extends BaseController
{

    protected $sesi_mbti;
    public function __construct()
    {
        $sesi_mbti = new \App\Models\Global_m();
        $sesi_mbti->ceksesi();
    }


    public function index()
    {
        $data = new \App\Models\Transaction\ujiand_m();
        $data = $data->data();
        $data["title"]="Poin Penilaian";
        return view('Transaction/ujiand_v', $data);
    }
}
