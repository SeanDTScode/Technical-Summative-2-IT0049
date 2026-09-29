<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DemoUserPasswordSeeder extends Seeder
{
    public function run()
    {
        $user = $this->db
            ->table('users')
            ->select('id')
            ->orderBy('id', 'ASC')
            ->get(1)
            ->getRowArray();

        if ($user !== null) {
            $this->db
                ->table('users')
                ->where('id', $user['id'])
                ->update([
                    'password' => password_hash(
                        'TaskDemo123!',
                        PASSWORD_DEFAULT
                    ),
                ]);
        }
    }
}

