<?php
/* Shaoransoft Developer */
namespace App\Controllers\Manage;

use App\Controllers\BaseController;

use App\Models\ProvinceModel;

use App\Extension\Date;

class Enrollment extends BaseController
{
    public function Index()
    {
        if (!session()->get('LOGGED_IN'))
            return redirect()->to('/');
        if (!in_array($this->userLogged['user_level'], ['OFFICER','ADMINISTRATOR']))
            return redirect()->to('/');

        return $this->render('Manage/Enrollment/' . __FUNCTION__, [
            'provinceList' => (new ProvinceModel)->orderBy('name', 'ASC')->findAll(),
            'dateExtension' => new Date,
        ]);
    }
}
