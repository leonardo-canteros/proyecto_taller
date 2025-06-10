<?php
namespace App\Models;
use CodeIgniter\Model;

class CarritoProductoModel extends Model
{
    protected $table = 'carrito_producto';
    protected $primaryKey = 'id_carrito_producto';
    protected $allowedFields = ['id_carrito', 'id_producto', 'cantidad'];
    protected $useAutoIncrement = true;

    /**
     * Obtiene el carrito de un usuario con información de productos
     */
    public function getCarritoPorUsuario($id_usuario)
    {
        return $this->select('carrito_producto.*, producto.nombre, producto.precio')
            ->join('producto', 'producto.id_producto = carrito_producto.id_producto')
            ->join('carrito', 'carrito.id_carrito = carrito_producto.id_carrito')
            ->where('carrito.id_usuario', $id_usuario)
            ->findAll();
    }
    
    /**
     * Verifica si un producto ya está en el carrito
     */
    public function productoExisteEnCarrito($id_carrito, $id_producto)
    {
        return $this->where('id_carrito', $id_carrito)
                   ->where('id_producto', $id_producto)
                   ->first();
    }
}