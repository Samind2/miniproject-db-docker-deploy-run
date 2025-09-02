<?php
/* Shaoransoft Developer */
namespace App\Models;

use CodeIgniter\Model;

class FacultyModel extends Model {
    protected $table = 'faculty';
    protected $primaryKey = 'faculty_id';
    protected $allowedFields = [
        'name_tha',
        'name_eng'
    ];
}
?>