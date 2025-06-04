<?php namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;

class UserController extends BaseController
{
    use ResponseTrait;

    // Obtener todos los usuarios (incluyendo eliminados lógicos)
    public function index()
    {
        $model = new UserModel();
        $usuarios = $model->withDeleted()->findAll();
        return $this->respond($usuarios);
    }

    // Obtener solo usuarios activos
    public function activos()
    {
        $model = new UserModel();
        $usuarios = $model->findAll();
        return $this->respond($usuarios);
    }

    // Obtener un usuario específico (incluyendo eliminados)
    public function show($id)
    {
        $model = new UserModel();
        $usuario = $model->withDeleted()->find($id);
        
        if($usuario) {
            return $this->respond($usuario);
        }
        
        return $this->failNotFound('Usuario no encontrado');
    }

    // Crear nuevo usuario
    public function crear()
    {
        $model = new UserModel();
        $data = $this->request->getJSON(true);
        
        if(empty($data)) {
            return $this->failValidationErrors('Datos no recibidos');
        }

        if($model->insert($data)) {
            return $this->respondCreated([
                'status' => 201,
                'message' => 'Usuario creado exitosamente',
                'id' => $model->getInsertID()
            ]);
        }
        
        return $this->failValidationErrors($model->errors());
    }

    // Actualizar usuario
    public function update($id)
    {
        $model = new UserModel();
        $data = $this->request->getJSON(true);
        
        if($model->withDeleted()->find($id)) {
            if($model->update($id, $data)) {
                return $this->respond([
                    'status' => 200,
                    'message' => 'Usuario actualizado correctamente'
                ]);
            }
            return $this->failValidationErrors($model->errors());
        }
        
        return $this->failNotFound('Usuario no encontrado');
    }

    // Eliminación lógica
    public function delete($id)
    {
        $model = new UserModel();
        
        if($model->find($id)) {
            $model->delete($id);
            return $this->respondDeleted([
                'status' => 200,
                'message' => 'Usuario desactivado (eliminación lógica)'
            ]);
        }
        
        return $this->failNotFound('Usuario no encontrado');
    }

    // Restaurar usuario eliminado lógicamente
    public function restaurar($id)
    {
        $model = new UserModel();
        
        if($model->onlyDeleted()->find($id)) {
            $model->update($id, ['deleted_at' => null]);
            return $this->respond([
                'status' => 200,
                'message' => 'Usuario restaurado exitosamente'
            ]);
        }
        
        return $this->failNotFound('Usuario no encontrado o no estaba eliminado');
    }
}