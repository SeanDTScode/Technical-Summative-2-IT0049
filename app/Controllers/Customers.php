<?php

namespace App\Controllers;

use App\Models\CustomerModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Customers extends BaseController
{
    public function index()
    {
        return view('customers/index', [
            'customers' => (new CustomerModel())->orderBy('full_name', 'ASC')->findAll(),
        ]);
    }

    public function new()
    {
        return view('customers/form', ['customer' => null]);
    }

    public function create()
    {
        if (! $this->validate($this->rules())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        (new CustomerModel())->insert($this->postedData() + ['created_at' => date('Y-m-d H:i:s')]);

        return redirect()->to('/customers')->with('message', 'Customer created successfully.');
    }

    public function edit(int $id)
    {
        $customer = (new CustomerModel())->find($id);
        if ($customer === null) {
            throw PageNotFoundException::forPageNotFound('Customer not found.');
        }

        return view('customers/form', ['customer' => $customer]);
    }

    public function update(int $id)
    {
        $model = new CustomerModel();
        if ($model->find($id) === null) {
            throw PageNotFoundException::forPageNotFound('Customer not found.');
        }

        if (! $this->validate($this->rules($id))) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model->update($id, $this->postedData());

        return redirect()->to('/customers')->with('message', 'Customer updated successfully.');
    }

    public function delete(int $id)
    {
        $model = new CustomerModel();
        if ($model->find($id) === null) {
            throw PageNotFoundException::forPageNotFound('Customer not found.');
        }

        $model->delete($id);

        return redirect()->to('/customers')->with('message', 'Customer deleted successfully.');
    }

    private function rules(?int $id = null): array
    {
        $unique = $id === null
            ? 'is_unique[customers.email]'
            : 'is_unique[customers.email,id,' . $id . ']';

        return [
            'full_name' => 'required|max_length[100]',
            'email' => 'required|valid_email|max_length[100]|' . $unique,
            'phone' => 'permit_empty|max_length[20]',
        ];
    }

    private function postedData(): array
    {
        return [
            'full_name' => trim((string) $this->request->getPost('full_name')),
            'email' => strtolower(trim((string) $this->request->getPost('email'))),
            'phone' => trim((string) $this->request->getPost('phone')) ?: null,
        ];
    }
}

