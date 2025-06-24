<?php namespace App\Controllers;

use App\Models\PedidoModel;
use App\Models\CarritoModel;
use App\Models\ProductoModel;


class PedidosController extends BaseController
{
    /**
     * Finalizar compra y crear pedido
     */
    public function finalizarCompra()
    {
        // Verificar autenticación
        if (!session()->has('id_usuario')) {
            return redirect()->to('/login')->with('error', 'Debes iniciar sesión');
        }

        // Validar datos
        $rules = [
            'direccion'    => 'required|max_length[150]',
            'metodo_pago'  => 'required|max_length[150]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', implode('<br>', $this->validator->getErrors()));
        }

        // Procesar pedido
        $carritoModel = new CarritoModel();
        $items = $carritoModel->where('id_usuario', session('id_usuario'))
                            ->where('estado', 'activo')
                            ->findAll();

        if (empty($items)) {
            return redirect()->back()->with('error', 'Carrito vacío');
        }

        // Calcular total
        $total = 0;
        $productoModel = new ProductoModel();
        foreach ($items as $item) {
            $producto = $productoModel->find($item['id_producto']);
            $total += $producto['precio'] * $item['cantidad'];
        }

        // Crear pedido
        $pedidoModel = new PedidoModel();
        $idPedido = $pedidoModel->crearPedido(
            session('id_usuario'),
            [
                'total' => $total,
                'direccion' => $this->request->getPost('direccion'),
                'metodo_pago' => $this->request->getPost('metodo_pago')
            ],
            $items
        );

        // Vaciar el carrito llamando al método del CarritoController
        $carritoController = new \App\Controllers\CarritoController();
        $carritoController->vaciar(session('id_usuario'));

        if (!$idPedido) {
            return redirect()->back()->with('error', 'Error al crear el pedido');
        }

        // Redirigir con mensaje de éxito
        return redirect()->to('usuario/principal')->with('success', '✅ Pedido realizado con éxito');
    }


    /**
     * Mostrar pedidos del usuario
     */
    public function misPedidos()
    {
        if (!session()->has('id_usuario')) {
            return redirect()->to('login');
        }

        $model = new PedidoModel();
        $data['pedidos'] = $model->getPedidosPorUsuario(session('id_usuario'));

        return view('pedidos/mis_pedidos', $data);
    }

    /**
     * ADMIN: Lista de todos los pedidos
     */
    public function adminLista()
    {
        if (session('rol') != 'admininistrador') {
            return redirect()->to('/');
        }

        $model = new PedidoModel();
        $data['pedidos'] = $model->getPedidosConUsuario();

        return view('admin/pedidos/lista', $data);
    }

    /**
     * ADMIN: Cambiar estado de pedido
     */
    public function cambiarEstado($id)
    {
        if (session('rol') != 'administrador') {
            return redirect()->to(base_url('admin/pedidos'));
        }

        $estado = (int) $this->request->getPost('estado');
        $pedidoModel = new PedidoModel();

        if ($pedidoModel->cambiarEstado($id, $estado)) {

            // Si el estado es finalizado, descontar stock
            if ($estado === 3) {
                $detalleModel = new \App\Models\DetallePedidoModel();
                $productoModel = new \App\Models\ProductoModel();

                $detalles = $detalleModel->where('id_pedido', $id)->findAll();

                foreach ($detalles as $detalle) {
                    $producto = $productoModel->find($detalle['id_producto']);
                    if ($producto) {
                        $nuevoStock = max(0, $producto['stock'] - $detalle['cantidad']);
                        log_message('debug', 'Actualizando producto ID: ' . $detalle['id_producto'] . ' - Cantidad: ' . $detalle['cantidad'] . ' - Stock anterior: ' . $producto['stock'] . ' - Nuevo stock: ' . $nuevoStock);

                        $productoModel->update($detalle['id_producto'], ['stock' => $nuevoStock]);
                    }
                }
            }

            return redirect()->to(base_url('admin/pedidos'))->with('success', 'Estado actualizado correctamente');
        }

        return redirect()->to(base_url('admin/pedidos'))->with('error', 'Error al actualizar el estado');
    }



}