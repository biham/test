<?php

namespace App\Controllers;

class Layout extends BaseController
{
    public function index()
    {

        $data = [
            'mhs' => $this->mhs->count(),
            'dsn' => $this->dsn->count(),

        ];

        return view('layout/beranda', $data);
    }
}
