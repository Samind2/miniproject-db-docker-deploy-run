<?php
/* Shaoransoft Developer */
namespace App\Controllers;

class Calendar extends BaseController
{
    public function Index()
    {
        return $this->render('Calendar/' . __FUNCTION__);
    }
}
