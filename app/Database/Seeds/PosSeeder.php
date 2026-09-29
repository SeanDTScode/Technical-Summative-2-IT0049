<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PosSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        $this->db->table('products')->insertBatch([
            ['name' => 'Wireless Mouse', 'price' => '599.00', 'stock_quantity' => 25, 'image' => null, 'created_at' => $now],
            ['name' => 'Mechanical Keyboard', 'price' => '2499.00', 'stock_quantity' => 15, 'image' => null, 'created_at' => $now],
            ['name' => 'USB-C Cable', 'price' => '299.00', 'stock_quantity' => 40, 'image' => null, 'created_at' => $now],
            ['name' => 'Web Camera', 'price' => '1899.00', 'stock_quantity' => 10, 'image' => null, 'created_at' => $now],
            ['name' => 'Laptop Stand', 'price' => '899.00', 'stock_quantity' => 20, 'image' => null, 'created_at' => $now],
        ]);

        $this->db->table('customers')->insertBatch([
            ['full_name' => 'Maria Santos', 'email' => 'maria@example.com', 'phone' => '09171234567', 'created_at' => $now],
            ['full_name' => 'John Reyes', 'email' => 'john@example.com', 'phone' => '09182345678', 'created_at' => $now],
            ['full_name' => 'Angela Cruz', 'email' => 'angela@example.com', 'phone' => '09193456789', 'created_at' => $now],
        ]);

        $this->db->table('users')->insert([
            'username' => 'admin',
            'full_name' => 'POS Administrator',
            'password' => password_hash('PosDemo123!', PASSWORD_DEFAULT),
            'avatar' => null,
            'created_at' => $now,
        ]);
    }
}

