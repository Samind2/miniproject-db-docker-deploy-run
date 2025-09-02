<?php
/* Shaoransoft Developer */
namespace App\ViewModels;

class CoursesViewModel
{
    /* File size (bytes) */
    public static $fileSchedule = [
        'maxSize' => 5242880,
        'path' => './assets/courses/pdf',
        'accept' => [
            'application/vnd.ms-powerpoint',
            'application/pdf',
        ],
        'extension' => [
            'pptx',
            'pdf'
        ]
    ];

    public static $fileImage = [
        'maxSize' => 5242880,
        'path' => './assets/courses/images',
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