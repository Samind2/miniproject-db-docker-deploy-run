<?php
/* Shaoransoft Developer */
namespace App\Models;

use CodeIgniter\Model;

class LecturerModel extends Model {
    protected $table = 'lecturer';
    protected $primaryKey = 'lecturer_id';
    protected $allowedFields = [
        'branch_id',
        'firstname',
        'lastname',
        'fullname',
        'is_internal',
        'url',
        'image'
    ];
}
?>