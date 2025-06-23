<?php namespace App\Models;

use CodeIgniter\Model;

class DetallePedidoModel extends Model
{
    protected $table      = 'detalle_pedido';
    protected $primaryKey = 'id_detalle';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'id_pedido',
        'id_producto',
        'cantidad',
        'precio_unitario'
    ];

    protected $useTimestamps = false;

    protected $validationRules    = [
        'id_pedido'       => 'required|numeric',
        'id_producto'     => 'required|numeric',
        'cantidad'        => 'required|numeric',
        'precio_unitario' => 'required|numeric'
    ];

    protected $validationMessages = [];
    protected $skipValidation     = false;
}