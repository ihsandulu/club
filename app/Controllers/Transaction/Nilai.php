<?php

namespace App\Controllers\Transaction;


use App\Controllers\BaseController;

class Nilai extends BaseController
{

    protected $sesi_mbti;
    public function __construct()
    {
        $sesi_mbti = new \App\Models\Global_m();
        $sesi_mbti->ceksesi();
    }


    public function index()
    {
        $data = new \App\Models\Transaction\Nilai_m();
        $data = $data->data();
        $data["title"]="Penilaian";
        return view('Transaction/nilai_v', $data);
    }
}
