<?php
/* Shaoransoft Developer */
namespace App\Controllers\Manage;

use App\Controllers\BaseController;

use App\Models\ProvinceModel;

use App\Extension\Date;

class Users extends BaseController
{
    public function Index()
    {
        if (!session()->get('LOGGED_IN'))
            return redirect()->to('/');
        if ($this->userLogged['user_level'] !== 'ADMINISTRATOR')
            return redirect()->to('/');

        return $this->render('Manage/Users/' . __FUNCTION__, [
            'provinceList' => (new ProvinceModel)->orderBy('name', 'ASC')->findAll(),
            'dateExtension' => new Date,
        ]);
    }
}
