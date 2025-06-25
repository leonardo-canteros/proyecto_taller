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
        if (!session()->has('id_usuario')) {
            return redirect()->to('login')->with('error', 'Debes iniciar sesión para finalizar la compra.');
        }

        $request = $this->request;

        // Validar campos
        $rules = [
            'direccion'     => 'required|min_length[3]',
            'provincia'     => 'required|min_length[2]',
            'region'        => 'required|min_length[2]',
            'pais'          => 'required|min_length[2]',
            'metodo_pago'   => 'required|in_list[Tarjeta,Transferencia,Efectivo]'
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Verifica los datos ingresados.');
        }

        $idUsuario = session()->get('id_usuario');

        // Obtener productos del carrito
        $carritoModel = new \App\Models\CarritoModel();
       $productos = $carritoModel->obtenerProductosConDetalles($idUsuario);


        if (empty($productos)) {
            return redirect()->to('carrito')->with('error', 'Tu carrito está vacío.');
        }

        // Calcular total
        $total = 0;
        foreach ($productos as $p) {
            $total += $p['precio'] * $p['cantidad'];
        }

        log_message('info', 'POST recibido: ' . print_r($request->getPost(), true));

        // Preparar datos
        $datos = [
            'total'      => $total,
            'direccion'  => $request->getPost('direccion'),
            'provincia'  => $request->getPost('provincia'),
            'region'     => $request->getPost('region'),
            'pais'       => $request->getPost('pais'),
            'metodo_pago'=> $request->getPost('metodo_pago'),
        ];

        // Items
        $items = [];
        foreach ($productos as $p) {
            $items[] = [
                'id_producto' => $p['id_producto'],
                'cantidad'    => $p['cantidad'],
                'precio'      => $p['precio'],
            ];
        }

        // Crear pedido
        $pedidoModel = new \App\Models\PedidoModel();
        $idPedido = $pedidoModel->crearPedido($idUsuario, $datos, $items);

        if (!$idPedido) {
            return redirect()->to('carrito')->with('error', 'Error al crear el pedido.');
        }

        // Vaciar carrito
        $carritoModel->vaciarCarrito($idUsuario);

        return redirect()->to('usuario/pedidos')->with('success', 'Pedido realizado con éxito.');
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

        $detalleModel = new \App\Models\DetallePedidoModel();
        $productoModel = new \App\Models\ProductoModel();

        $detalles = $detalleModel->where('id_pedido', $id)->findAll();

        // Si el nuevo estado es Enviado o Finalizado, validar stock
        if ($estado === 2 || $estado === 3) {
            foreach ($detalles as $detalle) {
                $producto = $productoModel->find($detalle['id_producto']);

                if (!$producto || $producto['stock'] < $detalle['cantidad']) {
                    return redirect()->to(base_url('admin/pedidos'))->with(
                        'error',
                        'Stock insuficiente para el producto "' . ($producto['nombre'] ?? 'Desconocido') . '". No se puede cambiar el estado.'
                    );
                }
            }
        }

        // Si pasa a FINALIZADO (3), descontar stock
        if ($estado === 3) {
            foreach ($detalles as $detalle) {
                $producto = $productoModel->find($detalle['id_producto']);
                $nuevoStock = $producto['stock'] - $detalle['cantidad'];

                $productoModel->update($detalle['id_producto'], ['stock' => $nuevoStock]);
            }
        }

        // Cambiar el estado
        if ($pedidoModel->cambiarEstado($id, $estado)) {
            return redirect()->to(base_url('admin/pedidos'))->with('success', 'Estado actualizado correctamente');
        }

        return redirect()->to(base_url('admin/pedidos'))->with('error', 'Error al actualizar el estado');
    }

    



}