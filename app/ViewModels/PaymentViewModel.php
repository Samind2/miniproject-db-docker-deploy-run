<?php
/* Shaoransoft Developer */
namespace App\ViewModels;

class PaymentViewModel
{
    /* File size (bytes) */
    public static $fileImage = [
        'maxSize' => 5242880,
        'path' => './upload/proof_payment',
        'accept' => [
            'image/jpg',
            'image/jpeg',
            'image/png',
        ],
        'extension' => [
            'jpg',
            'jpeg',
            'png',
        ]
    ];
}
?>