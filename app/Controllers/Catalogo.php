<?php

// app/Controllers/Catalogo.php
namespace App\Controllers;

use App\Models\ProductoModel;
use CodeIgniter\Controller;

class Catalogo extends Controller
{
   
  
        public function index()
        {
            $model = new \App\Models\ProductoModel();
            $productos = $model->findAll();

            return $this->response->setJSON($productos);
        }


    public function obtenerProductos()
    {
        $productoModel = new ProductoModel();
        $productos = $productoModel->where('estado', 1)->findAll();

        return $this->response->setJSON($productos);
    }
}
