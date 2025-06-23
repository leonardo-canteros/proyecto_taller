<?php
namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;

class AuthController extends BaseController
{
    use ResponseTrait;
  public function login()
{
    // Verifica si es JSON o POST normal
    if ($this->request->getHeaderLine('Content-Type') === 'application/json') {
        $data = $this->request->getJSON(true);
    } else {
        $data = $this->request->getPost();
    }

    // Validar campos requeridos
    if (empty($data['correo']) || empty($data['contraseña'])) {
        if ($this->request->isAJAX()) {
            return $this->fail('Correo y contraseña son requeridos', 400);
        } else {
            return redirect()->to('/login')->with('error', 'Correo y contraseña son requeridos');
        }
    }

    if (!filter_var($data['correo'], FILTER_VALIDATE_EMAIL)) {
        if ($this->request->isAJAX()) {
            return $this->fail('El correo no tiene un formato válido', 400);
        } else {
            return redirect()->to('/login')->with('error', 'El correo no tiene un formato válido');
        }
    }

    $userModel = new UserModel();
    $user = $userModel->where('correo', $data['correo'])
                      ->where('deleted_at', null)
                      ->first();

    if (!$user || !password_verify($data['contraseña'], $user['contraseña'])) {
        if ($this->request->isAJAX()) {
            return $this->failUnauthorized('Credenciales incorrectas');
        } else {
            return redirect()->to('/login')->with('error', 'Credenciales incorrectas o usuario no registrado');
        }
    }

    // Crear sesión
    $sessionData = [
        'id_usuario' => $user['id_usuario'],
        'correo'     => $user['correo'],
        'nombre'     => $user['nombre'],
        'rol'        => $user['rol'] ?? 'usuario',
        'logged_in'  => true,
        'carrito'    => []
    ];
    session()->set($sessionData);

    // Redirección o respuesta JSON
    if ($this->request->isAJAX()) {
        return $this->respond([
            'status'  => 'success',
            'message' => 'Login exitoso',
            'data'    => $sessionData
        ]);
    } else {
        return redirect()->to($user['rol'] === 'administrador' ? '/admin/principal' : '/usuario/principal');
    }
}




    public function logout()
        {
            session()->destroy();

            if ($this->request->isAJAX()) {
                return $this->respond(['status' => 'success', 'message' => 'Sesión cerrada']);
            } else {
                return redirect()->to('principal');

            }
        }


}