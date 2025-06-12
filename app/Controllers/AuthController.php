<?php
namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;

class AuthController extends BaseController
{
    use ResponseTrait;
    public function login()
    {
        // Obtener y convertir datos JSON
        $json = $this->request->getJSON();
        $post = $this->request->getPost();
        
        // Usar datos JSON si existen, de lo contrario usar POST
        $data = $json ? json_decode(json_encode($json), true) : $post;

        // Validar que existan los campos requeridos
        if (empty($data['correo']) || empty($data['contraseña'])) {
            return $this->fail('Correo y contraseña son requeridos', 400);
        }

        // Validar formato del correo
        if (!filter_var($data['correo'], FILTER_VALIDATE_EMAIL)) {
            return $this->fail('El correo no tiene un formato válido', 400);
        }

        $userModel = new UserModel();
        $user = $userModel->where('correo', $data['correo'])
                          ->where('deleted_at', null)
                          ->first();

        if (!$user) {
            return $this->failUnauthorized('Credenciales incorrectas');
        }

       

        // Crear sesión
        $sessionData = [
            'id_usuario' => $user['id_usuario'],
            'correo' => $user['correo'],
            'nombre' => $user['nombre'],
            'rol' => $user['rol'] ?? 'usuario',
            'logged_in' => true
        ];

        session()->set($sessionData);

        // Preparar respuesta
        $response = [
            'status' => 'success',
            'message' => 'Login exitoso',
            'data' => [
                'id' => $user['id_usuario'],
                'nombre' => $user['nombre'],
                'correo' => $user['correo'],
                'rol' => $user['rol'] ?? 'usuario'
            ]
        ];

        return $this->respond($response);
    }

    public function logout()
        {
            session()->destroy();

            // Si la petición es web normal, redirige:
            if ($this->request->isAJAX()) {
                return $this->respond(['status' => 'success', 'message' => 'Sesión cerrada']);
            } else {
                return redirect()->to('/');
            }
        }

}