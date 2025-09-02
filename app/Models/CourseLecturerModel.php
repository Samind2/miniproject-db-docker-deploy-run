<?php
/* Shaoransoft Developer */
namespace App\Models;

use CodeIgniter\Model;

class CourseLecturerModel extends Model {
    protected $table = 'course_lecturer';
    protected $allowedFields = [
        'course_id',
        'lecturer_id'
    ];
}
?>