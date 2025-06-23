<?php
// app/Controllers/ConsultaController.php

namespace App\Controllers;

use App\Models\ConsultaModel;
use CodeIgniter\Controller;

class ConsultaController extends BaseController
{
    public function guardarRespuesta($id_consulta)
    {
        $model = new ConsultaModel();

        $respuesta = $this->request->getPost('respuesta');
        if (empty($respuesta)) {
            return redirect()->back()->with('error', 'La respuesta no puede estar vacía');
        }

        $model->update($id_consulta, [
            'respuesta' => $respuesta,
            'estado'    => 'respondido',
        ]);

        return redirect()->to(site_url('admin/consultas'))->with('success', 'Consulta respondida correctamente');
    }

    public function enviar()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $data = [
            'id_usuario' => $session->get('id_usuario'),
            'asunto'     => $this->request->getPost('asunto'),
            'mensaje'    => $this->request->getPost('mensaje'),
            'estado'     => 'pendiente',
        ];

        $model = new ConsultaModel();
        $model->insert($data);

        return redirect()->to('/usuario/mis_consultas')->with('success', 'Consulta enviada correctamente');
    }
}
