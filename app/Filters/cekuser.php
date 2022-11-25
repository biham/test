<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Ceklogin implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()) {
            return redirect()->to('/login/index');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
