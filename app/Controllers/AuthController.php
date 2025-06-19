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
        $data = $this->request->getJSON(true); // Devuelve array
    } else {
        $data = $this->request->getPost(); // Formulario HTML normal
    }

    // Validar campos requeridos
    if (empty($data['correo']) || empty($data['contraseña'])) {
        return $this->fail('Correo y contraseña son requeridos', 400);
    }

    if (!filter_var($data['correo'], FILTER_VALIDATE_EMAIL)) {
        return $this->fail('El correo no tiene un formato válido', 400);
    }

    $userModel = new UserModel();
    $user = $userModel->where('correo', $data['correo'])
                      ->where('deleted_at', null)
                      ->first();

    if (!$user || !password_verify($data['contraseña'], $user['contraseña'])) {
        return $this->failUnauthorized('Credenciales incorrectas');
    }

    // Crear sesión
    $sessionData = [
        'id_usuario' => $user['id_usuario'],
        'correo' => $user['correo'],
        'nombre' => $user['nombre'],
        'rol' => $user['rol'] ?? 'usuario',
        'logged_in' => true,

        // Inicializar carrito vacío
        'carrito' => []
    ];
    session()->set($sessionData);

    // Redirección o respuesta JSON
    if ($this->request->isAJAX()) {
        return $this->respond([
            'status' => 'success',
            'message' => 'Login exitoso',
            'data' => $sessionData
        ]);
    } else {
        // Redirigir según el rol
        return redirect()->to($user['rol'] === 'administrador' ? '/admin' : '/usuario');
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