<?php 
namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;

class AuthController extends BaseController 
{
    use ResponseTrait;

    public function __construct()
    {
        helper(['form', 'url']);
    }

    // Mostrar formulario de registro
    public function register()
    {
        echo view('head_view');
        echo view('navbar_view');
        echo view('bodyregister');
        echo view('footer_view');
    }

    // Procesar registro de usuario
    public function processRegister()
    {
        $model = new UserModel();
        
        // Obtener datos del formulario
        $data = [
            'nombre'     => $this->request->getPost('nombre'),
            'apellido'   => $this->request->getPost('apellido'),
            'correo'     => $this->request->getPost('correo'),
            'contraseña' => $this->request->getPost('contraseña'),
            'direccion'  => $this->request->getPost('direccion'),
            'telefono'   => $this->request->getPost('telefono'),
            'rol'        => 'usuario' // Siempre será usuario para registros públicos
        ];

        // Validar que los datos requeridos estén presentes
        if (empty($data['nombre']) || empty($data['correo']) || empty($data['contraseña'])) {
            session()->setFlashdata('error', 'Todos los campos obligatorios deben ser completados');
            return redirect()->back()->withInput();
        }

        // Verificar si el correo ya existe
        if ($model->correoExiste($data['correo'])) {
            session()->setFlashdata('error', 'Este correo ya está registrado');
            return redirect()->back()->withInput();
        }

        // Encriptar la contraseña
        $data['contraseña'] = password_hash($data['contraseña'], PASSWORD_DEFAULT);

        // Intentar insertar el usuario
        if ($model->insert($data)) {
            session()->setFlashdata('success', 'Usuario registrado exitosamente. Ya puedes iniciar sesión.');
            return redirect()->to('login'); // Sin la barra inicial
        } else {
            // Obtener errores de validación
            $errors = $model->errors();
            session()->setFlashdata('error', 'Error al registrar usuario: ' . implode(', ', $errors));
            return redirect()->back()->withInput();
        }
    }

    // Mostrar formulario de login
    public function login()
    {
        echo view('head_view');
        echo view('navbar_view');
        echo view('bodylogin');
        echo view('footer_view');
    }

    // Procesar login
    public function processLogin()
    {
        $model = new UserModel();
        
        $correo = $this->request->getPost('correo');
        $contraseña = $this->request->getPost('contraseña');

        if (empty($correo) || empty($contraseña)) {
            session()->setFlashdata('error', 'Correo y contraseña son obligatorios');
            return redirect()->back();
        }

        $usuario = $model->verificarCredenciales($correo, $contraseña);

        if ($usuario) {
            // Iniciar sesión
            session()->set([
                'user_id' => $usuario['id_usuario'],
                'user_name' => $usuario['nombre'],
                'user_email' => $usuario['correo'],
                'user_role' => $usuario['rol'],
                'logged_in' => true
            ]);

            session()->setFlashdata('success', 'Bienvenido ' . $usuario['nombre']);
            return redirect()->to('home'); // o la página principal que tengas
        } else {
            session()->setFlashdata('error', 'Credenciales incorrectas');
            return redirect()->back();
        }
    }

    // Cerrar sesión
    public function logout()
    {
        session()->destroy();
        return redirect()->to('login');
    }
}