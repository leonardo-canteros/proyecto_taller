<?php namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'usuarios';
    protected $primaryKey = 'id_usuario';
    protected $returnType = 'array';

    protected $useSoftDeletes = true;
    protected $deletedField  = 'deleted_at';

    // Removido 'rol' para que no pueda ser seteado manualmente por usuarios
   protected $allowedFields = [
    'nombre', 'apellido', 'correo', 'contraseña',
    'direccion', 'telefono', 'rol', 'deleted_at' 
    ];


    protected $useTimestamps = false;

    protected $validationRules = [
        'nombre'     => 'required|min_length[3]',
        'apellido'   => 'required|min_length[3]',
        'correo'     => 'required|valid_email|is_unique[usuarios.correo]',
        'contraseña' => 'required|min_length[8]',
        'direccion'  => 'required|min_length[3]',
        'telefono'   => 'required|numeric|min_length[7]'
    ];

    protected $validationMessages = [
        'correo' => [
            'is_unique' => 'Este correo ya está registrado.'
        ]
    ];

    // Verificación de login
    public function verificarCredenciales($correo, $contraseña)
    {
        $usuario = $this->where('correo', $correo)
                        ->where('deleted_at', null)
                        ->first();

        if ($usuario && password_verify($contraseña, $usuario['contraseña'])) {
            return $usuario;
        }
        return false;
    }
}
