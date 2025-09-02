<?php
/* Shaoransoft Developer */
namespace App\Models;

use CodeIgniter\Model;

class PaymentModel extends Model {
    protected $table = 'payment';
    protected $primaryKey = 'payment_id';
    protected $allowedFields = [
        'status',
        'enroll_id',
        'user_id',
        'slip_date',
        'slip_time',
        'slip_amount',
        'slip_image',
        'inspector',
        'created'
    ];
}
?>