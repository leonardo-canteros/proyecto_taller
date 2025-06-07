<?php

namespace App\Models;
use CodeIgniter\Model;

class CarritoProductoModel extends Model
{
    protected $table = 'carrito_producto';
    protected $primaryKey = 'id_carrito_producto';
    protected $allowedFields = ['id_carrito', 'id_producto', 'cantidad'];

    public function getCarritoPorUsuario($id_usuario)
    {
        return $this->select('carrito_producto.*, producto.nombre, producto.precio')
            ->join('producto', 'producto.id_producto = carrito_producto.id_producto')
            ->join('carrito', 'carrito.id_carrito = carrito_producto.id_carrito')
            ->where('carrito.id_usuario', $id_usuario)
            ->findAll();
    }
}
