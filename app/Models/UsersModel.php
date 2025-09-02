<?php
/* Shaoransoft Developer */
namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model {
    protected $table = 'users';
    protected $primaryKey = 'user_id';
    protected $allowedFields = [
        'user_level',
        'login_pwd',
        'authorized',
        'name_title_tha',
        'firstname_tha',
        'lastname_tha',
        'fullname_tha',
        'name_title_eng',
        'firstname_eng',
        'lastname_eng',
        'fullname_eng',
        'id_card',
        'birth',
        'email',
        'mobile',
        'address',
        'sub_district',
        'district',
        'province',
        'postal_code',
        'register'
    ];
}
?>