<?php
/* Shaoransoft Developer */
namespace App\Controllers;

use App\Models\EnrollModel;

use App\Extension\Date;

class Enroll extends BaseController
{
    public function Index()
    {
        if (!session()->get('LOGGED_IN'))
            return redirect()->to('/');

        $enrollModel = new EnrollModel;
        $enrollList = $enrollModel->select('enroll.*,'
            .'courses.title as course_title,'
            .'courses.location as course_location,'
            .'course_batch.start_classroom as course_batch_start_classroom,'
            .'course_batch.end_classroom as course_batch_end_classroom')
            ->join('courses', 'courses.course_id = enroll.course_id', 'left')
            ->join('course_batch', 'course_batch.course_batch_id = enroll.course_batch_id', 'left')
            ->where(['enroll.user_id' => $this->userLogged['user_id']])
            ->orderBy('enroll.enrolled', 'desc')
            ->paginate(20);
        
        return $this->render('Enroll/' . __FUNCTION__, [
            'enrollList' => $enrollList,
            'enrollPaging' => $enrollModel->pager->links(),
            'dateExtension' => new Date
        ]);
    }
}
