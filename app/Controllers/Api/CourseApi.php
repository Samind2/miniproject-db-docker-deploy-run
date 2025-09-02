<?php
/* Shaoransoft Developer */
namespace App\Controllers\Api;

use CodeIgniter\API\ResponseTrait;

use App\Models\CoursesModel;
use App\Models\CourseCategoriesModel;
use App\Models\CourseLecturerModel;
use App\Models\CourseBatchModel;
use App\Models\BranchModel;
use App\Models\LecturerModel;
use App\Models\EnrollModel;

use App\ViewModels\CoursesViewModel;

use App\Extension\Date;

class CourseApi extends ApiController
{
    use ResponseTrait;

    const authorKey = '6igZlciqxqYfjjDzPj3CLOLtfMZSohE2jmB66hBILQOaZ9HqmShplOySDry6noRI';

    public function GetDT()
    {
        if (!session()->get('LOGGED_IN'))
            return $this->unauthorized();
        if (!in_array($this->userLogged['user_level'], ['OFFICER','ADMINISTRATOR']))
            return $this->unauthorized();

        $req = $this->request->getPost();
        $searchValue = $req['search']['value'] ?? '';
        $start = $req['start'] ?? 0;
        $length = $req['length'] ?? 0;
        if ($length == -1) $start = $length = 0;
        $orderColumn = $req['order'][0]['column'] ?? 0;
        $orderDir = $req['order'][0]['dir'] ?? 'asc';

        $columns = [
            'row_num',
            'courses.title',
            'courses.display',
            'courses.class_hours',
            'course_categories.title',
            'branch.name_tha',
            'courses.regis_fee',
            'courses.views_count',
            'users.fullname_tha',
            null
        ];

        $courseModel = (new CoursesModel)->select('courses.*,'
            .'course_categories.title as course_category_title,'
            .'branch.name_tha as branch_name_tha,'
            .'users.fullname_tha as user_fullname_tha,'
            .'row_number() over (order by courses.modified desc) row_num')
            ->join('course_categories', 'course_categories.course_category_id = courses.course_category_id', 'left')
            ->join('branch', 'branch.branch_id = courses.branch_id', 'left')
            ->join('users', 'users.user_id = courses.creator', 'left');
        if ($this->userLogged['user_level'] === 'OFFICER')
            $courseModel->where('creator', $this->userLogged['user_id']);
        $courseModel->groupStart()
                ->like('courses.title', $searchValue)
                ->orLike('course_categories.title', $searchValue)
                ->orLike('branch.name_tha', $searchValue)
            ->groupEnd()
            ->orderBy($columns[array_key_exists($orderColumn, $columns) ? $orderColumn : 0], $orderDir);
        $courseList = $courseModel->findAll($length, $start);
        if ($this->userLogged['user_level'] === 'OFFICER')
            $courseModel->where('creator', $this->userLogged['user_id']);
        $numRows = $courseModel->countAllResults();
        $res = [
            'draw' => $req['draw'] ?? 1,
            'recordsTotal' => $numRows,
            'recordsFiltered' => $numRows
        ];
        foreach ($courseList as $course)
        {
            $res['data'][] = [
                $course['row_num'],
                $course['title'],
                $course['display'],
                number_format($course['class_hours'], 0),
                $course['course_category_title'],
                $course['branch_name_tha'],
                number_format($course['regis_fee'], 0),
                number_format($course['views_count'], 0),
                $course['user_fullname_tha'],
                null,
                $course['course_id'],
                $course['is_onsite']
            ];
        }

        return $this->respond($res);
    }

    public function Get($id = null)
    {
        if (!session()->get('LOGGED_IN'))
            return $this->unauthorized();
        if (!in_array($this->userLogged['user_level'], ['OFFICER','ADMINISTRATOR']))
            return $this->unauthorized();
        if (empty($id))
            return $this->respondError('ไม่พบไอดีอ้างอิง');
        try
        {
            $course = (new CoursesModel)->find($id);
            if (!empty($course) && $this->userLogged['user_level'] === 'OFFICER' && $this->userLogged['user_id'] !== $course['creator'])
                return $this->unauthorized();
            $course['lecturers'] = (new CourseLecturerModel)->where('course_id', $course['course_id'])->findAll();
            return $this->respondSuccess('success', $course);
        }
        catch (\Exception $e)
        {
            return $this->respondError($e->getMessage());
        }
    }

    public function GetCalendar()
    {
        header('Content-type: application/json');
        try
        {
            $courseList = (new CoursesModel)->select('courses.course_id as id,'
                .'courses.title as title,'
                .'course_batch.start_classroom as start,'
                .'date_add(course_batch.end_classroom, interval 1 day) as end')
                ->join('course_batch', 'course_batch.course_id = courses.course_id', 'left')
                ->where([
                    'unix_timestamp(course_batch.start_classroom) >=' => strtotime($this->request->getVar('start')),
                    'unix_timestamp(course_batch.start_classroom) <=' => strtotime($this->request->getVar('end')),
                    'courses.display' => 'PUBLIC',
                    'course_batch.is_active' => 'TRUE'
                ])
                ->findAll();
            echo json_encode($courseList);
        }
        catch (\Exception $e)
        {
            printf("Error: %s\n", $e->getMessage());
        }
    }

