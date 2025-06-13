<?php
namespace App\Controllers;

use App\Models\CarritoModel;
use App\Models\CarritoProductoModel;
use CodeIgniter\API\ResponseTrait;

class CarritoController extends BaseController
{
    use ResponseTrait;

    protected $carritoModel;
    protected $carritoProductoModel;

    public function __construct()
    {
        $this->carritoModel = new CarritoModel();
        $this->carritoProductoModel = new CarritoProductoModel();
    }

    // POST /carrito/agregar
    public function agregarProducto()
    {
        $id_usuario = session()->get('id_usuario');
        
        // Obtener o crear carrito
        $carrito = $this->carritoModel->obtenerCarritoActivo($id_usuario);
        if (!$carrito) {
            $id_carrito = $this->carritoModel->crearCarrito($id_usuario);
        } else {
            $id_carrito = $carrito['id_carrito'];
        }

        $data = $this->request->getJSON(true);
        
        // Validación básica
        if (empty($data['id_producto'])) {
            return $this->fail('ID de producto requerido', 400);
        }

        // Verificar si el producto ya está en el carrito
        $itemExistente = $this->carritoProductoModel->productoExiste($id_carrito, $data['id_producto']);
        
        if ($itemExistente) {
            // Actualizar cantidad
            $nuevaCantidad = $itemExistente['cantidad'] + ($data['cantidad'] ?? 1);
            $this->carritoProductoModel->update($itemExistente['id_carrito_producto'], ['cantidad' => $nuevaCantidad]);
        } else {
            // Agregar nuevo producto
            $this->carritoProductoModel->insert([
                'id_carrito' => $id_carrito,
                'id_producto' => $data['id_producto'],
                'cantidad' => $data['cantidad'] ?? 1
            ]);
        }

        return $this->respond([
            'status' => 'success',
            'message' => 'Producto agregado al carrito',
            'data' => $this->carritoProductoModel->obtenerProductos($id_carrito)
        ]);
    }

    // GET /carrito
    public function obtenerCarrito()
    {
        $id_usuario = session()->get('id_usuario');
        $carrito = $this->carritoModel->obtenerCarritoActivo($id_usuario);
        
        if (!$carrito) {
            return $this->respond(['data' => []]);
        }
        
        $productos = $this->carritoProductoModel->obtenerProductos($carrito['id_carrito']);
        
        return $this->respond([
            'status' => 'success',
            'data' => $productos
        ]);
    }

    // DELETE /carrito/eliminar/{id_producto}
    public function eliminarProducto($id_producto)
    {
        $id_usuario = session()->get('id_usuario');
        $carrito = $this->carritoModel->obtenerCarritoActivo($id_usuario);
        
        if (!$carrito) {
            return $this->failNotFound('Carrito no encontrado');
        }
        
        $this->carritoProductoModel
            ->where('id_carrito', $carrito['id_carrito'])
            ->where('id_producto', $id_producto)
            ->delete();
            
        return $this->respondDeleted([
            'status' => 'success',
            'message' => 'Producto eliminado del carrito'
        ]);
    }
}