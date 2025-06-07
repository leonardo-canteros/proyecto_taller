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
    
    // Método para obtener todos los usuarios (incluyendo eliminados)
    public function traerTodosConEliminados()
    {
        return $this->withDeleted()->findAll();
    }
    
    // Método para obtener solo usuarios activos
    public function traerTodos()
    {
        return $this->findAll();
    }
    
    // Método para obtener un usuario específico (incluyendo eliminados)
    public function traerPorIdConEliminado($id)
    {
        return $this->withDeleted()->find($id);
    }
    
    // Método para "eliminar" lógicamente
    public function eliminarUsuario($id)
    {
        return $this->delete($id); // Esto marcará deleted_at pero no borrará físicamente
    }
    
    // Método para restaurar un usuario eliminado
    public function restaurarUsuario($id)
    {
        return $this->update($id, ['deleted_at' => null]);
    }
}