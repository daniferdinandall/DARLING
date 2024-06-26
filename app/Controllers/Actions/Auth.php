<?php

namespace App\Controllers\Actions;

use App\Controllers\BaseController;
use App\Models\UsersModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;

class Auth extends BaseController
{
    protected $session;

    public function __construct()
    {
        $this->session = session();
    }

    public function register()
    {
        $rules = [
            'email'         => 'required|min_length[6]|max_length[100]|valid_email|is_unique[tb_users.email]',
            'fullname'      => 'required|min_length[3]|max_length[255]',
            'password'      => 'required|min_length[6]|max_length[255]',
            'konfirmasi_password'  => 'matches[password]'
        ];
         
        if($this->validate($rules)){
            $model = new UsersModel();
            $data = [
                'email'    => $this->request->getVar('email'),
                'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
                'role_id'     => 3,
                'fullname'    => $this->request->getVar('fullname'),
                'created_at'  => Time::now(),
                'updated_at'  => Time::now(),
            ];
            $model->save($data);
            return redirect()->to('auth/login');
        }else{
            $data['validation'] = $this->validator;
            return view('auth/register', $data);
        }
    }

    public function login()
    {
        $model = new UsersModel();
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');
        $data = $model->select('tb_users.*, tb_roles.name AS role_name')
              ->join('tb_roles', 'tb_roles.id = tb_users.role_id')
              ->where('tb_users.email', $email)
              ->first();
        if ($data) {
            $pass = $data['password'];
            $verify_pass = password_verify($password, $pass);
            $role = $data['role_name'];
            if ($verify_pass) {
                $ses_data = [
                    'id'              => $data['id'],
                    'role'            => $role,
                    'email'           => $data['email'],
                    'fullname'        => $data['fullname'],
                ];
                $this->session->set($ses_data);
                return redirect()->to("$role");
            } else {
                $this->session->setFlashdata('msg', 'Wrong Password');
                return redirect()->to('auth/login');
            }
        } else { 
            $this->session->setFlashdata('msg', 'Email not Found');
            return redirect()->to('auth/login');
        }
    }

    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('auth/login');
    }
}
