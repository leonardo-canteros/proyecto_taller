<?php namespace App\Models;
use CodeIgniter\Model;

class ProductoModel extends Model
{
    protected $table = 'productos';
    protected $primaryKey = 'id_producto';
    protected $useSoftDeletes = true; // Habilita soft delete
    protected $deletedField = 'deleted_at'; // Campo para marcar eliminación
    
    protected $allowedFields = [
        'nombre', 'descripcion', 'precio', 'stock', 
        'talla', 'color', 'imagen', 'estado', 'id_categoria','deleted_at'
    ];

    

    // reglas de validación
    protected $validationRules = [
        'nombre' => 'required|min_length[3]',
        'precio' => 'required|decimal',
        'stock' => 'required|integer'
    ];
}


