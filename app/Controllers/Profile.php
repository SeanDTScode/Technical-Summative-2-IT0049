<?php

namespace App\Controllers;

use App\Models\UserModel;

class Profile extends BaseController
{
    public function index()
    {
        return view('profile', [
            'user' => (new UserModel())
                ->orderBy('id', 'ASC')
                ->first(),
        ]);
    }
}