    public function GetListByThirdParty()
    {
        $authorization = $this->request->getServer('HTTP_AUTHORIZATION');
        if (empty($authorization))
            return $this->unauthorized();
        $token = '';
        if (preg_match('/Bearer\s(\S+)/', $authorization, $matches))
            $token = $matches[1];
        if (empty($token) || $token !== $this::authorKey)
            return $this->unauthorized();

        $courseList = (new CoursesModel)->select('courses.*,'
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
            ->findAll();
        $result = [];
        foreach ($courseList as $course)
        {
            $result[] = [
                'id' => $course['course_id'],
                'title' => $course['title'],
                'image' => base_url() . '/' . $course['image'],
                'location' => $course['location'],
                'regis_fee' => $course['regis_fee'],
                'is_onsite' => $course['is_onsite'],
                'class_hours' => $course['class_hours'],
                'views_count' => $course['views_count'],
                'course_category' => $course['course_category_title'],
                'course_branch' => $course['branch_name_tha'],
                'start_classroom' => $course['course_batch_start_classroom'],
                'end_classroom' => $course['course_batch_end_classroom'],
                'url' => base_url() . '/course/' . $course['course_id'],
            ];
        }
        return $this->respondSuccess('success', $result);
    }

    public function Create()
    {
        if (!session()->get('LOGGED_IN'))
            return $this->unauthorized();
        if (!in_array($this->userLogged['user_level'], ['OFFICER','ADMINISTRATOR']))
            return $this->unauthorized();

        $form = $this->request->getPost();
        if (empty($form))
            return $this->respondError('กรุณากรอกแบบฟอร์ม');
        $courseCategory = $form['courseCategory'];
        $branch = $form['branch'];
        $title = $form['title'];
        $regisFee = $form['regisFee'];
        $locatType = $form['locatType'];
        $onlineUrl = $form['onlineUrl'];
        $onlineRequirement = $form['onlineRequirement'];
        $location = $form['location'];
        $classHours = $form['classHours'];
        $lecturers = $form['lecturers'];
        $objective = $form['objective'];
        $target = $form['target'];
        $content = $form['content'];
        $evaluation = $form['evaluation'];
        $expectedResults = $form['expectedResults'];
        $contact = $form['contact'];
        $schedule = $this->request->getFile('schedule');
        $image = $this->request->getFile('image');
        $display = $form['display'];

        $fileSchedule = CoursesViewModel::$fileSchedule;
        $fileImage = CoursesViewModel::$fileImage;

        $err = [];
        if (empty($courseCategory))
            $err[] = 'กรุณาเลือกหมวดหลักสูตร';
        if (empty((new CourseCategoriesModel)->find($courseCategory)))
            $err[] = 'ไม่มีหมวดหลักสูตรที่เลือกในระบบ';
        if (empty($branch))
            $err[] = 'กรุณาเลือกสาขาวิชา';
        if (empty((new BranchModel)->find($branch)))
            $err[] = 'รหัสสาขาวิชาดังกล่าวมีในระบบแล้ว';
        if (empty($title))
            $err[] = 'กรุณากรอกชื่อหมวดหลักสูตร';
        if (!is_numeric($regisFee))
            $err[] = 'กรอกค่าสมัคร/ท่านเป็นตัวเลขเท่านั้น';
        if (0 > $regisFee)
            $err[] = 'ค่าสมัคร/ท่านต้องไม่น้อยกว่า 0 บาท (THB.)';
        if (empty($locatType))
            $err[] = 'กรุณาเลือกประเภทสถานที่จัดอบรม';
        if ($locatType == 'ONSITE' && empty($location))
            $err[] = 'กรุณากรอกสถานที่จัดอบรม';
        if (empty($classHours))
            $err[] = 'กรุณากรอกจำนวนชั่วโมงเรียน';
        if (!is_numeric($classHours))
            $err[] = 'กรอกจำนวนชั่วโมงเรียนเป็นตัวเลขเท่านั้น';
        if (1 > $classHours)
            $err[] = 'จำนวนชั่วโมงเรียนต้องไม่น้อยกว่า 1 ชั่วโมง';
        if (empty($lecturers))
            $err[] = 'กรุณาเลือกวิทยากร';
        if (empty($objective))
            $err[] = 'กรุณากรอกวัตถุประสงค์';
        if (empty($target))
            $err[] = 'กรุณากรอกกลุ่มเป้าหมาย';
        if (empty($content))
            $err[] = 'กรุณากรอกขอบข่ายเนื้อหา';
        if (empty($evaluation))
            $err[] = 'กรุณากรอกการวัดผลประเมินผล';
        if (empty($expectedResults))
            $err[] = 'กรุณากรอกผลที่คาดว่าจะได้รับ';
        if (empty($contact))
            $err[] = 'กรุณากรอกสอบถามเพิ่มเติม';
        if (!$schedule->isValid())
            $err[] = 'กรุณาอัปโหลดกำหนดการ';
        if (!$image->isValid())
            $err[] = 'กรุณาอัปโหลดรูปภาพ';
        if (empty($display))
            $err[] = 'กรุณาเลือกการเข้าถึงเนื้อหา';
        if (count($err) > 0)
            return $this->respondError(join('<br>', $err));
        $lecturerModel = new LecturerModel;
        foreach ($lecturers as $lecturer)
        {
            if (empty($lecturerModel->find($lecturer)))
                return $this->respondError('ไม่พบข้อมูลวิทยากร');
        }
        if (!$this->validate([
            'schedule' => [
                'label' => 'Schedule File',
                'rules' => 'uploaded[schedule]'
                    .'|mime_in[schedule,'.join(',', $fileSchedule['accept']).']'
                    .'|max_size[schedule,'.$fileSchedule['maxSize'].']'
            ]
        ])) return $this->respondError(join(',', $this->validator->getErrors()));
        if (!$this->validate([
            'image' => [
                'label' => 'Image File',
                'rules' => 'uploaded[image]'
                    .'|is_image[image]'
                    .'|mime_in[image,'.join(',', $fileImage['accept']).']'
                    .'|max_size[image,'.$fileImage['maxSize'].']'
            ]
        ])) return $this->respondError(join(',', $this->validator->getErrors()));
        $scheduleNewName = $schedule->getRandomName();
        $schedule->move($fileSchedule['path'], $scheduleNewName);
        $imageNewName = $image->getRandomName();
        $image->move($fileImage['path'], $imageNewName);
        $coursesModel = new CoursesModel;
        if ($coursesModel->insert([
            'course_category_id' => $courseCategory,
            'branch_id' => $branch,
            'title' => $title,
            'image' => $fileImage['path'].'/'.$imageNewName,
            'is_onsite' => $locatType == 'ONSITE' ? 'TRUE' : 'FALSE',
            'online_url' => $onlineUrl,
            'online_requirement' => $onlineRequirement,
            'location' => $location,
            'objective' => $objective,
            'target' => $target,
            'content' => $content,
            'evaluation' => $evaluation,
            'expected_results' => $expectedResults,
            'schedule' => $fileSchedule['path'].'/'.$scheduleNewName,
            'contact' => $contact,
            'regis_fee' => $regisFee,
            'class_hours' => $classHours,
            'display' => $display,
            'views_count' => 0,
            'created' => date('Y-m-d H:i:s'),
            'creator' => $this->userLogged['user_id']
        ]))
        {
            $latestId = $coursesModel->getInsertID();
            $courseLecturerModel = new CourseLecturerModel;
            foreach ($lecturers as $lecturer)
            {
                $courseLecturerModel->insert([
                    'course_id' => $latestId,
                    'lecturer_id' => $lecturer
                ]);
            }
            return $this->respondSuccess('เพิ่มข้อมูลเรียบร้อยแล้ว');
        }
        return $this->respondError('เกิดข้อผิดพลาดในการเพิ่มข้อมูล กรุณาลองใหม่อีกครั้ง');
    }

    public function Modify()
    {
        if (!session()->get('LOGGED_IN'))
            return $this->unauthorized();
        if (!in_array($this->userLogged['user_level'], ['OFFICER','ADMINISTRATOR']))
            return $this->unauthorized();

        $form = $this->request->getPost();
        if (empty($form))
            return $this->respondError('กรุณากรอกแบบฟอร์ม');
        $courseId = $form['courseId'];
        $courseCategory = $form['courseCategory'];
        $branch = $form['branch'];
        $title = $form['title'];
        $regisFee = $form['regisFee'];
        $locatType = $form['locatType'];
        $onlineUrl = $form['onlineUrl'];
        $onlineRequirement = $form['onlineRequirement'];
        $location = $form['location'];
        $classHours = $form['classHours'];
        $lecturers = $form['lecturers'];
        $objective = $form['objective'];
        $target = $form['target'];
        $content = $form['content'];
        $evaluation = $form['evaluation'];
        $expectedResults = $form['expectedResults'];
        $contact = $form['contact'];
        $schedule = $this->request->getFile('schedule');
        $image = $this->request->getFile('image');
        $display = $form['display'];

        $fileSchedule = CoursesViewModel::$fileSchedule;
        $fileImage = CoursesViewModel::$fileImage;
        $coursesModel = new CoursesModel;
        $course = $coursesModel->find($courseId);
        if (empty($course))
            return $this->respondError('ไม่พบข้อมูลหลักสูตรอบรม');
        if ($this->userLogged['user_level'] === 'OFFICER' && $this->userLogged['user_id'] !== $course['creator'])
            return $this->respondError('คุณไม่ใช่ผู้สร้างหลักสูตร '.$title.' ไม่มีสิทธิ์แก้ไขข้อมูล');
        $err = [];
        if (empty($courseCategory))
            $err[] = 'กรุณาเลือกหมวดหลักสูตร';
        if (empty((new CourseCategoriesModel)->find($courseCategory)))
            $err[] = 'ไม่มีหมวดหลักสูตรที่เลือกในระบบ';
        if (empty($branch))
            $err[] = 'กรุณาเลือกสาขาวิชา';
        if (empty((new BranchModel)->find($branch)))
            $err[] = 'รหัสสาขาวิชาดังกล่าวมีในระบบแล้ว';
        if (empty($title))
            $err[] = 'กรุณากรอกชื่อหมวดหลักสูตร';
        if (!is_numeric($regisFee))
            $err[] = 'กรอกค่าสมัคร/ท่านเป็นตัวเลขเท่านั้น';
        if (0 > $regisFee)
            $err[] = 'ค่าสมัคร/ท่านต้องไม่น้อยกว่า 0 บาท (THB.)';
        if (empty($locatType))
            $err[] = 'กรุณาเลือกประเภทสถานที่จัดอบรม';
        if (empty($location))
            $err[] = 'กรุณากรอกสถานที่จัดอบรม';
        if (empty($classHours))
            $err[] = 'กรุณากรอกจำนวนชั่วโมงเรียน';
        if (!is_numeric($classHours))
            $err[] = 'กรอกจำนวนชั่วโมงเรียนเป็นตัวเลขเท่านั้น';
        if (1 > $classHours)
            $err[] = 'จำนวนชั่วโมงเรียนต้องไม่น้อยกว่า 1 ชั่วโมง';
        if (empty($lecturers))
            $err[] = 'กรุณาเลือกวิทยากร';
        if (empty($objective))
            $err[] = 'กรุณากรอกวัตถุประสงค์';
        if (empty($target))
            $err[] = 'กรุณากรอกกลุ่มเป้าหมาย';
        if (empty($content))
            $err[] = 'กรุณากรอกขอบข่ายเนื้อหา';
        if (empty($evaluation))
            $err[] = 'กรุณากรอกการวัดผลประเมินผล';
        if (empty($expectedResults))
            $err[] = 'กรุณากรอกผลที่คาดว่าจะได้รับ';
        if (empty($contact))
            $err[] = 'กรุณากรอกสอบถามเพิ่มเติม';
        if (empty($display))
            $err[] = 'กรุณาเลือกการเข้าถึงเนื้อหา';
        if (count($err) > 0)
            return $this->respondError(join('<br>', $err));
        $lecturerModel = new LecturerModel;
        foreach ($lecturers as $lecturer)
        {
            if (empty($lecturerModel->find($lecturer)))
                return $this->respondError('ไม่พบข้อมูลวิทยากร');
        }
        if ($schedule->isValid() && !$this->validate([
            'schedule' => [
                'label' => 'Schedule File',
                'rules' => 'uploaded[schedule]'
                    .'|mime_in[schedule,'.join(',', $fileSchedule['accept']).']'
                    .'|max_size[schedule,'.$fileSchedule['maxSize'].']'
            ]
        ])) return $this->respondError(join(',', $this->validator->getErrors()));
        if ($image->isValid() && !$this->validate([
            'image' => [
                'label' => 'Image File',
                'rules' => 'uploaded[image]'
                    .'|is_image[image]'
                    .'|mime_in[image,'.join(',', $fileImage['accept']).']'
                    .'|max_size[image,'.$fileImage['maxSize'].']'
            ]
        ])) return $this->respondError(join(',', $this->validator->getErrors()));
        $updateData = [
            'course_category_id' => $courseCategory,
            'branch_id' => $branch,
            'title' => $title,
            'is_onsite' => $locatType == 'ONSITE' ? 'TRUE' : 'FALSE',
            'online_url' => $onlineUrl,
            'online_requirement' => $onlineRequirement,
            'location' => $location,
            'objective' => $objective,
            'target' => $target,
            'content' => $content,
            'evaluation' => $evaluation,
            'expected_results' => $expectedResults,
            'contact' => $contact,
            'regis_fee' => $regisFee,
            'class_hours' => $classHours,
            'display' => $display
        ];
        if ($schedule->isValid())
        {
            if ($course['schedule'] !== '' && file_exists($course['schedule']))
                unlink($course['schedule']);
            $scheduleNewName = $schedule->getRandomName();
            $schedule->move($fileSchedule['path'], $scheduleNewName);
            $updateData['schedule'] = $fileSchedule['path'].'/'.$scheduleNewName;
        }
        if ($image->isValid())
        {
            if ($course['image'] !== '' && file_exists($course['image']))
                unlink($course['image']);
            $imageNewName = $image->getRandomName();
            $image->move($fileImage['path'], $imageNewName);
            $updateData['image'] = $fileImage['path'].'/'.$imageNewName;
        }
        if ($coursesModel->update($courseId, $updateData))
        {
            $courseLecturerModel = new CourseLecturerModel;
            if ($courseLecturerModel->where('course_id', $courseId)->countAllResults() > 0)
                $courseLecturerModel->where('course_id', $courseId)->delete();
            foreach ($lecturers as $lecturer)
            {
                $courseLecturerModel->insert([
                    'course_id' => $courseId,
                    'lecturer_id' => $lecturer
                ]);
            }
            return $this->respondSuccess('บันทึกการเปลี่ยนแปลงข้อมูลเรียบร้อยแล้ว');
        }
        return $this->respondError('เกิดข้อผิดพลาดในการบันทึกข้อมูล กรุณาลองใหม่อีกครั้ง');
    }

    public function Delete($id = null)
    {
        if (!session()->get('LOGGED_IN'))
            return $this->unauthorized();
        if (!in_array($this->userLogged['user_level'], ['OFFICER','ADMINISTRATOR']))
            return $this->unauthorized();
        if (empty($id))
            return $this->respondError('ไม่พบไอดีอ้างอิง');

        $coursesModel = new CoursesModel;
        $course = $coursesModel->find($id);
        if (empty($course))
            return $this->respondError('ไม่พบข้อมูลหลักสูตรอบรม');
        if ($this->userLogged['user_level'] === 'OFFICER' && $this->userLogged['user_id'] !== $course['creator'])
            return $this->respondError('คุณไม่ใช่ผู้สร้างหลักสูตร '.$course['title'].' ไม่มีสิทธิ์ลบข้อมูล');
        if ($course['schedule'] !== '' && file_exists($course['schedule']))
            unlink($course['schedule']);
        if ($course['image'] !== '' && file_exists($course['image']))
            unlink($course['image']);
        (new CourseBatchModel)->where('course_id', $id)->delete();
        (new CourseLecturerModel)->where('course_id', $id)->delete();
        (new EnrollModel)->where('course_id', $id)->delete();
        if ($coursesModel->delete($id))
            return $this->respondSuccess('ลบข้อมูลสำเร็จแล้ว');
        return $this->respondError('ไม่สามารถลบข้อมูลได้ กรุณาลองใหม่อีกครั้ง');
    }

    public function GetCategoryDT()
    {
        if (!session()->get('LOGGED_IN'))
            return $this->unauthorized();
        if ($this->userLogged['user_level'] != 'ADMINISTRATOR')
            return $this->unauthorized();

        $req = $this->request->getPost();
        $searchValue = $req['search']['value'] ?? '';
        $start = $req['start'] ?? 0;
        $length = $req['length'] ?? 0;
        if ($length == -1) $start = $length = 0;
        $orderColumn = $req['order'][0]['column'] ?? 0;
        $orderDir = $req['order'][0]['dir'] ?? 'asc';

        $columns = [
            'row_num',
            'title',
            null
        ];

        $courseCategoriesModel = (new CourseCategoriesModel)->select('course_categories.*,'
            .'row_number() over (order by course_categories.title) row_num')
            ->Like('title', $searchValue)
            ->orderBy($columns[array_key_exists($orderColumn, $columns) ? $orderColumn : 0], $orderDir);
        $courseCategoryList = $courseCategoriesModel->findAll($length, $start);
        $numRows = $courseCategoriesModel->countAllResults();
        $res = [
            'draw' => $req['draw'] ?? 1,
            'recordsTotal' => $numRows,
            'recordsFiltered' => $numRows
        ];
        foreach ($courseCategoryList as $courseCategory)
        {
            $res['data'][] = [
                $courseCategory['row_num'],
                $courseCategory['title'],
                null,
                $courseCategory['course_category_id'],
            ];
        }

        return $this->respond($res);
    }

    public function GetCategory($id = null)
    {
        if (!session()->get('LOGGED_IN'))
            return $this->unauthorized();
        if ($this->userLogged['user_level'] != 'ADMINISTRATOR')
            return $this->unauthorized();
        if (empty($id))
            return $this->respondError('ไม่พบไอดีอ้างอิง');
        try
        {
            $courseCategory = (new CourseCategoriesModel)->find($id);
            return $this->respondSuccess('success', $courseCategory);
        }
        catch (\Exception $e)
        {
            return $this->respondError($e->getMessage());
        }
    }

    public function CreateCategory()
    {
        if (!session()->get('LOGGED_IN'))
            return $this->unauthorized();
        if ($this->userLogged['user_level'] != 'ADMINISTRATOR')
            return $this->unauthorized();

        $form = $this->request->getPost();
        if (empty($form))
            return $this->respondError('กรุณากรอกแบบฟอร์ม');
        $title = $form['title'];

        $courseCategoriesModel = new CourseCategoriesModel;
        $err = [];
        if (empty($title))
            $err[] = 'กรุณากรอกชื่อหมวดหลักสูตร';
        if ($courseCategoriesModel->where('title', $title)->countAllResults() > 0)
            $err[] = 'ชื่อหมวดหลักสูตรดังกล่าวมีในระบบแล้ว';
        if (count($err) > 0)
            return $this->respondError(join('<br>', $err));
        if ($courseCategoriesModel->insert(['title' => $title]))
            return $this->respondSuccess('เพิ่มข้อมูลเรียบร้อยแล้ว');
        return $this->respondError('เกิดข้อผิดพลาดในการเพิ่มข้อมูล กรุณาลองใหม่อีกครั้ง');
    }

    public function ModifyCategory()
    {
        if (!session()->get('LOGGED_IN'))
            return $this->unauthorized();
        if ($this->userLogged['user_level'] != 'ADMINISTRATOR')
            return $this->unauthorized();

        $form = $this->request->getPost();
        if (empty($form))
            return $this->respondError('กรุณากรอกแบบฟอร์ม');
        $courseCategoryId = $form['courseCategoryId'];
        $title = $form['title'];

        $courseCategoriesModel = new CourseCategoriesModel;
        $courseCategory = $courseCategoriesModel->find($courseCategoryId);
        if (empty($courseCategory))
            return $this->respondError('ไม่พบข้อมูลหมวดหลักสูตร');
        $err = [];
        if (empty($title))
            $err[] = 'กรุณากรอกชื่อหมวดหลักสูตร';
        if ($courseCategoriesModel->where(['course_category_Id !=' => $courseCategoryId, 'title' => $title])->countAllResults() > 0)
            $err[] = 'ชื่อหมวดหลักสูตรดังกล่าวมีในระบบแล้ว';
        if (count($err) > 0)
            return $this->respondError(join('<br>', $err));
        if ($courseCategoriesModel->update($courseCategoryId, ['title' => $title]))
            return $this->respondSuccess('บันทึกการเปลี่ยนแปลงข้อมูลเรียบร้อยแล้ว');
        return $this->respondError('เกิดข้อผิดพลาดในการบันทึกข้อมูล กรุณาลองใหม่อีกครั้ง');
    }

    public function DeleteCategory($id = null)
    {
        if (!session()->get('LOGGED_IN'))
            return $this->unauthorized();
        if ($this->userLogged['user_level'] != 'ADMINISTRATOR')
            return $this->unauthorized();
        if (empty($id))
            return $this->respondError('ไม่พบไอดีอ้างอิง');

        $courseCategoriesModel = new CourseCategoriesModel;
        $courseCategory = $courseCategoriesModel->find($id);
        if (empty($courseCategory))
            return $this->respondError('ไม่พบข้อมูลหมวดหลักสูตร');

        $coursesModel = new CoursesModel;
        $courseLecturerModel = new CourseLecturerModel;
        $enrollModel = new EnrollModel;
        $courseList = $coursesModel->where('course_category_id', $id)->findAll();
        foreach ($courseList as $course)
        {
            if ($course['schedule'] !== '' && file_exists($course['schedule']))
                unlink($course['schedule']);
            if ($course['image'] !== '' && file_exists($course['image']))
                unlink($course['image']);
            $coursesModel->delete($course['course_id']);
            $courseLecturerModel->where('course_id', $course['course_id'])->delete();
            $enrollModel->where('course_id', $course['course_id'])->delete();
        }
        if ($courseCategoriesModel->delete($id))
            return $this->respondSuccess('ลบข้อมูลสำเร็จแล้ว');
        return $this->respondError('ไม่สามารถลบข้อมูลได้ กรุณาลองใหม่อีกครั้ง');
    }

    public function GetBatchDT($id = null)
    {
        if (!session()->get('LOGGED_IN'))
            return $this->unauthorized();
        if (!in_array($this->userLogged['user_level'], ['OFFICER','ADMINISTRATOR']))
            return $this->unauthorized();

        $req = $this->request->getPost();
        $searchValue = $req['search']['value'] ?? '';
        $start = $req['start'] ?? 0;
        $length = $req['length'] ?? 0;
        if ($length == -1) $start = $length = 0;
        $orderColumn = $req['order'][0]['column'] ?? 0;
        $orderDir = $req['order'][0]['dir'] ?? 'asc';

        $columns = [
            'row_num',
            'course_batch.is_active',
            'course_batch.start_enrollment',
            'course_batch.end_enrollment',
            'course_batch.start_classroom',
            'course_batch.end_classroom',
            'course_batch.end_payment',
            'course_batch.max_enroll',
            'enroll_count',
            null
        ];

        $courseBatchModel = (new CourseBatchModel)->select('course_batch.*,'
            .'(select count(*) from enroll where enroll.course_id = course_batch.course_id and enroll.course_batch_id = course_batch.course_batch_id) as enroll_count,'
            .'row_number() over (order by course_batch.modified) row_num')
            ->where('course_batch.course_id', $id)
            ->orderBy($columns[array_key_exists($orderColumn, $columns) ? $orderColumn : 0], $orderDir);
        $courseBatchList = $courseBatchModel->findAll($length, $start);
        $numRows = $courseBatchModel->where('course_batch.course_id', $id)
            ->countAllResults();
        $res = [
            'draw' => $req['draw'] ?? 1,
            'recordsTotal' => $numRows,
            'recordsFiltered' => $numRows
        ];
        foreach ($courseBatchList as $courseBatch)
        {
            $res['data'][] = [
                $courseBatch['row_num'],
                $courseBatch['is_active'],
                Date::thai_format('d/m/Y', $courseBatch['start_enrollment']),
                Date::thai_format('d/m/Y', $courseBatch['end_enrollment']).'<br><small>('.Date::date_between($courseBatch['start_enrollment'], $courseBatch['end_enrollment'], true).' วัน)</small>',
                Date::thai_format('d/m/Y', $courseBatch['start_classroom']),
                Date::thai_format('d/m/Y', $courseBatch['end_classroom']).'<br><small>('.Date::date_between($courseBatch['start_classroom'], $courseBatch['end_classroom'], true).' วัน)</small>',
                Date::thai_format('d/m/Y', $courseBatch['end_payment']),
                number_format($courseBatch['max_enroll'], 0).'<br><small>(ขั้นต่ำ: '.number_format(round(($courseBatch['max_enroll'] / 100) * $courseBatch['min_enroll']), 0).')</small>',
                number_format($courseBatch['enroll_count'], 0),
                null,
                $courseBatch['course_batch_id']
            ];
        }

        return $this->respond($res);
    }

    public function GetBatch($id = null)
    {
        if (!session()->get('LOGGED_IN'))
            return $this->unauthorized();
        if (!in_array($this->userLogged['user_level'], ['OFFICER','ADMINISTRATOR']))
            return $this->unauthorized();
        if (empty($id))
            return $this->respondError('ไม่พบไอดีอ้างอิง');
        try
        {
            $courseBatch = (new CourseBatchModel)->find($id);
            return $this->respondSuccess('success', $courseBatch);
        }
        catch (\Exception $e)
        {
            return $this->respondError($e->getMessage());
        }
    }

    public function CreateBatch()
    {
        if (!session()->get('LOGGED_IN'))
            return $this->unauthorized();
        if (!in_array($this->userLogged['user_level'], ['OFFICER','ADMINISTRATOR']))
            return $this->unauthorized();

        $form = $this->request->getPost();
        if (empty($form))
            return $this->respondError('กรุณากรอกแบบฟอร์ม');
        $courseId = $form['course'];
        $startEnrollment = $form['startEnrollment'];
        $endEnrollment = $form['endEnrollment'];
        $startClassroom = $form['startClassroom'];
        $endClassroom = $form['endClassroom'];
        $endPayment = $form['endPayment'];
        $maxEnroll = $form['maxEnroll'];
        $minEnroll = $form['minEnroll'];
        $isActive = $form['isActive'] ?? 'FALSE';

        if ((new CoursesModel)->where('course_id', $courseId)->countAllResults() == 0)
            return $this->respondError('ไม่พบข้อมูลหลักสูตร');
        $err = [];
        if (empty($startEnrollment))
            $err[] = 'กรุณากรอกวันที่เริ่มลงทะเบียน';
        if (empty($endEnrollment))
            $err[] = 'กรุณากรอกวันที่สิ้นสุดลงทะเบียน';
        if (date('Y-m-d', strtotime($startEnrollment)) > date('Y-m-d', strtotime($endEnrollment)))
            $err[] = 'วันที่เริ่มลงทะเบียนต้องไม่เกินกว่าวันที่สิ้นสุดลงทะเบียน';
        if (empty($startClassroom))
            $err[] = 'กรุณากรอกวันที่เริ่มการเรียน';
        if (empty($endClassroom))
            $err[] = 'กรุณากรอกวันที่สิ้นสุดการเรียน';
        if (date('Y-m-d', strtotime($startClassroom)) > date('Y-m-d', strtotime($endClassroom)))
            $err[] = 'วันที่เริ่มเรียนต้องไม่เกินกว่าวันที่สิ้นสุดการเรียน';
        if (date('Y-m-d', strtotime($endEnrollment)) >= date('Y-m-d', strtotime($startClassroom)))
            $err[] = 'ช่วงเวลาการลงทะเบียนต้องไม่เท่ากับหรือเกินกว่าวันที่เริ่มการเรียน';
        if (empty($endPayment))
            $err[] = 'กรุณากรอกวันที่สิ้นสุดการชำระเงิน';
        if (date('Y-m-d', strtotime($endPayment)) >= date('Y-m-d', strtotime($startClassroom)))
            $err[] = 'วันที่สิ้นสุดการชำระเงินต้องไม่เกินกว่าวันที่เริ่มการเรียน';
        if (date('Y-m-d', strtotime($endEnrollment)) >= date('Y-m-d', strtotime($endPayment)))
            $err[] = 'ช่วงเวลาการลงทะเบียนต้องไม่เกินกว่าวันที่สิ้นสุดการชำระเงิน';
        if (0 > $maxEnroll)
            $err[] = 'จำนวนผู้เรียนต้องไม่น้อยกว่า 0';
        if (0 > $minEnroll)
            $err[] = 'จำนวนผู้สมัครขั้นต่ำต้องไม่น้อยกว่า 0%';
        if (count($err) > 0)
            return $this->respondError(join('<br>', $err));
        if ((new CourseBatchModel)->insert([
            'course_id' => $courseId,
            'min_enroll' => $minEnroll,
            'max_enroll' => $maxEnroll,
            'start_enrollment' => $startEnrollment,
            'end_enrollment' => $endEnrollment,
            'start_classroom' => $startClassroom,
            'end_classroom' => $endClassroom,
            'end_payment' => $endPayment,
            'is_active' => $isActive,
            'created' => date('Y-m-d H:i:s'),
            'creator' => $this->userLogged['user_id']
        ])) return $this->respondSuccess('เพิ่มข้อมูลเรียบร้อยแล้ว');
        return $this->respondError('เกิดข้อผิดพลาดในการเพิ่มข้อมูล กรุณาลองใหม่อีกครั้ง');
    }

    public function ModifyBatch()
    {
        if (!session()->get('LOGGED_IN'))
            return $this->unauthorized();
        if (!in_array($this->userLogged['user_level'], ['OFFICER','ADMINISTRATOR']))
            return $this->unauthorized();

        $form = $this->request->getPost();
        if (empty($form))
            return $this->respondError('กรุณากรอกแบบฟอร์ม');
        $batchId = $form['batchId'];
        $startEnrollment = $form['startEnrollment'];
        $endEnrollment = $form['endEnrollment'];
        $startClassroom = $form['startClassroom'];
        $endClassroom = $form['endClassroom'];
        $endPayment = $form['endPayment'];
        $maxEnroll = $form['maxEnroll'];
        $minEnroll = $form['minEnroll'];
        $isActive = $form['isActive'] ?? 'FALSE';

        $courseBatchModel = new CourseBatchModel;
        if ($courseBatchModel->where('course_batch_id', $batchId)->countAllResults() == 0)
            return $this->respondError('ไม่พบข้อมูลรอบหลักสูตรอบรม');
        $err = [];
        if (empty($startEnrollment))
            $err[] = 'กรุณากรอกวันที่เริ่มลงทะเบียน';
        if (empty($endEnrollment))
            $err[] = 'กรุณากรอกวันที่สิ้นสุดลงทะเบียน';
        if (date('Y-m-d', strtotime($startEnrollment)) > date('Y-m-d', strtotime($endEnrollment)))
            $err[] = 'วันที่เริ่มลงทะเบียนต้องไม่เกินกว่าวันที่สิ้นสุดลงทะเบียน';
        if (empty($startClassroom))
            $err[] = 'กรุณากรอกวันที่เริ่มการเรียน';
        if (empty($endClassroom))
            $err[] = 'กรุณากรอกวันที่สิ้นสุดการเรียน';
        if (date('Y-m-d', strtotime($startClassroom)) > date('Y-m-d', strtotime($endClassroom)))
            $err[] = 'วันที่เริ่มเรียนต้องไม่เกินกว่าวันที่สิ้นสุดการเรียน';
        if (date('Y-m-d', strtotime($endEnrollment)) >= date('Y-m-d', strtotime($startClassroom)))
            $err[] = 'ช่วงเวลาการลงทะเบียนต้องไม่เท่ากับหรือเกินกว่าวันที่เริ่มการเรียน';
        if (empty($endPayment))
            $err[] = 'กรุณากรอกวันที่สิ้นสุดการชำระเงิน';
        if (date('Y-m-d', strtotime($endPayment)) >= date('Y-m-d', strtotime($startClassroom)))
            $err[] = 'วันที่สิ้นสุดการชำระเงินต้องไม่เกินกว่าวันที่เริ่มการเรียน';
        if (date('Y-m-d', strtotime($endEnrollment)) >= date('Y-m-d', strtotime($endPayment)))
            $err[] = 'ช่วงเวลาการลงทะเบียนต้องไม่เกินกว่าวันที่สิ้นสุดการชำระเงิน';
        if (0 > $maxEnroll)
            $err[] = 'จำนวนผู้เรียนต้องไม่น้อยกว่า 0';
        if (0 > $minEnroll)
            $err[] = 'จำนวนผู้สมัครขั้นต่ำต้องไม่น้อยกว่า 0%';
        if (count($err) > 0)
            return $this->respondError(join('<br>', $err));
        if ($courseBatchModel->update($batchId, [
            'min_enroll' => $minEnroll,
            'max_enroll' => $maxEnroll,
            'start_enrollment' => $startEnrollment,
            'end_enrollment' => $endEnrollment,
            'start_classroom' => $startClassroom,
            'end_classroom' => $endClassroom,
            'end_payment' => $endPayment,
            'is_active' => $isActive
        ])) return $this->respondSuccess('แก้ไขข้อมูลเรียบร้อยแล้ว');
        return $this->respondError('เกิดข้อผิดพลาดในการแก้ไขข้อมูล กรุณาลองใหม่อีกครั้ง');
    }

    public function DeleteBatch($id = null)
    {
        if (!session()->get('LOGGED_IN'))
            return $this->unauthorized();
        if (!in_array($this->userLogged['user_level'], ['OFFICER','ADMINISTRATOR']))
            return $this->unauthorized();
        if (empty($id))
            return $this->respondError('ไม่พบไอดีอ้างอิง');

        $courseBatchModel = new CourseBatchModel;
        $courseBatch = $courseBatchModel->find($id);
        if (empty($courseBatch))
            return $this->respondError('ไม่พบข้อมูลรอบหลักสูตรอบรม');
        (new EnrollModel)->where('course_batch_id', $id)->delete();
        if ($courseBatchModel->delete($id))
            return $this->respondSuccess('ลบข้อมูลสำเร็จแล้ว');
        return $this->respondError('ไม่สามารถลบข้อมูลได้ กรุณาลองใหม่อีกครั้ง');
    }
}