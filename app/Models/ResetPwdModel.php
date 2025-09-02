<?php
/* Shaoransoft Developer */
namespace App\Models;

use CodeIgniter\Model;

class ResetPwdModel extends Model {
    protected $table = 'reset_pwd';
    protected $primaryKey = 'reset_pwd_id';
    protected $allowedFields = [
        'user_id',
        'token',
        'status',
        'expiration_date',
        'created'
    ];
}
?>