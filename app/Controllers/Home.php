<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return view('welcome_message');
    }

    function test()
    {

        $data['mahasiswa'] = $this->modelmahasiswa->select('*')->findall();
        dd($data['mahasiswa']);

        return view('mahasiswa/test', $data);
    }
}
