<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Users extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();

        return view('users/index', [
            'users' => $userModel
                ->orderBy('id', 'ASC')
                ->findAll(),
        ]);
    }

    public function new()
    {
        return view('users/new');
    }

    public function create()
    {
        $rules = [
            'username' => [
                'rules' => 'required|max_length[50]'
                    . '|is_unique[users.username]',
                'errors' => [
                    'required'  => 'The username is required.',
                    'is_unique' => 'That username is already taken.',
                ],
            ],

            'full_name' => [
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => 'The full name is required.',
                ],
            ],

            'password' => [
                'rules' => 'required|min_length[8]|max_length[255]',
                'errors' => [
                    'required'   => 'The password is required.',
                    'min_length' => 'The password must be at least 8 characters.',
                ],
            ],
        ];

        if (! $this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'errors',
                    $this->validator->getErrors()
                );
        }

        $userModel = new UserModel();

        $userModel->insert([
            'username' => trim(
                (string) $this->request->getPost('username')
            ),

            'password' => password_hash(
                (string) $this->request->getPost('password'),
                PASSWORD_DEFAULT
            ),

            'full_name' => trim(
                (string) $this->request->getPost('full_name')
            ),

            'avatar'     => null,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()
            ->to('/users')
            ->with(
                'message',
                'User created successfully.'
            );
    }

    public function edit(int $id)
    {
        $userModel = new UserModel();
        $user = $userModel->find($id);

        if ($user === null) {
            throw PageNotFoundException::forPageNotFound(
                'User not found.'
            );
        }

        return view('users/edit', [
            'user' => $user,
        ]);
    }

    public function update(int $id)
    {
        $userModel = new UserModel();
        $user = $userModel->find($id);

        if ($user === null) {
            throw PageNotFoundException::forPageNotFound(
                'User not found.'
            );
        }

        $rules = [
            'username' => [
                'rules' => 'required|max_length[50]'
                    . '|is_unique[users.username,id,' . $id . ']',
                'errors' => [
                    'required'  => 'The username is required.',
                    'is_unique' => 'That username is already taken.',
                ],
            ],

            'full_name' => [
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => 'The full name is required.',
                ],
            ],

            'password' => [
                'rules' => 'permit_empty|min_length[8]|max_length[255]',
                'errors' => [
                    'min_length' => 'The password must be at least 8 characters.',
                ],
            ],

            'avatar' => [
                'rules' => 'permit_empty'
                    . '|is_image[avatar]'
                    . '|mime_in[avatar,image/jpeg,image/png]'
                    . '|ext_in[avatar,jpg,jpeg,png]'
                    . '|max_size[avatar,2048]',
                'errors' => [
                    'is_image' => 'The avatar must be a valid image.',
                    'mime_in'  => 'Only JPG and PNG images are allowed.',
                    'ext_in'   => 'Only JPG and PNG files are allowed.',
                    'max_size' => 'The avatar must not exceed 2MB.',
                ],
            ],
        ];

        if (! $this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'errors',
                    $this->validator->getErrors()
                );
        }

        $data = [
            'username' => trim(
                (string) $this->request->getPost('username')
            ),

            'full_name' => trim(
                (string) $this->request->getPost('full_name')
            ),
        ];

        $newPassword = (string) $this->request->getPost(
            'password'
        );

        if ($newPassword !== '') {
            $data['password'] = password_hash(
                $newPassword,
                PASSWORD_DEFAULT
            );
        }

        $avatar = $this->request->getFile('avatar');

        if (
            $avatar !== null
            && $avatar->isValid()
            && ! $avatar->hasMoved()
        ) {
            $uploadPath = FCPATH . 'uploads/avatars';

            if (! is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            $filename = $avatar->getRandomName();

            $avatar->move(
                $uploadPath,
                $filename
            );

            $data['avatar'] = $filename;
        }

        $userModel->update($id, $data);

        return redirect()
            ->to('/users')
            ->with(
                'message',
                'User updated successfully.'
            );
    }
}