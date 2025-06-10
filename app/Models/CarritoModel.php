<?php
namespace App\Models;

use CodeIgniter\Model;

class CarritoModel extends Model
{
    protected $table = 'carritos';
    protected $primaryKey = 'id_carrito';
    protected $allowedFields = ['id_usuario', 'estado'];
    
    public function obtenerCarritoActivo($id_usuario)
    {
        return $this->where('id_usuario', $id_usuario)
                   ->where('estado', 'activo')
                   ->first();
    }
    
    public function crearCarrito($id_usuario)
    {
        return $this->insert(['id_usuario' => $id_usuario]);
    }
}