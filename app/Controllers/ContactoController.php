<?php namespace App\Controllers;

use App\Models\ContactoModel;
use CodeIgniter\Controller;

class ContactoController extends BaseController
{
    public function Enviar()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'nombre'   => 'required|min_length[2]',
            'asunto'   => 'required|min_length[3]',
            'correo'   => 'required|valid_email',
            'mensaje'  => 'required|min_length[5]'
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'nombre'  => $this->request->getPost('nombre'),
            'asunto'  => $this->request->getPost('asunto'),
            'correo'  => $this->request->getPost('correo'),
            'mensaje' => $this->request->getPost('mensaje'),
        ];

        $model = new ContactoModel();

        if (! $model->insert($data)) {
            // Mostrar errores en desarrollo
            dd($model->errors());
        }
        log_message('error', '>> CONTACTO ENVIAR EJECUTADO <<');

        return redirect()->to('/Contacto')->with('success', 'Gracias por contactarnos. Tu mensaje ha sido enviado.');
    }

    public function listar()
    {
        $session = session();
        $rol = $session->get('rol');

        // Verificar si el usuario es administrador
        if ($rol !== 'admin') {
            return redirect()->to('/')->with('error', 'Acceso no autorizado');
        }

        $model = new \App\Models\ContactoModel();
        $contactos = $model->findAll();

        return view('admin/contactos_listar', ['contactos' => $contactos]);
    }

}
