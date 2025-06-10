<?php
namespace App\Controllers;

use App\Models\CarritoModel;
use App\Models\CarritoProductoModel;
use CodeIgniter\RESTful\ResourceController;

class CarritoController extends ResourceController
{
    protected $carritoModel;
    protected $carritoProductoModel;
    
    public function __construct()
    {
        $this->carritoModel = new CarritoModel();
        $this->carritoProductoModel = new CarritoProductoModel();
    }

    // GET: carrito/usuario/{id_usuario}
    public function mostrarCarrito($id_usuario = null)
    {
        if (!$id_usuario) {
            return $this->fail('ID de usuario requerido', 400);
        }
        
        $carrito = $this->carritoProductoModel->getCarritoPorUsuario($id_usuario);
        return $this->respond($carrito);
    }

    // POST: carrito/agregar
    public function agregarProducto()
    {
        // Verificar sesión
        $id_usuario = session()->get('id_usuario');
        if (!$id_usuario) {
            return $this->fail('Debe iniciar sesión', 401);
        }

        $data = $this->request->getJSON(true);
        
        // Validar datos mínimos
        if (!isset($data['id_producto'])) {
            return $this->fail('ID de producto requerido', 400);
        }
        
        // Obtener o crear carrito
        $id_carrito = $this->carritoModel->obtenerCarritoUsuario($id_usuario);
        
        // Verificar si el producto ya está en el carrito
        $itemExistente = $this->carritoProductoModel->productoExisteEnCarrito($id_carrito, $data['id_producto']);
        
        if ($itemExistente) {
            // Actualizar cantidad si ya existe
            $nuevaCantidad = ($itemExistente['cantidad'] + ($data['cantidad'] ?? 1));
            $this->carritoProductoModel->update($itemExistente['id_carrito_producto'], ['cantidad' => $nuevaCantidad]);
        } else {
            // Agregar nuevo producto
            $this->carritoProductoModel->insert([
                'id_carrito' => $id_carrito,
                'id_producto' => $data['id_producto'],
                'cantidad' => $data['cantidad'] ?? 1
            ]);
        }
        
        return $this->respondCreated(['mensaje' => 'Producto agregado al carrito']);
    }

    // PUT: carrito/editar/{id}
    public function editarProducto($id = null)
    {
        $data = $this->request->getJSON(true);
        
        if ($this->carritoProductoModel->update($id, $data)) {
            return $this->respond(['mensaje' => 'Producto actualizado']);
        }
        
        return $this->fail('Error al actualizar', 400);
    }

    // DELETE: carrito/eliminar/{id}
    public function eliminarProducto($id = null)
    {
        if ($this->carritoProductoModel->delete($id)) {
            return $this->respondDeleted(['mensaje' => 'Producto eliminado']);
        }
        
        return $this->fail('Producto no encontrado', 404);
    }
}