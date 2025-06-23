<?php 
namespace App\Controllers;

class Home extends BaseController
{
    // Método privado para cargar vistas repetitivas
    private function loadView($contentView, $data = [])
    {
        echo view('head_view', $data);
        echo view('navbar_view', $data);
        echo view($contentView, $data);
        echo view('footer_view', $data);
    }

    public function carrito()
    {
        $this->loadView('carrito_view');
    }


    public function index()
    {
        $this->loadView('principal_view');
    }

    public function testdb()
    {
        $db = \Config\Database::connect();
        echo $db->connect() ? '✅ ¡Conexión exitosa!' : '❌ No se pudo conectar.';
    }

    public function quienes_somos()
    {
        $this->loadView('quienes_somos');
    }

    public function Contacto()
    {
        $this->loadView('Contacto');
    }

    public function Comercializacion()
    {
        $this->loadView('Comercializacion');
    }

    public function termino_usos()
    {
        $this->loadView('termino_usos');
    }

    public function catalogo()
    {
        $productoModel = new \App\Models\ProductoModel();

        // Captura de filtros desde GET
        $categoria   = $this->request->getGet('categoria');
        $color       = $this->request->getGet('color');
        $precioMin   = $this->request->getGet('precio_min');
        $precioMax   = $this->request->getGet('precio_max');

        // Preparar el builder con condiciones dinámicas
        $builder = $productoModel
            ->select(['id_producto', 'nombre', 'descripcion', 'precio', 'talla', 'color', 'imagen', 'estado', 'categoria'])
            ->where('estado', 'activo')
            ->where('deleted_at', null);

        if (!empty($categoria)) {
            $builder->where('categoria', $categoria);
        }

        if (!empty($color)) {
            $builder->where('color', $color);
        }

        if (!empty($precioMin)) {
            $builder->where('precio >=', floatval($precioMin));
        }

        if (!empty($precioMax)) {
            $builder->where('precio <=', floatval($precioMax));
        }

        $productos = $builder->findAll();

        // Para llenar selects dinámicos
        $categorias = $productoModel->distinct()->select('categoria')->where('estado', 'activo')->where('deleted_at', null)->findColumn('categoria');
        $colores    = $productoModel->distinct()->select('color')->where('estado', 'activo')->where('deleted_at', null)->findColumn('color');

        // Pasar filtros actuales para mantener los valores en el form
        $data = [
            'productos'  => $productos,
            'categorias' => $categorias ?? [],
            'colores'    => $colores ?? [],
            'filtros'    => [
                'categoria'   => $categoria,
                'color'       => $color,
                'precio_min'  => $precioMin,
                'precio_max'  => $precioMax,
            ]
        ];

         $this->loadView('catalogo_view', $data);
    }


    public function login()
    {
        $this->loadView('login');
    }

    public function registerForm()
    {
        $this->loadView('bodyregister');
    }
    
    public function admin()
    {
        // Corrección en la palabra 'administrador'
        if (session()->get('rol') !== 'administrador') {
            return redirect()->to('/')->with('error', 'Acceso no autorizado');
        }

        $this->loadView('admin_view');
    }

	public function admin_quienes_somos(){
        if (session()->get('rol') !== 'administrador') {
            return redirect()->to('/')->with('error', 'Acceso no autorizado');
        }

        $this->loadView('admin/quienes_somos');
    }


	public function admin_contacto()
	{
		if (session()->get('rol') !== 'administrador') {
			return redirect()->to('/')->with('error', 'Acceso no autorizado');
		}

		$this->loadView('admin/contacto');
	}

// ... (resto de los métodos existentes)

	public function admin_principal_view()
    {
        
        if (session()->get('rol') !== 'administrador') {
            return redirect()->to('/')->with('error', 'Acceso no autorizado');
        }

        $this->loadView('admin/principal_view');
    }
	
	public function admin_comercializacion()
    {
        // Corrección en la palabra 'administrador'
        if (session()->get('rol') !== 'administrador') {
            return redirect()->to('/')->with('error', 'Acceso no autorizado');
        }

        $this->loadView('admin/comercializacion');
    }

	public function admin_terminos_usos()
    {
        // Corrección en la palabra 'administrador'
        if (session()->get('rol') !== 'administrador') {
            return redirect()->to('/')->with('error', 'Acceso no autorizado');
        }

        $this->loadView('admin/terminos_usos');
    }

