<?php
namespace App\Models;

use CodeIgniter\Model;

class CarritoProductoModel extends Model
{
    protected $table = 'carrito_productos';
    protected $primaryKey = 'id_carrito_producto';
    protected $allowedFields = ['id_carrito', 'id_producto', 'cantidad'];
    
    public function obtenerProductos($id_carrito)
    {
        return $this->select('carrito_productos.*, productos.nombre, productos.precio, productos.imagen')
                   ->join('productos', 'productos.id_producto = carrito_productos.id_producto')
                   ->where('id_carrito', $id_carrito)
                   ->findAll();
    }
    
    public function productoExiste($id_carrito, $id_producto)
    {
        return $this->where('id_carrito', $id_carrito)
                   ->where('id_producto', $id_producto)
                   ->first();
    }
}