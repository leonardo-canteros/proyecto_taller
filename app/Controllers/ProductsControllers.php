<?php namespace App\Controllers;
use App\Models\ProductoModel;

class ProductoController extends BaseController
{
    protected $productoModel;

    public function __construct() {
        $this->productoModel = new ProductoModel();
    }

    // Listar productos (GET /productos)
    public function index() {
        $data['productos'] = $this->productoModel->findAll();
        return $this->response->setJSON($data); // Para probar en Postman
    }

    // Crear producto (POST /productos/crear)
    public function crear() {
        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
            'precio' => $this->request->getPost('precio'),
            'stock' => $this->request->getPost('stock'),
            'talla' => $this->request->getPost('talla'),
            'color' => $this->request->getPost('color'),
            'estado' => 'activo' // Valor por defecto
        ];
        $this->productoModel->insert($data);
        return $this->response->setJSON(['success' => 'Producto creado']);
    }

    // Actualizar producto (PUT /productos/editar/(:num))
    public function editar($id) {
        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'precio' => $this->request->getPost('precio')
            // ... otros campos que quieras actualizar
        ];
        $this->productoModel->update($id, $data);
        return $this->response->setJSON(['success' => 'Producto actualizado']);
    }

    // Eliminar producto (DELETE /productos/eliminar/(:num))
    public function eliminar($id) {
        $this->productoModel->delete($id);
        return $this->response->setJSON(['success' => 'Producto eliminado']);
    }
}