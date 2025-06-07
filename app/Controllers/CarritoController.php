<?php

namespace App\Controllers;
use App\Models\CarritoProductoModel;
use CodeIgniter\RESTful\ResourceController;

class CarritoController extends ResourceController
{
    protected $modelName = 'App\Models\CarritoProductoModel';
    protected $format    = 'json';

    // GET: carrito/usuario/{id_usuario}
    public function mostrarCarrito($id_usuario = null)
    {
        $carrito = $this->model->getCarritoPorUsuario($id_usuario);
        return $this->respond($carrito);
    }

    // POST: carrito/agregar
    public function agregarProducto()
    {
        $data = $this->request->getJSON(true);
        if ($this->model->insert($data)) {
            return $this->respondCreated(['mensaje' => 'Producto agregado al carrito']);
        } else {
            return $this->failValidationErrors($this->model->errors());
        }
    }

    // PUT: carrito/editar/{id_carrito_producto}
    public function editarProducto($id = null)
    {
        $data = $this->request->getJSON(true);
        if ($this->model->update($id, $data)) {
            return $this->respond(['mensaje' => 'Producto del carrito actualizado']);
        } else {
            return $this->failValidationErrors($this->model->errors());
        }
    }

    // DELETE: carrito/eliminar/{id_carrito_producto}
    public function eliminarProducto($id = null)
    {
        if ($this->model->delete($id)) {
            return $this->respondDeleted(['mensaje' => 'Producto eliminado del carrito']);
        } else {
            return $this->failNotFound('Producto no encontrado en el carrito');
        }
    }
}
