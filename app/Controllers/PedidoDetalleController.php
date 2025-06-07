<?php

namespace App\Controllers;
use App\Models\PedidoDetalleModel;
use CodeIgniter\RESTful\ResourceController;

class PedidoDetalleController extends ResourceController
{
    protected $modelName = 'App\Models\PedidoDetalleModel';
    protected $format    = 'json';

    // GET: pedido-detalle/{id_pedido}
    public function mostrarPorPedido($id_pedido = null)
    {
        $detalles = $this->model->obtenerPorPedido($id_pedido);
        return $this->respond($detalles);
    }

    // POST: pedido-detalle/agregar
    public function agregar()
    {
        $data = $this->request->getJSON(true);
        if ($this->model->insert($data)) {
            return $this->respondCreated(['mensaje' => 'Detalle agregado']);
        } else {
            return $this->failValidationErrors($this->model->errors());
        }
    }

    // PUT: pedido-detalle/editar/{id}
    public function editar($id = null)
    {
        $data = $this->request->getJSON(true);
        if ($this->model->update($id, $data)) {
            return $this->respond(['mensaje' => 'Detalle actualizado']);
        } else {
            return $this->failValidationErrors($this->model->errors());
        }
    }

    // DELETE: pedido-detalle/eliminar/{id}
    public function eliminar($id = null)
    {
        if ($this->model->delete($id)) {
            return $this->respondDeleted(['mensaje' => 'Detalle eliminado']);
        } else {
            return $this->failNotFound('Detalle no encontrado');
        }
    }
}
