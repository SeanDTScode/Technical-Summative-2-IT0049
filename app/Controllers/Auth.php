<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function loginForm()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/tasks');
        }

        return view('auth/login');
    }

    public function login()
    {
        if (! $this->validate([
            'username' => 'required|max_length[50]',
            'password' => 'required',
        ])) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $username = trim(
            (string) $this->request->getPost('username')
        );

        $password = (string) $this->request->getPost('password');

        $user = (new UserModel())
            ->where('username', $username)
            ->first();

        if (
            $user === null
            || empty($user['password'])
            || ! password_verify($password, $user['password'])
        ) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Invalid username or password.');
        }

        session()->regenerate(true);

        session()->set([
            'user_id' => $user['id'],
            'username' => $user['username'],
            'full_name' => $user['full_name'],
            'isLoggedIn' => true,
        ]);

        return redirect()->to('/tasks');
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to('/login');
    }
}

