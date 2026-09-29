<?php

namespace App\Controllers;

use App\Models\ProductModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Products extends BaseController
{
    public function index()
    {
        return view('products/index', [
            'products' => (new ProductModel())->orderBy('name', 'ASC')->findAll(),
        ]);
    }

    public function new()
    {
        return view('products/form', ['product' => null]);
    }

    public function create()
    {
        if (! $this->validate($this->rules())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = $this->postedData();
        $filename = $this->saveImage();
        if ($filename !== null) {
            $data['image'] = $filename;
        }
        $data['created_at'] = date('Y-m-d H:i:s');

        (new ProductModel())->insert($data);

        return redirect()->to('/products')->with('message', 'Product created successfully.');
    }

    public function edit(int $id)
    {
        $product = (new ProductModel())->find($id);
        if ($product === null) {
            throw PageNotFoundException::forPageNotFound('Product not found.');
        }

        return view('products/form', ['product' => $product]);
    }

    public function update(int $id)
    {
        $model = new ProductModel();
        $product = $model->find($id);
        if ($product === null) {
            throw PageNotFoundException::forPageNotFound('Product not found.');
        }

        if (! $this->validate($this->rules())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = $this->postedData();
        $filename = $this->saveImage();
        if ($filename !== null) {
            $data['image'] = $filename;
        }

        $model->update($id, $data);

        return redirect()->to('/products')->with('message', 'Product updated successfully.');
    }

    public function delete(int $id)
    {
        $model = new ProductModel();
        $product = $model->find($id);
        if ($product === null) {
            throw PageNotFoundException::forPageNotFound('Product not found.');
        }

        try {
            $model->delete($id);
        } catch (\Throwable $exception) {
            return redirect()->to('/products')->with(
                'error',
                'This product appears in sales history and cannot be deleted.'
            );
        }

        if (! empty($product['image'])) {
            $path = FCPATH . 'uploads/products/' . basename($product['image']);
            if (is_file($path)) {
                unlink($path);
            }
        }

        return redirect()->to('/products')->with('message', 'Product deleted successfully.');
    }

    private function rules(): array
    {
        return [
            'name' => 'required|max_length[100]',
            'price' => 'required|decimal|greater_than_equal_to[0]',
            'stock_quantity' => 'required|integer|greater_than_equal_to[0]',
            'image' => 'permit_empty|is_image[image]|mime_in[image,image/jpeg,image/png]'
                . '|ext_in[image,jpg,jpeg,png]|max_size[image,2048]|max_dims[image,1600,1600]',
        ];
    }

    private function postedData(): array
    {
        return [
            'name' => trim((string) $this->request->getPost('name')),
            'price' => number_format((float) $this->request->getPost('price'), 2, '.', ''),
            'stock_quantity' => (int) $this->request->getPost('stock_quantity'),
        ];
    }

    private function saveImage(): ?string
    {
        $image = $this->request->getFile('image');
        if ($image === null || ! $image->isValid() || $image->hasMoved()) {
            return null;
        }

        $directory = FCPATH . 'uploads/products';
        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $filename = $image->getRandomName();
        $image->move($directory, $filename);

        return $filename;
    }
}

