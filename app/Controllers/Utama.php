<?php

namespace App\Controllers;



class Utama extends BaseController
{

    protected $sesi_user;
    public function __construct()
    {
        $sesi_user = new \App\Models\Global_m();
        $sesi_user->ceksesi();
    }

    public function index()
    {
        if (session()->position_id == 0) {
            return view('utama1_v');
        } else {
            return view('utama_v');
        }
    }

    public function logout()
    {
        $this->session->destroy();
        return redirect()->to(base_url("login?message=Terimakasih telah menggunakan aplikasi kami !"));
    }

    public function login()
    {
        $data = new \App\Models\Login_m();
        $data = $data->index();
        if ($data['masuk'] == 1) {
            return redirect()->to(base_url('?message=' . $data["hasil"]));
        }
        return view('login_v', $data);
    }
}
