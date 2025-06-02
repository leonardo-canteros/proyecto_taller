<?php namespace App\Controllers;
use App\Models\UsuarioModel;

class UsuarioController extends BaseController
{
    protected $usuarioModel;

    public function __construct() {
        $this->usuarioModel = new UsuarioModel();
    }

    // Listar todos los usuarios (GET /usuarios)
    public function index() {
        $data['usuarios'] = $this->usuarioModel->findAll();
        return view('admin/usuarios/index', $data);
    }

    // Mostrar un usuario (GET /usuarios/(:num))
    public function show($id) {
        $data['usuario'] = $this->usuarioModel->find($id);
        return view('admin/usuarios/editar', $data);
    }

    // Crear usuario (POST /usuarios/crear)
    public function create() {
        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT)
        ];
        $this->usuarioModel->insert($data);
        return redirect()->to('/usuarios')->with('success', 'Usuario creado');
    }

    // Actualizar usuario (PUT /usuarios/editar/(:num))
    public function update($id) {
        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'email' => $this->request->getPost('email')
        ];
        $this->usuarioModel->update($id, $data);
        return redirect()->to('/usuarios')->with('success', 'Usuario actualizado');
    }

    // Eliminar usuario (DELETE /usuarios/eliminar/(:num))
    public function delete($id) {
        $this->usuarioModel->delete($id);
        return redirect()->to('/usuarios')->with('success', 'Usuario eliminado');
    }
}