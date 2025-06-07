<?php

namespace App\Models;
use CodeIgniter\Model;

class PedidoDetalleModel extends Model
{
    // Nombre de la tabla en la base de datos
    protected $table = 'pedido_detalle';

    // Clave primaria de la tabla
    protected $primaryKey = 'id_pedido_detalle';

    // Campos permitidos para inserción o actualización masiva
    protected $allowedFields = [
        'id_pedido',        // ID del pedido al que pertenece este detalle
        'id_producto',      // ID del producto comprado
        'cantidad',         // Cantidad del producto comprado
        'precio_unitario'   // Precio unitario del producto al momento de la compra
    ];

    // Tipo de retorno: array asociativo
    protected $returnType = 'array';

    /**
     * Obtiene todos los detalles (productos) asociados a un pedido específico.
     * También incluye el nombre del producto a través de un JOIN.
     *
     * @param int $id_pedido El ID del pedido
     * @return array Lista de detalles del pedido con información del producto
     */
    public function obtenerPorPedido($id_pedido)
    {
        return $this->select('pedido_detalle.*, producto.nombre') // Selecciona columnas de detalle + nombre del producto
            ->join('producto', 'producto.id_producto = pedido_detalle.id_producto') // Une con tabla producto
            ->where('id_pedido', $id_pedido) // Filtra por el pedido solicitado
            ->findAll(); // Devuelve todos los resultados
    }
}
