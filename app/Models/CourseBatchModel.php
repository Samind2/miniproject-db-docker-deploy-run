<?php
/* Shaoransoft Developer */
namespace App\Models;

use CodeIgniter\Model;

class CourseBatchModel extends Model {
    protected $table = 'course_batch';
    protected $primaryKey = 'course_batch_id';
    protected $allowedFields = [
        'course_id',
        'min_enroll',
        'max_enroll',
        'start_enrollment',
        'end_enrollment',
        'start_classroom',
        'end_classroom',
        'end_payment',
        'is_active',
        'created',
        'creator'
    ];
}
?>