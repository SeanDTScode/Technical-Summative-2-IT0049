<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserPasswordSeeder extends Seeder
{
    public function run()
    {
        $users = $this->db
            ->table('users')
            ->select('id')
            ->get()
            ->getResultArray();

        foreach ($users as $user) {
            $this->db->table('users')
                ->where('id', $user['id'])
                ->update([
                    'password' => password_hash(
                        'PosDemo123!',
                        PASSWORD_DEFAULT
                    ),
                ]);
        }
    }
}