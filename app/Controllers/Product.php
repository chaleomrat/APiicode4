<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\ProductModel;
use ResourceBundle;

class Product extends ResourceController
{
    use ResponseTrait;
    //get all product
    public function index()
    {
        $model = new ProductModel();
        $data['products'] = $model->orderBy('_id', 'DESC')->findAll();
        return $this->respond($data);
    }

    //get prod
    public function getProduct($id = null)
    {
        $model = new ProductModel();
        $data = $model->where('_id', $id)->first();
        if ($data) {
            return $this->respond($data);
        } else {
            return $this->failNotFound('No product found');
        }
    }

    //insert new product
    public function create()
    {
        $model = new ProductModel();
        $data = [
            "name" => $this->request->getVar('name'),
            "category" => $this->request->getVar('category'),
            "price" => $this->request->getVar('price'),
            "tags" => $this->request->getVar('tags'),

        ];
        $model->insert($data);
        $response = [
            'status' => 201,
            'error' => null,
            'message' => [
                'success' => 'Product created successfully'
            ]
        ];
        return $this->respond($response);
    }
    //update product
    public function update($id = null)
    {
        $model = new ProductModel();
        $data = [
            "name" => $this->request->getVar('name'),
            "category" => $this->request->getVar('category'),
            "price" => $this->request->getVar('price'),
            "tags" => $this->request->getVar('tags'),

        ];

        $model->update($id, $data);
        // by primary
        $response = [
            'status' => 201,
            'error' => null,
            'product' => $$data,
            'message' => [
                'success' => 'Product created successfully'
            ]
        ];
        return $this->respond($response);
    }

    public function delect($id = null)
    {

        $model = new ProductModel();
        $data = $model->find($id);
        if ($data) {
            $model->delete($id);
            $response = [
                'status' => 201,
                'error' => null,
                'message' => [
                    'success' => 'Product delect successfully'
                ]
            ];
            return $this->respond($response);
        } else {
            return $this->failNotFound('No Product ID');
        }
    }
}
