<?php

namespace App\Controllers;

use App\Models\Muser;

class Auth extends BaseController
{

    public function __construct()
    {
        $this->muser = new Muser();
    }

    public function index()
    {

        //$session = \Config\Services::session();
        //var_dump($this->session->get()); die();
        return view('login');
    }


    public function login()
    {
        $arrresult = array();
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        //echo "<pre>"; print_r(md5($password)); echo "</pre>";
        $arrwhere = array(
            'email' => $email
        );

        // $user = $this->muser->where($arrwhere)->get()
        //     ->getRowObject();

        $user = $this->muser->getuser($arrwhere)->getRowObject();
       //  echo "<pre>"; var_dump($user); echo "</pre>"; die();

        if (count((array)$user) > 0) {

            if (md5($password) == $user->password) {

                $newdata = [
                    'username'  => $user->username,
                    'email'     => $user->email,
                    'nomer'     => $user->nomer,
                    'role'      => $user->role_name,
                    'logged_in' => TRUE
                ];
                session()->set($newdata);
                $arrdata = array(
                    'last_login' => date("Y-m-d H:i:s")
                );


             //  dd(session()->get('role'));

                $this->muser->update($user->userid, $arrdata);

                $arrresult = array(
                    'valid' => true,
                    'message' => 'Anda berhasil login',
                    'redirect' => 'admin'
                );
            } else {
                $arrresult = array(
                    'valid' => false,
                    'message' => 'password anda salah'
                );
            }
        } else {
            $arrresult = array(
                'valid' => false,
                'message' => 'Nomer anda tidak ditemukan'
            );
        }

        echo json_encode($arrresult);
    }


    public function logout()
    {
        session()->destroy();


        // echo "<pre>"; print_r(session()->getFlashdata('message_header')); echo "</pre>"; die();
        //return view('coba');
        set_header_message('danger', 'Logout', 'Anda berhasil Logout');
        return redirect()->to('/Auth');
    }

    public function coba()
    {
        return view('coba');
    }
}
