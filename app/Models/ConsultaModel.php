<?php
namespace App\Models;

use CodeIgniter\Model;

class ConsultaModel extends Model
{
    protected $table      = 'consultas';
    protected $primaryKey = 'id_consulta';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'id_usuario',
        'asunto',
        'mensaje',
        'estado',
        'respuesta',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
