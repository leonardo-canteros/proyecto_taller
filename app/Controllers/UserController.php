<?php namespace App\Controllers;

use App\Models\UserModel;
use App\Models\CarritoModel;
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
    $userModel = new UserModel();
    $carritoModel = new CarritoModel(); // Añade esta línea
    
    $data = $this->request->getPost();

    if (empty($data)) {
        $data = $this->request->getJSON(true);
    }

    if (!$data) {
        return $this->failValidationErrors('Datos no recibidos');
    }

    // Validación adicional recomendada
    $rules = [
        'nombre' => 'required|min_length[3]',
        'apellido' => 'required|min_length[3]',
        'correo' => 'required|valid_email|is_unique[usuarios.correo]',
        'contraseña' => 'required|min_length[8]',
        'direccion' => 'required',
        'telefono' => 'required'
    ];

    if (!$this->validate($rules)) {
        return $this->failValidationErrors($this->validator->getErrors());
    }

    // Forzar rol como 'usuario'
    $data['rol'] = 'usuario';

    // Hashear contraseña
    $data['contraseña'] = password_hash($data['contraseña'], PASSWORD_DEFAULT);

    // Iniciar transacción
    $db = \Config\Database::connect();
    $db->transStart();

    try {
        // 1. Crear usuario
        $id_usuario = $userModel->insert($data);
        
        if (!$id_usuario) {
            throw new \RuntimeException('Error al crear usuario');
        }

        // 2. Crear carrito automáticamente (NUEVO)
        $carritoModel->crearCarrito($id_usuario);

        $db->transComplete();

        // 3. Iniciar sesión automáticamente (opcional pero recomendado)
        session()->set([
            'id_usuario' => $id_usuario,
            'nombre' => $data['nombre'],
            'correo' => $data['correo'],
            'rol' => 'usuario',
            'logged_in' => true
        ]);

        // Respuesta
        if ($this->request->isAJAX()) {
            return $this->respondCreated([
                'status' => 201,
                'message' => 'Usuario creado exitosamente',
                'id' => $id_usuario
            ]);
        }

        return redirect()->to('/usuario')->with('success', 'Registro exitoso');

    } catch (\Exception $e) {
        $db->transRollback();
        return $this->failServerError('Error en el registro: ' . $e->getMessage());
    }
}

    public function crearAdmin()
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
        $data['rol'] = 'administrador';

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
            return redirect()->back()->with('error', 'Usuario no encontrado');
        }

        $model->delete($id);
        return redirect()->to(site_url('admin/usuarios'))->with('success', 'Usuario desactivado correctamente');
    }


    public function restaurar($id)
    {
        $model = new UserModel();

        // Verificamos que el usuario esté eliminado lógicamente
        $usuario = $model->onlyDeleted()->find($id);
        if (!$usuario) {
            return $this->failNotFound('Usuario no encontrado o no está eliminado');
        }

        // Restauramos limpiando el campo deleted_at
        $actualizado = $model->update($id, ['deleted_at' => null]);

        if (!$actualizado) {
            return $this->failServerError('No se pudo restaurar el usuario.');
        }

        return redirect()->to(site_url('admin/usuarios'))->with('success', 'Usuario restaurado correctamente');
    }



}
