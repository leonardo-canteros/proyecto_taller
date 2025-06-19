<?php namespace App\Controllers;

use App\Models\CarritoModel;
use App\Models\ProductoModel;

class CarritoController extends BaseController
{
    protected $carritoModel;
    protected $productoModel;
    
    public function __construct()
    {
        $this->carritoModel = new CarritoModel();
        $this->productoModel = new ProductoModel();
        helper(['form', 'url']);
    }
    
    /**
     * Muestra el contenido del carrito
     */
    public function obtenerCarrito()
    {
        if (!session()->has('id_usuario')) {
            return redirect()->to('/login')->with('error', 'Debes iniciar sesión');
        }
        
        $id_usuario = session()->get('id_usuario');
        
        $data = [
            'productos' => $this->carritoModel->obtenerProductosConDetalles($id_usuario),
            'total' => $this->carritoModel->calcularTotalCarrito($id_usuario),
            'titulo' => 'Mi Carrito de Compras'
        ];
        
        // Retornar siempre JSON
        return $this->response->setJSON([
            'success' => true,
            'data' => $data
        ]);
        }
    
    /**
     * Agrega un producto al carrito (AJAX o Form)
     */
    public function agregar()
    {
        if (!session()->has('id_usuario')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Debes iniciar sesión'
            ]);
        }
        
        $id_usuario = session()->get('id_usuario');
        $id_producto = $this->request->getPost('id_producto');
        $cantidad = $this->request->getPost('cantidad') ?? 1;
        
        // Validar producto
        if (!$this->productoModel->find($id_producto)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Producto no encontrado'
            ]);
        }
        
        try {
            $this->carritoModel->manejarProducto($id_usuario, $id_producto, $cantidad);
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Producto agregado al carrito',
                'total_items' => count($this->carritoModel->obtenerProductosConDetalles($id_usuario)),
                'total' => number_format($this->carritoModel->calcularTotalCarrito($id_usuario), 2)
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
    
    /**
     * Elimina un producto del carrito
     */
    public function eliminar($id_producto)
    {
        if (!session()->has('id_usuario')) {
            return redirect()->to('/login')->with('error', 'Debes iniciar sesión');
        }
        
        $id_usuario = session()->get('id_usuario');
        
        if ($this->carritoModel->removerProducto($id_usuario, $id_producto)) {
            return redirect()->to('/carrito')->with('success', 'Producto eliminado del carrito');
        }
        
        return redirect()->to('/carrito')->with('error', 'No se pudo eliminar el producto');
    }
    
    /**
     * Vacía completamente el carrito
     */
    public function vaciar()
    {
        if (!session()->has('id_usuario')) {
            return redirect()->to('/login')->with('error', 'Debes iniciar sesión');
        }
        
        $id_usuario = session()->get('id_usuario');
        
        if ($this->carritoModel->vaciarCarrito($id_usuario)) {
            return redirect()->to('/carrito')->with('success', 'Carrito vaciado correctamente');
        }
        
        return redirect()->to('/carrito')->with('error', 'No se pudo vaciar el carrito');
    }
}