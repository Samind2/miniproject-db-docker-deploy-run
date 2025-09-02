<?php
/* Shaoransoft Developer */
namespace App\Controllers\Manage;

use App\Controllers\BaseController;

class Faculty extends BaseController
{
    public function Index()
    {
        if (!session()->get('LOGGED_IN'))
            return redirect()->to('/');
        if ($this->userLogged['user_level'] !== 'ADMINISTRATOR')
            return redirect()->to('/');

        return $this->render('Manage/Faculty/' . __FUNCTION__);
    }
}
