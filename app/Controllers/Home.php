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

    public function catalogo()
    {
        $productoModel = new \App\Models\ProductoModel();
        
        $data['productos'] = $productoModel->select([
            'id_producto',
            'nombre',
            'descripcion',
            'precio',
            'talla',
            'color',
            'imagen',
            'estado'
        ])->where('estado', 'activo')
          ->where('deleted_at', null)
          ->findAll();

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

    public function usuario()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Debe iniciar sesión');
        }

        $this->loadView('usuario/usuario_view');
    }
}