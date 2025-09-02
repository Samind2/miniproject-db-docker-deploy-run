<?php
/* Shaoransoft Developer */
namespace App\Models;

use CodeIgniter\Model;

class CourseCategoriesModel extends Model {
    protected $table = 'course_categories';
    protected $primaryKey = 'course_category_id';
    protected $allowedFields = [
        'title'
    ];
}
?>