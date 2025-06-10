<?php 
namespace App\Controllers;

use App\Models\ProductoModel;
use CodeIgniter\RESTful\ResourceController; // ¡Cambia esta línea!

class ProductoController extends ResourceController
{
    protected $productoModel;

    public function __construct() {
        $this->productoModel = new ProductoModel();
    }

    // Crear producto (POST /productos/crear)
   public function crear(){
    // Obtener datos como array (más seguro que getJSON())
    $data = $this->request->getPost(); // Para form-data
    // O alternativamente para JSON:
    $json = $this->request->getJSON();
    $data = json_decode(json_encode($json), true);

    // Depuración (verifica en writable/logs/)
    log_message('error', 'Datos recibidos: '.print_r($data, true));

    if (empty($data['nombre'])) {
        return $this->fail('El campo "nombre" es requerido', 400);
    }

    $model = new ProductoModel();
    if ($model->insert($data)) {
        return $this->respondCreated(['message' => 'Producto creado']);
    } else {
        return $this->failValidationErrors($model->errors());
    }
    }

 // Listar todos (GET)
   public function index()
{
    $model = new \App\Models\ProductoModel();
    $productos = $model->findAll();

    return $this->response->setJSON($productos);
}


    // Mostrar uno (GET)
    public function show($id = null)
    {
        $model = new ProductoModel();
        $producto = $model->find($id);
        
        return $producto ? $this->respond($producto) 
                        : $this->failNotFound('Producto no encontrado');
    }

    // Actualizar (PUT)
    public function editar($id = null)
    {
        $model = new ProductoModel();
        $data = $this->request->getJSON();
        
        if ($model->update($id, $data)) {
            return $this->respondUpdated(['message' => 'Producto actualizado']);
        }
        
        return $this->failValidationErrors($model->errors());
    }

    public function eliminar($id = null)
{
    $model = new ProductoModel();
    
    // Buscar el producto incluyendo eliminados lógicos
    $producto = $model->withDeleted()->find($id);
    
    if (!$producto) {
        return $this->failNotFound("No se encontró el producto con ID $id");
    }
    
    // Verificar si ya está eliminado
    if ($producto['deleted_at'] !== null) {
        return $this->fail("El producto ya fue eliminado anteriormente", 400);
    }
    
    // Eliminación lógica usando el método estándar delete()
    try {
        if ($model->delete($id)) {
            // Obtener el producto actualizado para mostrar la fecha de eliminación
            $productoEliminado = $model->onlyDeleted()->find($id);
            
            return $this->respondDeleted([
                'status' => 200,
                'message' => 'Producto marcado como eliminado (soft delete)',
                'data' => [
                    'id' => $id,
                    'deleted_at' => $productoEliminado['deleted_at']
                ]
            ]);
        }
    } catch (\Exception $e) {
        log_message('error', "Error al eliminar producto ID $id: ".$e->getMessage());
        return $this->failServerError('Error interno del servidor al intentar eliminar');
    }
    
    return $this->fail('No se pudo completar la eliminación', 400);
}
}