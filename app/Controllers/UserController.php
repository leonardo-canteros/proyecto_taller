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

    public function crear()
        {
            $model = new UserModel();

            // Detectar si vienen datos JSON (API) o desde un formulario (POST)
            $data = $this->request->getPost();

            if (empty($data)) {
                $data = $this->request->getJSON(true);
            }

            if (empty($data)) {
                return $this->failValidationErrors('Datos no recibidos');
            }

            // Validar contraseña
            if (!empty($data['contraseña'])) {
                $data['contraseña'] = password_hash($data['contraseña'], PASSWORD_DEFAULT);
            } else {
                return $this->failValidationErrors('La contraseña es obligatoria');
            }

            // Valor fijo para el rol
            $data['rol'] = 'usuario';

            if ($model->insert($data)) {
                // Si es API, responder JSON
                if ($this->request->isAJAX() || $this->request->getHeaderLine('Accept') === 'application/json') {
                    return $this->respondCreated([
                        'status' => 201,
                        'message' => 'Usuario creado exitosamente',
                        'id' => $model->getInsertID()
                    ]);
                }

                // Si es formulario, redirigir al login
                return redirect()->to(base_url('login'))->with('success', 'Usuario registrado correctamente.');
            }

            // Si hubo errores
            if ($this->request->isAJAX()) {
                return $this->failValidationErrors($model->errors());
            }

            // Para vista HTML
            return view('bodyregister', ['error' => 'Error al registrar usuario.']);
        }


    /* Crear nuevo usuario
    //public function crear()
    {
        $model = new UserModel();
        $data = $this->request->getJSON(true);

            if (empty($data)) {
                return $this->failValidationErrors('Datos no recibidos');
            }

            // Validar y encriptar la contraseña si viene
            if (!empty($data['contraseña'])) {
                $data['contraseña'] = password_hash($data['contraseña'], PASSWORD_DEFAULT);
            } else {
                return $this->failValidationErrors('La contraseña es obligatoria');
            }

            if ($model->insert($data)) {
                return $this->respondCreated([
                    'status' => 201,
                    'message' => 'Usuario creado exitosamente',
                    'id' => $model->getInsertID()
                ]);
            }

            return $this->failValidationErrors($model->errors());
    }*/

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

     // Método para validar correo únicos
        public function correoExiste($correo) {
            return $this->where('correo', $correo)->first();
        }

        protected $validationRules = [
                    'nombre'     => 'required|min_length[3]',
                    'correo'     => 'required|valid_email|is_unique[usuarios.correo]',
                    'contraseña' => 'required|min_length[8]',
                ];

                protected $validationMessages = [
                    'correo' => [
                        'is_unique' => 'Este correo ya está registrado.'
                    ]
                ];
}