<?php
/* Shaoransoft Developer */
namespace App\Models;

use CodeIgniter\Model;

class CoursesModel extends Model {
    protected $table = 'courses';
    protected $primaryKey = 'course_id';
    protected $allowedFields = [
        'course_category_id',
        'branch_id',
        'title',
        'image',
        'is_onsite',
        'online_url',
        'online_requirement',
        'location',
        'objective',
        'target',
        'content',
        'evaluation',
        'expected_results',
        'schedule',
        'contact',
        'regis_fee',
        'class_hours',
        'display',
        'views_count',
        'created',
        'creator'
    ];
}
?>