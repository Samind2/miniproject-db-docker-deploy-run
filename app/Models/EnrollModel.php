<?php
/* Shaoransoft Developer */
namespace App\Models;

use CodeIgniter\Model;

class EnrollModel extends Model {
    protected $table = 'enroll';
    protected $primaryKey = 'enroll_id';
    protected $allowedFields = [
        'status',
        'description',
        'course_id',
        'course_batch_id',
        'regis_fee',
        'user_id',
        'fullname_tha',
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
        'invoice_no',
        'invoice_name',
        'invoice_tax_id',
        'invoice_address',
        'invoice_sub_district',
        'invoice_district',
        'invoice_province',
        'invoice_postal_code',
        'inspector',
        'has_alert',
        'enrolled'
    ];
}
?>