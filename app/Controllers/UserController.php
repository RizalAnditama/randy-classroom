<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelGuru;
use App\Models\ModelUser;

class UserController extends BaseController
{
    public function __construct()
    {
        helper([
            'form',
            'url',
            'number',
        ]);
    }

    public function login()
    {
        $data = [
            'title' => 'Login',
        ];

        if ($this->request->getMethod() == 'post') {
            $rules = [
                // 'name' => 'required|min_length[2]|max_length[255]|alpha_numeric_spaces',
                // 'username' => 'required|min_length[3]|max_length[20]|alpha_numeric',
                'email' => 'required|valid_email|is_exist[email]|validateUser[email,password]',
                'password' => 'required|min_length[8]',
            ];
            $errors = [
                // 'name' => [
                //     'required' => 'Nama tidak boleh kosong',
                //     'min_length' => 'Nama minimal 2 karakter',
                //     'max_length' => 'Nama maksimal 255 karakter',
                //     'alpha_numeric_spaces' => 'Nama hanya boleh berisi huruf, angka, dan spasi',
                // ],
                // 'username' => [
                //     'required' => 'Username tidak boleh kosong',
                //     'min_length' => 'Username minimal 3 karakter',
                //     'max_length' => 'Username maksimal 20 karakter',
                //     'alpha_numeric' => 'Username hanya boleh berisi huruf dan angka',
                // ], 
                'email' => [
                    'required' => 'Email tidak boleh kosong',
                    'valid_email' => 'Email tidak valid',
                    'is_exist' => 'Email tidak terdaftar',
                    'validateUser' => 'Email atau password salah',
                ],
                'password' => [
                    'required' => 'Password tidak boleh kosong',
                    'min_length' => 'Password minimal 8 karakter',
                ],
            ];

            if (!$this->validate($rules, $errors)) {
                $data['validation'] = $this->validator;
                return view('pages/login', $data);
            }

            $modelUser = new ModelUser();
            $data['user'] = $modelUser->where('email', $this->request->getVar('email'))->first();

            $this->setUserSession($data['user']);
            return redirect()->to(site_url('materi'));
        }

        return view('pages/login', $data);
    }

    public function register()
    {
        $modelGuru = new ModelGuru();
        $modelUser = new ModelUser();
        $data = [
            'title' => 'Register',
        ];

        if ($this->request->getMethod() == 'post') {
            $rules = [
                'name' => 'required|min_length[2]|max_length[255]|alpha_space',
                'username' => 'required|min_length[3]|max_length[20]|alpha_numeric|is_unique[user.username]',
                'email' => 'required|valid_email|is_unique[user.email]',
                'password' => 'required|min_length[8]',
                'password_confirm' => 'required|matches[password]',
            ];
            $errors = [
                'name' => [
                    'required' => 'Nama tidak boleh kosong',
                    'min_length' => 'Nama minimal 2 karakter',
                    'max_length' => 'Nama maksimal 255 karakter',
                    'alpha_space' => 'Nama hanya boleh berisi huruf dan spasi',
                ],
                'username' => [
                    'required' => 'Username tidak boleh kosong',
                    'min_length' => 'Username minimal 3 karakter',
                    'max_length' => 'Username maksimal 20 karakter',
                    'alpha_numeric' => 'Username hanya boleh berisi huruf dan angka',
                    'is_unique' => 'Username sudah terdaftar',
                ],
                'email' => [
                    'required' => 'Email tidak boleh kosong',
                    'valid_email' => 'Email tidak valid',
                    'is_unique' => 'Email sudah terdaftar',
                ],
                'password' => [
                    'required' => 'Password tidak boleh kosong',
                    'min_length' => 'Password minimal 8 karakter',
                ],
                'password_confirm' => [
                    'required' => 'Password harus dikonfirmasi kosong',
                    'matches' => 'Konfirmasi password harus sesuai'
                ],
            ];
            if (!$this->validate($rules, $errors)) {
                $data['validation'] = $this->validator;
            }

            $userData = [
                'name' => $this->request->getVar('name'),
                'username' => $this->request->getVar('username'),
                'email' => $this->request->getVar('email'),
                'password' => $this->request->getVar('password')
            ];

            $user = $modelGuru->where('email', $this->request->getVar('email'))->first();

            if (!$user) {
                $userData['role'] = 'murid';
            } else {
                $userData['role'] = 'guru';
            }

            $insert = $modelUser->insert($userData);

            $userData['id'] = $insert;

            $this->setUserSession($userData);

            return redirect()->to('materi');
        }

        return view('pages/register', $data);
    }

    /**
     * Set user session data
     *
     * @param array $user
     * @return boolean
     */
    public function setUserSession(array $user)
    {

        $data = [
            'user_id' => $user['id'],
            'user_name' => $user['name'],
            'username' => $user['username'],
            'user_email' => $user['email'],
            'user_role' => $user['role'],
            'isLoggedIn' => true,
        ];

        return session()->set($data);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->back();
    }
}
