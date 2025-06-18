<?php

namespace App\Controllers\Transaction;


use App\Controllers\BaseController;

class Tagihan extends BaseController
{

    protected $sesi_mbti;
    public function __construct()
    {
        $sesi_mbti = new \App\Models\Global_m();
        $sesi_mbti->ceksesi();
    }


    public function index()
    {
        $data = new \App\Models\Transaction\Tagihan_m();
        $data = $data->data();
        $data["title"]="Tagihan";
        return view('Transaction/tagihan_v', $data);
    }
}
