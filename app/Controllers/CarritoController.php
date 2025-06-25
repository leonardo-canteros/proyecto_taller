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
   public function obtenerCarrito($id_usuario)
    {
        // Validación opcional
        if (!session()->has('id_usuario') || session()->get('id_usuario') != $id_usuario) {
            return redirect()->to('/login')->with('error', 'No autorizado');
        }

        // Redirigir a la vista desde Home con layout completo
        return redirect()->to(base_url('carrito/' . $id_usuario));
    }

    /**
 * Agrega un producto al carrito (AJAX o Form)
 * 
 * @return \CodeIgniter\HTTP\ResponseInterface
 */
public function agregar()
{
    // Verificar si el usuario está logueado
    if (!session()->has('id_usuario')) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Debes iniciar sesión para agregar productos al carrito',
            'redirect' => base_url('login') // redirección para login
        ]);
    }

    // Obtener datos del request
    $id_usuario = (int)session()->get('id_usuario');
    $id_producto = $this->request->getPost('id_producto');
    $cantidad = $this->request->getPost('cantidad') ?? 1;
    
    $id_producto = $this->request->getVar('id_producto');
    // O
    $input = $this->request->getJSON(); // Si envías como JSON
    $id_producto = $input->id_producto ?? null;
     // Validaciones básicas
    if (empty($id_producto)) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'No se especificó el producto a agregar'
        ]);
    }
   
    if ($id_producto <= 0) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'ID de producto inválido'
        ]);
    }

    if ($cantidad <= 0) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'La cantidad debe ser mayor a cero'
        ]);
    }

    // Verificar existencia del producto
    $producto = $this->productoModel->find($id_producto);
    if (!$producto) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'El producto no existe o no está disponible'
        ]);
    }

    // Verificar stock disponible (si aplica)
    if (isset($producto['stock']) && $producto['stock'] < $cantidad) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'No hay suficiente stock disponible',
            'stock_disponible' => $producto['stock']
        ]);
    }

    try {
        // Manejar el producto en el carrito
        $resultado = $this->carritoModel->manejarProducto(
            $id_usuario,
            $id_producto,
            $cantidad
        );

        if (!$resultado) {
            throw new \RuntimeException('No se pudo actualizar el carrito');
        }

        // Obtener datos actualizados del carrito
        $productos_carrito = $this->carritoModel->obtenerProductosConDetalles($id_usuario);
        $total_carrito = $this->carritoModel->calcularTotalCarrito($id_usuario);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Producto agregado al carrito correctamente',
            'data' => [
                'producto' => $producto,
                'cantidad_agregada' => $cantidad
            ],
            'carrito' => [
                'total_items' => $this->carritoModel->contarProductos($id_usuario), // Usar la nueva función
                'total' => number_format($total_carrito, 2),
                'items' => $productos_carrito
            ]
        ]);

    } catch (\TypeError $e) {
        // Error de tipo de dato
        log_message('error', 'Error de tipo al agregar al carrito: ' . $e->getMessage());
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Error en los datos proporcionados',
            'error' => $e->getMessage()
        ]);
    } catch (\Exception $e) {
        // Otros errores
        log_message('error', 'Error al agregar al carrito: ' . $e->getMessage());
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Ocurrió un error al procesar tu solicitud',
            'error' => $e->getMessage()
        ]);
    }
}
    
    /**
     * Elimina un producto del carrito
     */
    public function eliminar( $id_carrito)
    {
        if (!session()->has('id_usuario')) {
            return redirect()->to('/login')->with('error', 'Debes iniciar sesión');
        }
        
        $id_usuario = session()->get('id_usuario');
        
        if ($this->carritoModel->eliminarProducto($id_carrito, $id_usuario)) {
            return redirect()->to('carrito/usuario/'.$id_usuario)->with('success', 'Producto eliminado del carrito');
        }
        
        return redirect()->to('carrito/usuario/'.$id_usuario)->with('error', 'No se pudo eliminar el producto');
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
            return redirect()->to('carrito/usuario/'.$id_usuario) ->with('success', 'Carrito vaciado correctamente');
        }
        
        return redirect()->to('/carrito')->with('error', 'No se pudo vaciar el carrito');
    }


   public function actualizar($id_carrito)
{
    if (!session()->has('id_usuario')) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Debes iniciar sesión para actualizar el carrito',
            'redirect' => base_url('login')
        ]);
    }

    $cantidad = $this->request->getPost('cantidad');
    $id_usuario = session()->get('id_usuario');

    // Validar que el item pertenece al usuario
    $item = $this->carritoModel->obtenerItem($id_carrito, $id_usuario);

    if (!$item) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'El producto no se encontró en tu carrito'
        ]);
    }

    // Validar cantidad
    if ($cantidad <= 0) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'La cantidad debe ser mayor a cero'
        ]);
    }

    // Verificar stock
    $producto = $this->productoModel->find($item['id_producto']);
    if ($producto['stock'] < $cantidad) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'No hay suficiente stock disponible',
            'stock_disponible' => $producto['stock']
        ]);
    }

    // Actualizar cantidad
    if ($this->carritoModel->actualizarCantidad($id_carrito, $cantidad)) {
        // Calcular nuevo total
        $nuevoTotal = $this->carritoModel->calcularTotalCarrito($id_usuario);
         return redirect()->to('carrito/usuario/'.$id_usuario) ;
    }

    return $this->response->setJSON([
        'success' => false,
        'message' => 'No se pudo actualizar la cantidad'
    ]);
}

public function contador()
{
    if (!session()->has('id_usuario')) {
        return $this->response->setJSON(['count' => 0]);
    }

    $id_usuario = session()->get('id_usuario');
    $carritoModel = new \App\Models\CarritoModel();
    $count = $carritoModel->contarProductos($id_usuario);

    return $this->response->setJSON(['count' => $count]);
}



}