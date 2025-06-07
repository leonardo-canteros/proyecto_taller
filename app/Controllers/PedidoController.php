<?php

namespace App\Controllers;
use App\Models\PedidoModel;
use CodeIgniter\RESTful\ResourceController;

class PedidoController extends ResourceController
{
    protected $modelName = 'App\Models\PedidoModel';
    protected $format    = 'json';

    // GET: pedido/
    public function index()
    {
        return $this->respond($this->model->findAll());
    }

    // GET: pedido/{id}
    public function show($id = null)
    {
        $pedido = $this->model->find($id);
        if ($pedido) {
            return $this->respond($pedido);
        }
        return $this->failNotFound("Pedido no encontrado");
    }

    // POST: pedido/crear
    public function crear()
    {
        $data = $this->request->getJSON(true);
        $data['fecha_pedido'] = date('Y-m-d H:i:s'); // Fecha actual

        if ($this->model->insert($data)) {
            return $this->respondCreated([
                'mensaje' => 'Pedido creado correctamente',
                'id_pedido' => $this->model->insertID
            ]);
        } else {
            return $this->failValidationErrors($this->model->errors());
        }
    }

    // PUT: pedido/editar/{id}
    public function update($id = null)
    {
        $data = $this->request->getJSON(true);
        if ($this->model->update($id, $data)) {
            return $this->respond(['mensaje' => 'Pedido actualizado']);
        } else {
            return $this->failValidationErrors($this->model->errors());
        }
    }

    // DELETE: pedido/eliminar/{id}
    public function delete($id = null)
    {
        if ($this->model->delete($id)) {
            return $this->respondDeleted(['mensaje' => 'Pedido eliminado']);
        } else {
            return $this->failNotFound('Pedido no encontrado');
        }
    }
}