    public function admin_panel()
	{
		if (session()->get('rol') !== 'administrador') {
			return redirect()->to('/')->with('error', 'Acceso no autorizado');
		}

		$userModel = new \App\Models\UserModel();
		$data['usuarios'] = $userModel->withDeleted()->findAll();
		$data['title'] = 'Panel de Administración';

		$this->loadView('admin/panel_admin', $data);
	}

     public function admin_productos()
    {
        if (session()->get('rol') !== 'administrador') {
            return redirect()->to('/')->with('error','Acceso no autorizado');
        }

        $model = new \App\Models\ProductoModel();
        $data['productos'] = $model->where('deleted_at', null)->findAll();
        $this->loadView('admin/lista_productos', $data);
    }

    public function catalogo_admin()
{
    // Sólo administradores
    if (session()->get('rol') !== 'administrador') {
        return redirect()->to('/')->with('error','Acceso no autorizado');
    }

    $model = new \App\Models\ProductoModel();

    // 1) Leo filtros desde GET
    $cat = $this->request->getGet('categoria')  ?: null;
    $min = $this->request->getGet('precio_min') ?: null;
    $max = $this->request->getGet('precio_max') ?: null;

    // 2) Aplico al query
    if ($cat) $model->where('categoria', $cat);
    if (is_numeric($min)) $model->where('precio >=', (float)$min);
    if (is_numeric($max)) $model->where('precio <=', (float)$max);

    // 3) Activos y no borrados
    $productos = $model
        ->where('estado', 'activo')
        ->where('deleted_at', null)
        ->findAll();

    // 4) Saco lista de categorías para el select
    $categorias = (new \App\Models\ProductoModel())
        ->select('categoria')
        ->distinct()
        ->where('deleted_at', null)
        ->findColumn('categoria');

    $data = [
        'productos'  => $productos,
        'categorias' => $categorias,
        'filtros'    => ['cat'=>$cat,'min'=>$min,'max'=>$max],
        'title'      => 'Catálogo Admin'
    ];

    $this->loadView('admin/administrador_catalogo', $data);
}


    /** ————————— Admin: formulario de edición ————————— */
    public function admin_editar_producto($id)
    {
        // 1) Permisos
        if (session()->get('rol') !== 'administrador') {
            return redirect()->to('/')->with('error', 'Acceso no autorizado');
        }

        // 2) Cargo el producto
        $model    = new \App\Models\ProductoModel();
        $producto = $model->find($id);

        if (! $producto) {
            return redirect()->to('admin/productos')
                            ->with('error', 'Producto no encontrado');
        }

        // 3) Paso los datos a la vista
        $data['producto'] = $producto;

        // 4) La cargo envuelta en mi layout
        $this->loadView('admin/editar_producto', $data);
    }

        /**
         * ————————— Admin: formulario de edición de producto —————————
         */
        public function editar_producto($id)
        {
            // 1) Solo administradores
            if (session()->get('rol') !== 'administrador') {
                return redirect()->to('/')
                                ->with('error', 'Acceso no autorizado');
            }

            // 2) Recuperar producto
            $productoModel = new \App\Models\ProductoModel();
            $producto      = $productoModel->find($id);

            if (! $producto) {
                return redirect()->to('/admin/productos')
                                ->with('error', 'Producto no encontrado');
            }

            // 3) Pasar datos a la vista
            $data = [
                'producto' => $producto
            ];

            // 4) Cargar el layout + la vista editar_producto.php
            $this->loadView('admin/editar_producto', $data);
        }
    public function adminConsultas()
    {
        $session = session();
        if (!$session->get('logged_in') || $session->get('rol') !== 'administrador') {
            return redirect()->to('/login')->with('error', 'Acceso denegado');
        }

        $model = new \App\Models\ConsultaModel();
        $consultas = $model
            ->select('consultas.*, usuarios.nombre AS nombre_usuario, usuarios.apellido AS apellido_usuario')
            ->join('usuarios', 'usuarios.id_usuario = consultas.id_usuario', 'left')
            ->orderBy('created_at', 'DESC')
            ->findAll();

        $data = [
            'title'     => 'Consultas de usuarios',
            'consultas' => $consultas,
        ];

        return $this->loadView('admin/listado', $data);
    }




    public function usuario()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Debe iniciar sesión');
        }

        $this->loadView('usuario/usuario_view');
    }
}