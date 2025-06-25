<?php namespace App\Models;

use CodeIgniter\Model;

class PedidoModel extends Model
{
    protected $table = 'pedido';
    protected $primaryKey = 'id_pedido';
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'id_usuario',
        'fecha_pedido',
        'Total',
        'estado_pedido',
        'direccion_envio',
        'metodo_pago',
        'pais',
        'provincia',
        'region'
    ];

    protected $useTimestamps = false;
    protected $createdField = 'fecha_pedido';

    /**
     * Crea un nuevo pedido desde el carrito
     */
   public function crearPedido($idUsuario, $datos, $items)
    {
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            log_message('info', 'Iniciando creación de pedido para usuario: '.$idUsuario);
            
            // Armamos datos del pedido con dirección y nueva info
            $pedidoData = [
                'id_usuario'      => $idUsuario,
                'fecha_pedido'    => date('Y-m-d H:i:s'),
                'Total'           => $datos['total'],
                'estado_pedido'   => 1,
                'direccion_envio' => $datos['direccion'],
                'pais'            => $datos['pais'],
                'provincia'       => $datos['provincia'],
                'region'          => $datos['region'],
                'metodo_pago'     => $datos['metodo_pago']
            ];

            log_message('info', 'Intentando insertar pedido: '.print_r($pedidoData, true));
            
            if (!$this->insert($pedidoData)) {
                log_message('error', 'Error al insertar pedido: '.print_r($this->errors(), true));
                throw new \RuntimeException('Error insertando pedido');
            }

            $idPedido = $this->getInsertID();
            log_message('info', 'Pedido creado con ID: '.$idPedido);

            // Insertar detalles del pedido
            $detalleModel = new \App\Models\DetallePedidoModel();
            foreach ($items as $item) {
                $detalleModel->insert([
                    'id_pedido'       => $idPedido,
                    'id_producto'     => $item['id_producto'],
                    'cantidad'        => $item['cantidad'],
                    'precio_unitario' => $item['precio'] ?? 0,
                ]);
            }

            $db->transComplete();
            return $idPedido;

        } catch (\Exception $e) {
            $db->transRollback();
            log_message('error', 'Error al crear pedido: '.$e->getMessage());
            return false;
        }
    }



    /**
     * Obtiene pedidos con información del usuario
     */
    public function getPedidosConUsuario()
    {
        return $this->select('pedido.*, usuarios.nombre as nombre_usuario')
                   ->join('usuarios', 'usuarios.id_usuario = pedido.id_usuario')
                   ->orderBy('pedido.fecha_pedido', 'ASC')
                   ->findAll();
    }

   /**
     * Obtiene pedidos de un usuario específico
     */
    public function getPedidosPorUsuario($idUsuario)
    {
        return $this->where('id_usuario', $idUsuario)
                   ->orderBy('fecha_pedido', 'ASC')
                   ->findAll();
    }

    /**
     * Cambia el estado de un pedido
     */
    public function cambiarEstado($idPedido, $estado)
    {
       $estadosValidos = [
            0 => 'cancelado',
            1 => 'pendiente',
            2 => 'enviado',
            3 => 'finalizado'
        ];

        
        if (!array_key_exists($estado, $estadosValidos)) {
            throw new \InvalidArgumentException('Estado de pedido no válido');
        }

        return $this->update($idPedido, ['estado_pedido' => $estado]);
    }
}