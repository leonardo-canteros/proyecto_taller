<?php
namespace App\Models;
use CodeIgniter\Model;

class CarritoModel extends Model
{
    protected $table = 'carrito';
    protected $primaryKey = 'id_carrito';
    protected $allowedFields = ['id_usuario'];
    protected $useAutoIncrement = true;

    /**
     * Crea o obtiene el ID del carrito de un usuario
     */
    public function obtenerCarritoUsuario($id_usuario)
    {
        $carrito = $this->where('id_usuario', $id_usuario)->first();
        
        if (!$carrito) {
            return $this->insert(['id_usuario' => $id_usuario]);
        }
        
        return $carrito['id_carrito'];
    }
}