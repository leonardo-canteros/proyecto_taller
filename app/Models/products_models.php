<?php namespace App\Models;
use CodeIgniter\Model;

class ProductoModel extends Model
{
    protected $table = 'producto';
    protected $primaryKey = 'id_producto';
    protected $allowedFields = [
        'nombre', 'descripcion', 'precio', 'stock', 'talla', 
        'color', 'imagen_url', 'estado', 'id_categoria'
    ];
}