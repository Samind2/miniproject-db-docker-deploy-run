<?php
/* Shaoransoft Developer */
namespace App\Controllers\Manage;

use App\Controllers\BaseController;

use App\Models\FacultyModel;
use App\Models\BranchModel;

use App\ViewModels\LecturerViewModel;

class Lecturer extends BaseController
{
    public function Index()
    {
        if (!session()->get('LOGGED_IN'))
            return redirect()->to('/');
        if (!in_array($this->userLogged['user_level'], ['OFFICER','ADMINISTRATOR']))
            return redirect()->to('/');

        helper('number');
        $facultyList = (new FacultyModel)->orderBy('name_tha', 'asc')->findAll();
        $branchOptions = [];
        $branchModel = new BranchModel;
        foreach ($facultyList as $faculty)
        {
            $branchOptions[] = [
                'label' => $faculty['name_tha'],
                'options' => $branchModel->where('faculty_id', $faculty['faculty_id'])->orderBy('code', 'ASC')->findAll()
            ];
        }
        return $this->render('Manage/Lecturer/' . __FUNCTION__, [
            'branchOptions' => $branchOptions,
            'fileImage' => LecturerViewModel::$fileImage
        ]);
    }
}
