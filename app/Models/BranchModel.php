<?php
/* Shaoransoft Developer */
namespace App\Models;

use CodeIgniter\Model;

class BranchModel extends Model {
    protected $table = 'branch';
    protected $primaryKey = 'branch_id';
    protected $allowedFields = [
        'code',
        'faculty_id',
        'name_tha',
        'name_eng'
    ];
}
?>