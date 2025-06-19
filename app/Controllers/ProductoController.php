<?php 
// ProductoController.php
namespace App\Controllers;

use App\Models\ProductoModel;
use CodeIgniter\Controller;

class ProductoController extends Controller
{
    protected $productoModel;

    public function __construct() {
        $this->productoModel = new ProductoModel();
    }

    // Crear producto (POST /admin/panel_admin/crear)
    public function crear() {
        // Obtener datos del formulario
        $data = $this->request->getPost(); // Para form-data

        // Validación básica
        if (empty($data['nombre'])) {
            return redirect()->back()->with('error', 'El campo "nombre" es requerido');
        }

        // Subir imagen
        if ($this->request->getFile('imagen')->isValid()) {
            $imagen = $this->request->getFile('imagen');
            $imagenName = $imagen->getRandomName();
            $imagen->move(WRITEPATH . 'uploads', $imagenName);  // Guardar imagen en la carpeta uploads
            $data['imagen'] = $imagenName; // Guardamos el nombre de la imagen en la base de datos
        }

        // Insertar en la base de datos
        if ($this->productoModel->insert($data)) {
            return redirect()->to('/admin/panel')->with('success', 'Producto creado exitosamente');
        } else {
            return redirect()->back()->with('error', 'No se pudo crear el producto');
        }
    }

    // Método para obtener todos los productos (en caso de que lo necesites para el listado)
    public function index() {
        $productos = $this->productoModel->findAll();
        return view('catalogo_view', ['productos' => $productos]);
    }
}
