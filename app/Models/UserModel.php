<?php namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'usuarios';
    protected $primaryKey = 'id_usuario';
    protected $returnType = 'array';
    
    // Habilitar soft deletes
    protected $useSoftDeletes = true;
    protected $deletedField  = 'deleted_at';
    
    protected $allowedFields = ['nombre', 'apellido', 'correo', 'contraseña', 'direccion', 'telefono', 'rol', 'deleted_at'];
    
    protected $useTimestamps = false; // Desactiva los timestamps
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
                    'nombre'     => 'required|min_length[3]',
                    'correo'     => 'required|valid_email|is_unique[usuarios.correo]',
                    'contraseña' => 'required|min_length[8]',
                ];

    protected $validationMessages = [
            'correo' => [
            'is_unique' => 'Este correo ya está registrado.']
    ];

     // Método para verificar credenciales (login)
        public function verificarCredenciales($correo, $contraseña) {
            $usuario = $this->where('correo', $correo)
                            ->where('deleted_at', null)
                            ->first();
            
            if ($usuario && password_verify($contraseña, $usuario['contraseña'])) {
                return $usuario;
            }
            return false;
        }

    
}