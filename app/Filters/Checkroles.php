<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Checkroles implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // /d(session()->get('role'));
      //  dd(in_array(session()->get('role'), $arguments));
        if (!in_array(session()->get('role'), $arguments)) {
            //dd("masuk sini");
            return redirect()->to(base_url('Auth'));
        }
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
