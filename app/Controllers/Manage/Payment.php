<?php
/* Shaoransoft Developer */
namespace App\Controllers\Manage;

use App\Controllers\BaseController;

class Payment extends BaseController
{
    public function Index()
    {
        if (!session()->get('LOGGED_IN'))
            return redirect()->to('/');
        if (!in_array($this->userLogged['user_level'], ['OFFICER','ADMINISTRATOR']))
            return redirect()->to('/');

        return $this->render('Manage/Payment/' . __FUNCTION__);
    }
}
