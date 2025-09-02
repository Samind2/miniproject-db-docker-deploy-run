<?php
/* Shaoransoft Developer */
namespace App\ViewModels;

class LecturerViewModel
{
    /* File size (bytes) */
    public static $fileImage = [
        'maxSize' => 5242880,
        'path' => './assets/lecturer/images',
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