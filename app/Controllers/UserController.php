<?php namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;

class UserController extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $model = new UserModel();
        return $this->respond($model->withDeleted()->findAll());
    }

    public function activos()
    {
        $model = new UserModel();
        return $this->respond($model->findAll());
    }

    public function show($id)
    {
        $model = new UserModel();
        $usuario = $model->withDeleted()->find($id);

        return $usuario
            ? $this->respond($usuario)
            : $this->failNotFound('Usuario no encontrado');
    }

    public function crear()
    {
        $model = new UserModel();
        $data = $this->request->getPost();

        if (empty($data)) {
            $data = $this->request->getJSON(true);
        }

        if (!$data) {
            return $this->failValidationErrors('Datos no recibidos');
        }

        // Forzar rol como 'usuario'
        $data['rol'] = 'usuario';

        if (!empty($data['contraseña'])) {
            $data['contraseña'] = password_hash($data['contraseña'], PASSWORD_DEFAULT);
        } else {
            return $this->failValidationErrors('La contraseña es obligatoria');
        }

        if (!$model->insert($data)) {
            return $this->failValidationErrors($model->errors());
        }

        if ($this->request->isAJAX()) {
            return $this->respondCreated([
                'status' => 201,
                'message' => 'Usuario creado exitosamente',
                'id' => $model->getInsertID()
            ]);
        }

        return redirect()->to('login')->with('success', 'Usuario registrado correctamente.');
    }

    public function update($id)
    {
        $model = new UserModel();
        $data = $this->request->getJSON(true);

        // Forzar rol como 'usuario' para evitar que se modifique
        $data['rol'] = 'usuario';

        if (isset($data['contraseña']) && !empty($data['contraseña'])) {
            $data['contraseña'] = password_hash($data['contraseña'], PASSWORD_DEFAULT);
        }

        if (!$model->withDeleted()->find($id)) {
            return $this->failNotFound('Usuario no encontrado');
        }

        if (!$model->update($id, $data)) {
            return $this->failValidationErrors($model->errors());
        }

        return $this->respond([
            'status' => 200,
            'message' => 'Usuario actualizado correctamente'
        ]);
    }

    public function delete($id)
    {
        $model = new UserModel();

        if (!$model->find($id)) {
            return $this->failNotFound('Usuario no encontrado');
        }

        $model->delete($id);
        return $this->respondDeleted([
            'status' => 200,
            'message' => 'Usuario eliminado lógicamente'
        ]);
    }

    public function restaurar($id)
    {
        $model = new UserModel();

        if (!$model->onlyDeleted()->find($id)) {
            return $this->failNotFound('Usuario no encontrado o no está eliminado');
        }

        $model->update($id, ['deleted_at' => null]);
        return $this->respond([
            'status' => 200,
            'message' => 'Usuario restaurado exitosamente'
        ]);
    }
}
