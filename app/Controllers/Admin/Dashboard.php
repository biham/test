<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;


class Dashboard extends BaseController
{
    public function index()
    {
        $data = [
            $this->mhs->count()
        ];

        return view('layout/beranda', $data);
    }
}
