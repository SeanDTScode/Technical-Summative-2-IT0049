<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Users extends BaseController
{
    public function index()
    {
        return view('users/index', [
            'users' => (new UserModel())->orderBy('full_name', 'ASC')->findAll(),
        ]);
    }

    public function new()
    {
        return view('users/form', ['user' => null]);
    }

    public function create()
    {
        if (! $this->validate($this->rules())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = $this->postedData();
        $data['password'] = password_hash(
            (string) $this->request->getPost('password'),
            PASSWORD_DEFAULT
        );
        $data['created_at'] = date('Y-m-d H:i:s');

        $avatar = $this->saveAvatar();
        if ($avatar !== null) {
            $data['avatar'] = $avatar;
        }

        (new UserModel())->insert($data);

        return redirect()->to('/users')->with('message', 'Staff account created successfully.');
    }

    public function edit(int $id)
    {
        $user = (new UserModel())->find($id);
        if ($user === null) {
            throw PageNotFoundException::forPageNotFound('Staff account not found.');
        }

        return view('users/form', ['user' => $user]);
    }

    public function update(int $id)
    {
        $model = new UserModel();
        $user = $model->find($id);
        if ($user === null) {
            throw PageNotFoundException::forPageNotFound('Staff account not found.');
        }

        if (! $this->validate($this->rules($id))) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = $this->postedData();
        $newPassword = (string) $this->request->getPost('password');
        if ($newPassword !== '') {
            $data['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
        }

        $avatar = $this->saveAvatar();
        if ($avatar !== null) {
            $data['avatar'] = $avatar;
        }

        $model->update($id, $data);

        if ((int) session()->get('user_id') === $id) {
            session()->set([
                'username' => $data['username'],
                'full_name' => $data['full_name'],
            ]);
        }

        return redirect()->to('/users')->with('message', 'Staff account updated successfully.');
    }

    public function delete(int $id)
    {
        if ((int) session()->get('user_id') === $id) {
            return redirect()->to('/users')->with('error', 'You cannot delete your own active account.');
        }

        $model = new UserModel();
        $user = $model->find($id);
        if ($user === null) {
            throw PageNotFoundException::forPageNotFound('Staff account not found.');
        }

        try {
            $model->delete($id);
        } catch (\Throwable $exception) {
            return redirect()->to('/users')->with(
                'error',
                'This staff account appears in sales history and cannot be deleted.'
            );
        }

        if (! empty($user['avatar'])) {
            $path = FCPATH . 'uploads/avatars/' . basename($user['avatar']);
            if (is_file($path)) {
                unlink($path);
            }
        }

        return redirect()->to('/users')->with('message', 'Staff account deleted successfully.');
    }

    private function rules(?int $id = null): array
    {
        $usernameUnique = $id === null
            ? 'is_unique[users.username]'
            : 'is_unique[users.username,id,' . $id . ']';

        return [
            'username' => 'required|max_length[50]|' . $usernameUnique,
            'full_name' => 'required|max_length[100]',
            'password' => $id === null
                ? 'required|min_length[8]|max_length[255]'
                : 'permit_empty|min_length[8]|max_length[255]',
            'avatar' => 'permit_empty|is_image[avatar]|mime_in[avatar,image/jpeg,image/png]'
                . '|ext_in[avatar,jpg,jpeg,png]|max_size[avatar,2048]|max_dims[avatar,1200,1200]',
        ];
    }

    private function postedData(): array
    {
        return [
            'username' => trim((string) $this->request->getPost('username')),
            'full_name' => trim((string) $this->request->getPost('full_name')),
        ];
    }

    private function saveAvatar(): ?string
    {
        $avatar = $this->request->getFile('avatar');
        if ($avatar === null || ! $avatar->isValid() || $avatar->hasMoved()) {
            return null;
        }

        $directory = FCPATH . 'uploads/avatars';
        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $filename = $avatar->getRandomName();
        $avatar->move($directory, $filename);

        return $filename;
    }
}

