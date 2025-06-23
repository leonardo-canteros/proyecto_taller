<?php namespace App\Models;

use CodeIgniter\Model;

class ContactoModel extends Model
{
    protected $table      = 'contacto'; // 👈 Singular, como la tabla
    protected $primaryKey = 'id_contacto';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['nombre', 'asunto', 'correo', 'mensaje'];

    // Activar timestamps (ya que los agregaste en la BD)
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
