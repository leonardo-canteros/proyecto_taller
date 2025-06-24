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

    // Dentro de App\Controllers\Home
    public function carrito($id_usuario)
    {
        if (!session()->has('id_usuario') || session()->get('id_usuario') != $id_usuario) {
            return redirect()->to('/login')->with('error', 'No autorizado');
        }

        $carritoModel = new \App\Models\CarritoModel();
        $data = [
            'productos' => $carritoModel->obtenerProductosConDetalles($id_usuario),
            'total' => $carritoModel->calcularTotalCarrito($id_usuario),
            'titulo' => 'Mi Carrito de Compras'
        ];

        // Cargar la vista completa
        return $this->loadView('carrito_view', $data);
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
        $model = new \App\Models\ContactoModel();
        $data['contactos'] = $model->findAll();
        $this->loadView('admin/contactos_listar', $data);
    }

    public function admin_usuarios()
    {
        if (session()->get('rol') !== 'administrador') {
            return redirect()->to('/')->with('error', 'Acceso no autorizado');
        }

        $model = new \App\Models\UserModel();
        $usuarios = $model->withDeleted()->findAll();

        $data['usuarios'] = $usuarios;
        $this->loadView('admin/usuarios_listar', $data);
    }

    public function verProducto($id)
    {
        $productoModel = new \App\Models\ProductoModel();
        $producto = $productoModel->find($id);

        if (!$producto) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Producto no encontrado.");
        }

        $data = ['producto' => $producto];
        return $this->loadView('producto/ver_producto', $data);
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

    public function adminResponder($id_consulta)
    {
        $consultaModel = new \App\Models\ConsultaModel();
        $db = \Config\Database::connect();

        // Traemos la consulta y datos del usuario que la envió
        $consulta = $db->table('consultas')
                    ->select('consultas.*, usuarios.nombre AS nombre_usuario, usuarios.apellido AS apellido_usuario')
                    ->join('usuarios', 'usuarios.id_usuario = consultas.id_usuario')
                    ->where('consultas.id_consulta', $id_consulta)
                    ->get()
                    ->getRowArray();

        if (!$consulta) {
            return redirect()->to(site_url('admin/consultas'))->with('error', 'Consulta no encontrada.');
        }

        $data = [
            'title' => 'Responder Consulta',
            'consulta' => $consulta
        ];

        return $this->loadView('admin/enviar', $data);
    }
    /*usuarios <registrados> */ 

    public function usuario()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Debe iniciar sesión');
        }

        $this->loadView('usuario/principal_view');
        
    }
    public function usuario_quienes_somos()
    {
        return $this->loadView('quienes_somos', ['title' => '¿Quiénes Somos?']);
    }

    public function usuario_termino_usos()
    {
        return $this->loadView('termino_usos', ['title' => 'Términos y Condiciones']);
    }

    public function perfilUsuario()
    {
        $session = session();

        if (!$session->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Debes iniciar sesión para acceder al perfil.');
        }

        $userModel = new \App\Models\UserModel();
        $idUsuario = $session->get('id_usuario');
        $usuario = $userModel->find($idUsuario);

        if (!$usuario) {
            return redirect()->to('/')->with('error', 'Usuario no encontrado.');
        }

        $this->loadView('usuario/perfil_view', ['usuario' => $usuario]);
    }

    public function perfilAdmin()
    {
        $session = session();
        $id = $session->get('id_usuario');

        $usuarioModel = new \App\Models\UserModel();
        
        // Este withDeleted() permite que aunque el admin esté marcado como eliminado, se muestre su perfil
        $usuario = $usuarioModel->withDeleted()->find($id);

        if (!$usuario) {
            return redirect()->to('/')->with('error', 'Administrador no encontrado');
        }

        $this->loadView('admin/perfil', ['usuario' => $usuario]);
    }




    public function usuario_comercializacion()
    {
        return $this->loadView('Comercializacion', ['title' => 'Comercialización']);
    }

    public function usuario_catalogo()
    {
        $productoModel = new \App\Models\ProductoModel();

        // Obtener filtros desde la URL
        $categoria = $this->request->getGet('categoria');
        $color = $this->request->getGet('color');
        $precio_min = $this->request->getGet('precio_min');
        $precio_max = $this->request->getGet('precio_max');

        // Construir la consulta
        $query = $productoModel;
        if (!empty($categoria)) {
            $query = $query->where('categoria', $categoria);
        }
        if (!empty($color)) {
            $query = $query->where('color', $color);
        }
        if (!empty($precio_min)) {
            $query = $query->where('precio >=', $precio_min);
        }
        if (!empty($precio_max)) {
            $query = $query->where('precio <=', $precio_max);
        }

        // Obtener productos filtrados
        $productos = $query->findAll();

        // Obtener todas las categorías y colores únicos para los filtros
        $categorias = $productoModel->distinct()->select('categoria')->findColumn('categoria');
        $colores    = $productoModel->distinct()->select('color')->findColumn('color');

        // Preparar datos para la vista
        $data = [
            'title'      => 'Catálogo de Productos',
            'productos'  => $productos,
            'categorias' => $categorias,
            'colores'    => $colores,
            'filtros'    => [
                'categoria'   => $categoria,
                'color'       => $color,
                'precio_min'  => $precio_min,
                'precio_max'  => $precio_max,
            ]
        ];

        return $this->loadView('catalogo_view', $data);
    }
    
    public function formularioConsulta()
    {
        return $this->loadView('usuario/enviar', ['title' => 'Enviar Consulta']);
    }

    public function misConsultas()
{
    $session = session();
    if (!$session->get('logged_in')) {
        return redirect()->to('/login');
    }

    $idUsuario = $session->get('id_usuario');
    $consultaModel = new \App\Models\ConsultaModel();

    $consultas = $consultaModel
        ->where('id_usuario', $idUsuario)
        ->orderBy('created_at', 'DESC')
        ->findAll();

    return $this->loadView('usuario/mis_consultas', [
        'title' => 'Mis Consultas',
        'consultas' => $consultas
    ]);
}


}