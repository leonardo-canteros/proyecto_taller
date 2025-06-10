<?php
namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;

class AuthController extends BaseController
{
    use ResponseTrait;

    public function login()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $userModel = new UserModel();
        $user = $userModel->where('email', $email)->first();

        if (!$user || !password_verify($password, $user['password'])) {
            return $this->failUnauthorized('Credenciales incorrectas');
        }

        // Crear sesión
        session()->set([
            'id_usuario' => $user['id'],
            'logged_in' => true
        ]);

        return $this->respond([
            'message' => 'Login exitoso',
            'user' => [
                'id' => $user['id'],
                'email' => $user['email']
            ]
        ]);
    }

    public function logout()
    {
        session()->destroy();
        return $this->respond(['message' => 'Sesión cerrada']);
    }
}