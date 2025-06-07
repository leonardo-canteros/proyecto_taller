<?php

namespace App\Models;
use CodeIgniter\Model;

class PedidoModel extends Model
{
    protected $table = 'pedido';
    protected $primaryKey = 'id_pedido';
    protected $allowedFields = [
        'id_usuario', 'fecha_pedido', 'total', 'estado_pedido',
        'direccion_envio', 'metodo_pago'
    ];
    protected $returnType = 'array';
}
