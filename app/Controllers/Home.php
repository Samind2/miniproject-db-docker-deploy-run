<?php
/* Shaoransoft Developer */
namespace App\Controllers;

use App\Models\CoursesModel;

use App\Extension\Date;

class Home extends BaseController
{
    public function Index()
    {
        $coursesModel = new CoursesModel;
        $courseList = $coursesModel->select('courses.*,'
            .'course_categories.title as course_category_title,'
            .'course_batch.start_classroom as course_batch_start_classroom,'
            .'course_batch.end_classroom as course_batch_end_classroom,'
            .'branch.name_tha as branch_name_tha')
            ->join('course_batch', 'course_batch.course_id = courses.course_id', 'right')
            ->join('course_categories', 'courses.course_category_id = course_categories.course_category_id', 'left')
            ->join('branch', 'courses.branch_id = branch.branch_id', 'left')
            ->where([
                'courses.display' => 'PUBLIC',
                'course_batch.is_active' => 'TRUE'
            ])
            ->orderBy('course_batch.start_enrollment', 'DESC')
            ->paginate(20);

        return $this->render('Home/' . __FUNCTION__, [
            'courseList' => $courseList,
            'coursePaging' => $coursesModel->pager->links(),
            'dateExtension' => new Date,
        ]);
    }
}
