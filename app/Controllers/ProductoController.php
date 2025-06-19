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
    public function crear()
    {
        // Obtener los datos del formulario
        $data = $this->request->getPost();

        // Validar los datos (si es necesario)
        if (!$this->validate([
            'nombre' => 'required|min_length[3]',
            'precio' => 'required|decimal',
            'stock'  => 'required|integer',
        ])) {
            return redirect()->back()->with('error', 'Por favor, complete todos los campos correctamente.');
        }

        // Procesar la subida de imagen
        $imagen = $this->request->getFile('imagen');
        if ($imagen->isValid() && !$imagen->hasMoved()) {
            // Obtiene el nombre original de la imagen
            $imagenName = $imagen->getName();
            
            // Ruta absoluta en XAMPP (directorio donde se almacenan las imágenes)
            $uploadPath = 'C:/xampp/htdocs/proyecto_taller/assets/img/';  // Ruta completa en XAMPP

            // Verificar si la carpeta existe, si no, la crea
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);  // Crear la carpeta si no existe
            }

            // Mueve la imagen a la carpeta "assets/img/"
            if ($imagen->move($uploadPath, $imagenName)) {
                // Guardar solo el nombre de la imagen en la base de datos
                $data['imagen'] = 'img/' . $imagenName;  // Guardamos solo el nombre como 'img/nombre.jpg'
            } else {
                return redirect()->back()->with('error', 'Hubo un problema al subir la imagen.');
            }
        } else {
            return redirect()->back()->with('error', 'La imagen no es válida o ya se ha movido.');
        }

        // Crear el producto en la base de datos
        $productoModel = new ProductoModel();
        if ($productoModel->insert($data)) {
            // Redirigir con un mensaje de éxito
            return redirect()->to('/admin/panel')->with('success', 'Producto creado correctamente');
        } else {
            return redirect()->to('/admin/panel')->with('error', 'Hubo un problema al crear el producto');
        }
    }

    // Método para obtener todos los productos (en caso de que lo necesites para el listado)
    public function index() {
        $productos = $this->productoModel->findAll();
        return view('catalogo_view', ['productos' => $productos]);
    }
}
