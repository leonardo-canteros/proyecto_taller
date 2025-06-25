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
            'estado' => 'activo',
            'fecha_creacion' => date('Y-m-d H:i:s')
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
                'cantidad' => $item['cantidad'] + $cantidad,
                'fecha_actualizacion' => date('Y-m-d H:i:s')
            ]);
        }
        
        // Agregar nuevo producto
        return $this->insert([
            'id_usuario' => $id_usuario,
            'id_producto' => $id_producto,
            'cantidad' => $cantidad,
            'estado' => 'activo',
            'fecha_creacion' => date('Y-m-d H:i:s')
        ]);
    }
    
    /**
     * Obtiene un item específico del carrito
     */
    public function obtenerItem(int $id_carrito, int $id_usuario )
    {
        $builder = $this->where('id_carrito', $id_carrito);
        
        if ($id_usuario !== null) {
            $builder->where('id_usuario', $id_usuario);
        }
        
        return $builder->first();
    }
    
    /**
     * Actualiza la cantidad de un producto en el carrito
     */
    public function actualizarCantidad(int $id_carrito, int $cantidad): bool
    {
        return $this->update($id_carrito, [
            'cantidad' => $cantidad,
            'fecha_actualizacion' => date('Y-m-d H:i:s')
        ]);
    }
    
    /**
     * Obtiene todos los productos del carrito con información completa
     */
    public function obtenerProductosConDetalles(int $id_usuario): array
    {
        return $this->select('carritos.*, productos.nombre, productos.precio, productos.imagen, productos.stock, productos.descripcion')
                  ->join('productos', 'productos.id_producto = carritos.id_producto')
                  ->where('carritos.id_usuario', $id_usuario)
                  ->where('carritos.estado', 'activo')
                  ->orderBy('carritos.fecha_creacion', 'DESC')
                  ->findAll();
    }


    
    /**
     * Elimina un producto del carrito por ID de carrito
     */
    public function eliminarProducto(int $id_carrito, int $id_usuario): bool
    {
        $builder = $this->where('id_carrito', $id_carrito);
        
        if ($id_usuario !== null) {
            $builder->where('id_usuario', $id_usuario);
        }
        
        return $builder->delete();
    }
    
    /**
     * Elimina un producto del carrito por ID de producto
     * @deprecated Usar eliminarProducto() en su lugar
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
        $builder = $this->db->table($this->table);
        $builder->selectSum('cantidad');
        $builder->where('id_usuario', $id_usuario);
        $builder->where('estado', 'activo');
        $query = $builder->get();
        
        return (int) $query->getRow()->cantidad ?? 0;
    }
    
    /**
     * Verifica si un producto existe en el carrito
     */
    public function productoExisteEnCarrito(int $id_usuario, int $id_producto): bool
    {
        return $this->where('id_usuario', $id_usuario)
                  ->where('id_producto', $id_producto)
                  ->where('estado', 'activo')
                  ->countAllResults() > 0;
    }
    
    /**
     * Obtiene la cantidad de un producto específico en el carrito
     */
    public function obtenerCantidadProducto(int $id_usuario, int $id_producto): int
    {
        $item = $this->where('id_usuario', $id_usuario)
                   ->where('id_producto', $id_producto)
                   ->where('estado', 'activo')
                   ->first();
                   
        return $item ? $item['cantidad'] : 0;
    }
    
    /**
     * Actualiza el estado del carrito (para checkout)
     */
    public function actualizarEstado(int $id_usuario, string $estado): bool
    {
        return $this->where('id_usuario', $id_usuario)
                  ->where('estado', 'activo')
                  ->set(['estado' => $estado, 'fecha_actualizacion' => date('Y-m-d H:i:s')])
                  ->update();
    }
}