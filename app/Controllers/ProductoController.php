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
            'precio'  => 'required|decimal|greater_than_equal_to[0]',
            'stock'  => 'required|integer',
            'categoria' => 'required',
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
    

     // ————————— Admin: listado de productos —————————
    public function panel()
    {
        $productos = $this->productoModel->findAll();
        return view('admin/lista_productos', [
            'productos' => $productos
        ]);
    }

    // ————————— Admin: formulario de edición —————————
    // … dentro de class ProductoController …

// ————————— Admin: formulario de edición —————————
public function editar($id)
{
    $producto = $this->productoModel->find($id);
    if (!$producto) {
        return redirect()->to('/admin/panel')
                         ->with('error','Producto no encontrado');
    }
    return view('admin/editar_producto', [
        'producto' => $producto
    ]);
}


    // ————————— Admin: procesar actualización —————————


       public function actualizar($id)
    {
    // validación básica…
    if (! $this->validate([
        'nombre'    => 'required|min_length[3]',
        'precio'  => 'required|decimal|greater_than_equal_to[0]',
        'stock'     => 'required|integer',
        'categoria' => 'required',
    ])) {
        // Obtengo el array de errores
        $errores = $this->validator->getErrors();
        // Lo detengo y muestro para ver exactamente qué campos fallan
        dd($errores);
    }


         $data = $this->request->getPost();
            $data['id_producto'] = $id;
            // 1) Cojo el ítem viejo para tener su ruta de imagen actual
            $viejo = $this->productoModel->find($id);

            // 2) Procesar nueva subida, si la hay:
            $img = $this->request->getFile('imagen');
            if ($img && $img->isValid() && ! $img->hasMoved()) {
                $name       = $img->getName();
                $uploadPath = 'C:/xampp/htdocs/proyecto_taller/assets/img/';
                if (! is_dir($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }
                $img->move($uploadPath, $name);
                $data['imagen'] = 'img/' . $name;
            } else {
                // no sube nada → preservo la ruta que ya tenía
                $data['imagen'] = $viejo['imagen'];
            }

            if ($this->productoModel->save($data)) {
                return redirect()->to('/admin/productos')
                                ->with('success','Producto actualizado con exito');
            }
            return redirect()->to('/admin/productos')
                            ->with('error','Error al actualizar');
     }





    // Método para obtener todos los productos (en caso de que lo necesites para el listado)
    public function index() {
        $productos = $this->productoModel->findAll();
        return view('catalogo_view', ['productos' => $productos]);
    }
}
