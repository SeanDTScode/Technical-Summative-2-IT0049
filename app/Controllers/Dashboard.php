<?php

namespace App\Controllers;

use App\Models\CustomerModel;
use App\Models\ProductModel;
use App\Models\SaleModel;
use App\Models\UserModel;

class Dashboard extends BaseController
{
    public function index()
    {
        return view('dashboard', [
            'productCount' => (new ProductModel())->countAllResults(),
            'customerCount' => (new CustomerModel())->countAllResults(),
            'userCount' => (new UserModel())->countAllResults(),
            'saleCount' => (new SaleModel())->countAllResults(),
        ]);
    }
}

