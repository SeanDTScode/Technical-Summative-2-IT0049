<?php

namespace App\Controllers;

use App\Models\CustomerModel;
use App\Models\ProductModel;
use App\Models\SaleModel;

class Sales extends BaseController
{
    public function index()
    {
        return view('sales/index', [
            'sales' => (new SaleModel())->history(),
        ]);
    }

    public function new()
    {
        return view('sales/new', [
            'products' => (new ProductModel())
                ->where('stock_quantity >', 0)
                ->orderBy('name', 'ASC')
                ->findAll(),
            'customers' => (new CustomerModel())->orderBy('full_name', 'ASC')->findAll(),
        ]);
    }

    public function create()
    {
        $rules = [
            'product_id' => 'required|integer|is_not_unique[products.id]',
            'customer_id' => 'permit_empty|integer|is_not_unique[customers.id]',
            'quantity' => 'required|integer|greater_than[0]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $productId = (int) $this->request->getPost('product_id');
        $quantity = (int) $this->request->getPost('quantity');
        $customerValue = trim((string) $this->request->getPost('customer_id'));
        $customerId = $customerValue === '' ? null : (int) $customerValue;
        $staffId = (int) session()->get('user_id');

        $db = db_connect();
        $db->transBegin();

        try {
            $product = $db->query(
                'SELECT id, name, price, stock_quantity FROM products WHERE id = ? FOR UPDATE',
                [$productId]
            )->getRowArray();

            if ($product === null) {
                throw new \RuntimeException('The selected product no longer exists.');
            }

            if ($quantity > (int) $product['stock_quantity']) {
                throw new \DomainException(
                    'Only ' . $product['stock_quantity'] . ' unit(s) of ' . $product['name'] . ' are available.'
                );
            }

            $unitCents = (int) round((float) $product['price'] * 100);
            $totalPrice = number_format(($unitCents * $quantity) / 100, 2, '.', '');

            $updated = $db->table('products')
                ->where('id', $productId)
                ->update([
                    'stock_quantity' => (int) $product['stock_quantity'] - $quantity,
                ]);

            $inserted = $db->table('sales')->insert([
                'product_id' => $productId,
                'customer_id' => $customerId,
                'sold_by' => $staffId,
                'quantity' => $quantity,
                'total_price' => $totalPrice,
                'created_at' => date('Y-m-d H:i:s'),
            ]);

            if (! $updated || ! $inserted) {
                throw new \RuntimeException('The sale could not be saved.');
            }

            $db->transCommit();
        } catch (\DomainException $exception) {
            $db->transRollback();
            return redirect()->back()->withInput()->with('error', $exception->getMessage());
        } catch (\Throwable $exception) {
            $db->transRollback();
            log_message('error', 'Sale recording failed: {message}', ['message' => $exception->getMessage()]);
            return redirect()->back()->withInput()->with('error', 'The sale could not be recorded. Please try again.');
        }

        return redirect()->to('/sales')->with('message', 'Sale recorded and stock updated successfully.');
    }
}

