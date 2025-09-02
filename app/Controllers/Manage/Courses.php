<?php
/* Shaoransoft Developer */
namespace App\Controllers\Manage;

use App\Controllers\BaseController;

use App\Models\CourseCategoriesModel;
use App\Models\FacultyModel;
use App\Models\BranchModel;
use App\Models\CoursesModel;
use App\Models\CourseBatchModel;
use App\Models\LecturerModel;
use App\Models\ProvinceModel;
use App\Models\PaymentModel;

use App\ViewModels\CoursesViewModel;

use App\Extension\Date;

class Courses extends BaseController
{
    public function Index()
    {
        if (!session()->get('LOGGED_IN'))
            return redirect()->to('/');
        if (!in_array($this->userLogged['user_level'], ['OFFICER','ADMINISTRATOR']))
            return redirect()->to('/');

        helper('number');
        $branchModel = new BranchModel;
        $branchList = $branchModel->orderBy('code', 'ASC')->findAll();
        $lecturerOptions = [];
        $lecturerModel = new LecturerModel;
        foreach ($branchList as $branch)
        {
            $lecturerOptions[] = [
                'label' => $branch['name_tha'],
                'options' => $lecturerModel->where('branch_id', $branch['branch_id'])->findAll()
            ];
        }

        $facultyList = (new FacultyModel)->orderBy('name_tha', 'asc')->findAll();
        $branchOptions = [];
        foreach ($facultyList as $faculty)
        {
            $branchOptions[] = [
                'label' => $faculty['name_tha'],
                'options' => $branchModel->where('faculty_id', $faculty['faculty_id'])->orderBy('code', 'ASC')->findAll()
            ];
        }
        return $this->render('Manage/Courses/' . __FUNCTION__, [
            'courseCategoryList' => (new CourseCategoriesModel)->orderBy('title', 'ASC')->findAll(),
            'branchOptions' => $branchOptions,
            'lecturerOptions' => $lecturerOptions,
            'fileSchedule' => CoursesViewModel::$fileSchedule,
            'fileImage' => CoursesViewModel::$fileImage
        ]);
    }

    public function Enroll($id = null)
    {
        if (!session()->get('LOGGED_IN'))
            return redirect()->to('/');
        if (!in_array($this->userLogged['user_level'], ['OFFICER','ADMINISTRATOR']))
            return redirect()->to('/');
        if (empty($id))
            return redirect()->to('/');
        $courseBatch = (new CourseBatchModel)->find($id);
        if (empty($courseBatch))
            return redirect()->to('/');
        $course = (new CoursesModel)->find($courseBatch['course_id']);
        if (empty($course))
            return redirect()->to('/');

        return $this->render('Manage/Courses/' . __FUNCTION__, [
            'course' => $course,
            'courseBatch' => $courseBatch,
            'provinceList' => (new ProvinceModel)->orderBy('name', 'ASC')->findAll(),
            'dateExtension' => new Date,
        ]);
    }

    public function EnrollReport($id = null)
    {
        if (!session()->get('LOGGED_IN'))
            return redirect()->to('/');
        if (!in_array($this->userLogged['user_level'], ['OFFICER','ADMINISTRATOR']))
            return redirect()->to('/');
        if (empty($id))
            return redirect()->to('/');

        $paymentModel = (new PaymentModel)->select('payment.*,'
            .'enroll.fullname_tha as enroll_fullname_tha')
            ->join('enroll', 'enroll.enroll_id = payment.enroll_id', 'left')
            ->join('course_batch', 'course_batch.course_batch_id = enroll.course_batch_id', 'left')
            ->where('enroll.course_batch_id', $id);
        if ($this->userLogged['user_level'] === 'OFFICER')
            $paymentModel->where('courses.creator', $this->userLogged['user_id']);
        $paymentList = $paymentModel->findAll();

        $course = (new CoursesModel)->select('courses.*,'
            .'course_batch.start_classroom as course_batch_start_classroom,'
            .'course_batch.end_classroom as course_batch_end_classroom')
            ->join('course_batch', 'course_batch.course_id = courses.course_id', 'left')
            ->where('course_batch.course_batch_id', $id)
            ->first();
        if (empty($course))
            return redirect()->to('/');

        return $this->render('Manage/Courses/' . __FUNCTION__, [
            'course' => $course,
            'paymentList' => $paymentList,
            'dateExtension' => new Date,
        ], false, false);
    }

    public function Categories()
    {
        if (!session()->get('LOGGED_IN'))
            return redirect()->to('/');
        if ($this->userLogged['user_level'] !== 'ADMINISTRATOR')
            return redirect()->to('/');

        return $this->render('Manage/Courses/' . __FUNCTION__);
    }
}
