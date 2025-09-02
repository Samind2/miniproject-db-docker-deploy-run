<?php
/* Shaoransoft Developer */
namespace App\Models;

use CodeIgniter\Model;

class ProvinceModel extends Model {
    protected $table = 'province';
    protected $primaryKey = 'province_id';
    protected $allowedFields = [
        'name'
    ];
}
?>