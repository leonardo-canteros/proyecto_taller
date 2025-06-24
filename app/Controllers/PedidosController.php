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
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Debes iniciar sesión'
            ]);
        }

        // Validar datos
        $rules = [
            'direccion' => 'required|max_length[150]',
            'metodo_pago' => 'required|max_length[150]'
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => implode('<br>', $this->validator->getErrors())
            ]);
        }

        // Procesar pedido
        $carritoModel = new CarritoModel();
        $items = $carritoModel->where('id_usuario', session('id_usuario'))
                             ->where('estado', 'activo')
                             ->findAll();

        if (empty($items)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Carrito vacío'
            ]);
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
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error al crear el pedido'
            ]);
        }
        
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Pedido creado con éxito',
            'redirect' => base_url('usuario/principal')
        ]);
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
        if (session('rol') != 'admin') {
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
        if (session('rol') != 'admin') {
            return redirect()->to('/');
        }

        $estado = $this->request->getPost('estado');
        $model = new PedidoModel();

        if ($model->cambiarEstado($id, $estado)) {
            return redirect()->back()->with('success', 'Estado actualizado');
        }

        return redirect()->back()->with('error', 'Error al actualizar');
    }
}