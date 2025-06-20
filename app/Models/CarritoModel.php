<?php
namespace App\Models;

use CodeIgniter\Model;

class CarritoModel extends Model
{
    protected $table = 'carritos';
    protected $primaryKey = 'id_carrito';
    protected $allowedFields = ['id_usuario', 'id_producto', 'cantidad', 'estado'];
    protected $useTimestamps = true;
    protected $createdField = 'fecha_creacion';
    protected $updatedField = 'fecha_actualizacion';
    
    /**
     * Obtiene el carrito activo de un usuario
     */
    public function obtenerCarritoActivo($id_usuario)
    {
        return $this->where('id_usuario', $id_usuario)
                   ->where('estado', 'activo')
                   ->first();
    }
    
    /**
     * Crea un nuevo carrito para un usuario
     */
    public function crearCarrito($id_usuario)
    {
        return $this->insert([
            'id_usuario' => $id_usuario,
            'estado' => 'activo'
        ]);
    }
    
    /**
     * Agrega o actualiza un producto en el carrito
     */
    public function manejarProducto(int $id_usuario, int $id_producto, int $cantidad = 1): bool
    {
        // Verificar si el producto ya está en el carrito
        $item = $this->where('id_usuario', $id_usuario)
                    ->where('id_producto', $id_producto)
                    ->where('estado', 'activo')
                    ->first();

        if ($item) {
            // Actualizar cantidad
            return $this->update($item['id_carrito'], [
                'cantidad' => $item['cantidad'] + $cantidad
            ]);
        }
        
        // Agregar nuevo producto
        return $this->insert([
            'id_usuario' => $id_usuario,
            'id_producto' => $id_producto,
            'cantidad' => $cantidad,
            'estado' => 'activo'
        ]);
    }
    
    /**
     * Obtiene todos los productos del carrito con información completa
     */
    public function obtenerProductosConDetalles(int $id_usuario): array
    {
        $productoModel = new ProductoModel();
        
        return $this->select('carritos.*, productos.nombre, productos.precio, productos.imagen, productos.stock')
                  ->join('productos', 'productos.id_producto = carritos.id_producto')
                  ->where('carritos.id_usuario', $id_usuario)
                  ->where('carritos.estado', 'activo')
                  ->findAll();
    }
    
    /**
     * Elimina un producto del carrito
     */
    public function removerProducto(int $id_usuario, int $id_producto): bool
    {
        return $this->where('id_usuario', $id_usuario)
                  ->where('id_producto', $id_producto)
                  ->where('estado', 'activo')
                  ->delete();
    }
    
    /**
     * Calcula el total del carrito
     */
    public function calcularTotalCarrito(int $id_usuario): float
    {
        $productos = $this->obtenerProductosConDetalles($id_usuario);
        $total = 0.0;
        
        foreach ($productos as $producto) {
            $total += $producto['precio'] * $producto['cantidad'];
        }
        
        return $total;
    }
    
    /**
     * Vacía completamente el carrito
     */
    public function vaciarCarrito(int $id_usuario): bool
    {
        return $this->where('id_usuario', $id_usuario)
                  ->where('estado', 'activo')
                  ->delete();
    }
    
    /**
     * Obtiene la cantidad de items en el carrito
     */
    public function contarProductos(int $id_usuario): int
    {
        return $this->where('id_usuario', $id_usuario)
                  ->where('estado', 'activo')
                  ->countAllResults();
    }
}