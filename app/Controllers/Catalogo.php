<?php

// app/Controllers/Catalogo.php
namespace App\Controllers;

use App\Models\ProductoModel;
use CodeIgniter\Controller;

class Catalogo extends Controller
{
    public function index()
    {
        return view('catalogo');
    }

    public function obtenerProductos()
    {
        $productoModel = new ProductoModel();
        $productos = $productoModel->where('estado', 1)->findAll();

        return $this->response->setJSON($productos);
    }
}
