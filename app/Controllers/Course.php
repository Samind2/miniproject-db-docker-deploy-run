<?php
/* Shaoransoft Developer */
namespace App\Controllers;

use App\Models\CoursesModel;
use App\Models\CourseCategoriesModel;
use App\Models\CourseLecturerModel;
use App\Models\CourseBatchModel;
use App\Models\ProvinceModel;
use App\Models\EnrollModel;

use App\Extension\Date;

class Course extends BaseController
{
    private function GetCourses($req = null)
    {
        $coursesModel = new CoursesModel;
        $coursesModel->select('courses.*,'
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
            ]);
        if (isset($req['k']) && !empty($req['k']))
        {
            $coursesModel->groupStart()
                    ->Like('courses.title', $req['k'])
                ->groupEnd();
        }
        if (isset($req['m']) && !empty($req['m']))
            $coursesModel->where('month(course_batch.start_classroom)', $req['m']);
        if (isset($req['c']) && !empty($req['c']))
            $coursesModel->whereIn('courses.course_category_id', explode(',', $req['c']));
        return $coursesModel->orderBy('course_batch.start_enrollment', 'DESC');
    }

    public function Index()
    {
        $fKeyword = $this->request->getVar('k');
        $fMonth = $this->request->getVar('m');
        $fCategory =  $this->request->getVar('c');
        
        $coursesModel = $this->GetCourses([
            'k' => $fKeyword,
            'm' => $fMonth,
            'c' => $fCategory
        ]);
        $courseList = $coursesModel->paginate(20);

        return $this->render('Course/' . __FUNCTION__, [
            'courseList' => $courseList,
            'coursePaging' => $coursesModel->pager->links(),
            'courseCount' => $this->GetCourses([
                    'k' => $fKeyword,
                    'm' => $fMonth,
                    'c' => $fCategory
                ])->countAllResults(),
            'courseCategoryList' => (new CourseCategoriesModel)->orderBy('title', 'asc')->findAll(),
            'dateExtension' => new Date,
            'fKeyword' => $fKeyword,
            'fMonth' => $fMonth,
            'fCategory' => explode(',', $fCategory),
        ]);
    }

    public function Detail($id = null)
    {
        if (empty($id))
            return redirect()->to('/');
        $coursesModel = new CoursesModel;
        $course = $coursesModel->find($id);
        if (empty($course))
            return redirect()->to('/');
        if ($course['display'] === 'PRIVATE' && $this->userLogged['user_level'] !== 'ADMINISTRATOR')
            return redirect()->to('/');

        $courseLecturerList = (new CourseLecturerModel)->select('lecturer.*')
            ->join('lecturer', 'course_lecturer.lecturer_id = lecturer.lecturer_id', 'left')
            ->where('course_id', $course['course_id'])
            ->findAll();
        if (session()->get('LOGGED_IN') && $this->userLogged['user_level'] != 'ADMINISTRATOR')
            $coursesModel->update($course['course_id'], ['views_count' => $course['views_count'] + 1]);
        $courseBatchModel = new CourseBatchModel;
        $showLink = false;
        if (session()->get('LOGGED_IN'))
        {
            $showLink = (new EnrollModel)->where([
                'status' => 'SUCCESS',
                'course_id' => $course['course_id'],
                'user_id' => $this->userLogged['user_id']
            ])->countAllResults();
        }
        if (session()->get('LOGGED_IN') && $this->userLogged['user_level'] != 'ADMINISTRATOR')
            $showLink = true;
        

        return $this->render('Course/' . __FUNCTION__, [
            
            'course' => $course,
            'courseLecturerList' => $courseLecturerList,
            'courseBatchList' => $courseBatchModel->select('course_batch.*,'
                .'(select count(*) from enroll where enroll.course_id = course_batch.course_id and enroll.course_batch_id = course_batch.course_batch_id and enroll.status != \'CANCELED\') as enrolled_count')
                ->where([
                    'course_id' => $course['course_id'],
                    'is_active' => 'TRUE'
                ])
                ->orderBy('start_classroom', 'ASC')
                ->findAll(),
            'dateExtension' => new Date,
            'provinceList' => (new ProvinceModel)->orderBy('name', 'ASC')->findAll(),
            'openEnroll' => ($courseBatchModel->where([
                    'course_id' => $course['course_id'],
                    'is_active' => 'TRUE'
                ])
                ->where('CURDATE() between start_enrollment and end_enrollment')
                ->countAllResults() > 0),
            'showLink' => $course['is_onsite'] == 'TRUE' ? false : $showLink
        ]);
    }

    public function Enroll()
    {
        $render = 'Course/' . __FUNCTION__;
        $redirect = base_url();

        if (!session()->get('LOGGED_IN'))
            return $this->renderError($render, 'กรุณาเข้าสู่ระบบ', $redirect, false, false);
        $form = $this->request->getPost();
        if (empty($form))
            return $this->renderError($render, 'ขออภัย ไม่พบข้อมูลจากแบบฟอร์มลงทะเบียนหลักสูตรอบรม', $redirect, false, false);

        $courseId = $form['cid'];
        $courseBatchId = $form['batch'];
        $invoiceLocat = $form['invoiceLocat'] ?? 'DEFAULT';
        $invoiceName = $form['invoiceName'];
        $invoiceTaxId = $form['invoiceTaxId'];
        $invoiceAddress = $form['invoiceAddress'];
        $invoiceProvince = $form['invoiceProvince'];
        $invoiceDistrict = $form['invoiceDistrict'];
        $invoiceSubDistrict = $form['invoiceSubDistrict'];
        $invoicePostalCode = $form['invoicePostalCode'];
        
        $course = (new CoursesModel)->find($courseId);
        if (empty($course))
            return $this->renderError($render, 'ขออภัย ไม่พบข้อมูลหลักสูตรอบรม', $redirect, false, false);
        if (empty($courseBatchId))
            return $this->renderError($render, 'กรุณาเลือกรอบหลักสูตรอบรม', $redirect, false, false);
        $courseBatch = (new CourseBatchModel)->find($courseBatchId);
        if (empty($courseBatch))
            return $this->renderError($render, 'ขออภัย ไม่พบข้อมูลรอบหลักสูตรอบรม', $redirect, false, false);
        $redirect .= '/course/' . $courseId;
        $now = date('Y-m-d', strtotime(date('Y-m-d')));
        $enrollStart = date('Y-m-d', strtotime($courseBatch['start_enrollment']));
        $enrollEnd = date('Y-m-d', strtotime($courseBatch['end_enrollment']));
        if ($now < $enrollStart)
            return $this->renderError($render, 'ขออภัย หลักสูตรอบรมยังไม่เปิดลงทะเบียนในเวลานี้', $redirect, false, false);
        if ($now >= $enrollEnd)
            return $this->renderError($render, 'ขออภัย หลักสูตรอบรมสิ้นสุดการลงทะเบียนแล้ว', $redirect, false, false);
        $enrollModel = new EnrollModel;
        if ($enrollModel->where(['course_id' => $courseId, 'course_batch_id' => $courseBatchId, 'user_id' => $this->userLogged['user_id']])->countAllResults() > 0)
            return $this->renderError($render, 'ขออภัย ไม่สามารถลงทะเบียน ['.$course['title'].'] ซ้ำได้อีกครั้ง', $redirect, false, false);
        if ($enrollModel->where(['course_id' => $courseId, 'course_batch_id' => $courseBatchId, 'status !=' => 'CANCELED'])->countAllResults() >= $courseBatch['max_enroll'] && $courseBatch['max_enroll'] > 0)
            return $this->renderError($render, 'ขออภัย หลักสูตร ['.$course['title'].'] มีผู้ลงทะเบียนครบแล้ว', $redirect, false, false);
        if ($invoiceLocat == 'ANOTHER')
        {
            $err = [];
            if (empty($invoiceName))
                $err[] = 'กรุณากรอกชื่อผู้รับ/องค์กร/หน่วยงาน (สำหรับการออกใบแจ้งหนี้/ใบเสร็จ)';
            if (empty($invoiceTaxId))
                $err[] = 'กรุณากรอกเลขประจำตัวผู้เสียภาษี (สำหรับการออกใบแจ้งหนี้/ใบเสร็จ)';
            if (empty($invoiceAddress))
                $err[] = 'กรุณากรอกรายละเอียดที่อยู่ (สำหรับการออกใบแจ้งหนี้/ใบเสร็จ)';
            if (empty($invoiceProvince))
                $err[] = 'กรุณาเลือกจังหวัด (สำหรับการออกใบแจ้งหนี้/ใบเสร็จ)';
            if (empty($invoiceDistrict))
                $err[] = 'กรุณากรอกเขต/อำเภอ (สำหรับการออกใบแจ้งหนี้/ใบเสร็จ)';
            if (empty($invoiceSubDistrict))
                $err[] = 'กรุณากรอกแขวง/ตำบล (สำหรับการออกใบแจ้งหนี้/ใบเสร็จ)';
            if (empty($invoicePostalCode) || strlen($invoicePostalCode) != 5)
                $err[] = 'กรุณากรอกรหัสไปรษณีย์ (สำหรับการออกใบแจ้งหนี้/ใบเสร็จ)';
            if (!preg_match("/^[0-9]{5}$/", $invoicePostalCode))
                $err[] = 'รูปแบบรหัสไปรษณีย์ (สำหรับการออกใบแจ้งหนี้/ใบเสร็จ) ไม่ถูกต้อง';
            if (count($err) > 0)
                return $this->renderError($render, join('<br>', $err), $redirect, false, false);
        }
        $newInvoiceNo = (date('y') + 43) . sprintf('%04d', $enrollModel->where('year(enrolled)', date('Y'))->countAllResults() + 1);
        if ($enrollModel->insert([
            'status' => 'PENDING',
            'description' => '',
            'course_id' => $course['course_id'],
            'course_batch_id' => $courseBatch['course_batch_id'],
            'regis_fee' => $course['regis_fee'],
            'user_id' => $this->userLogged['user_id'],
            'fullname_tha' => $this->userLogged['name_title_tha'] . $this->userLogged['fullname_tha'],
            'fullname_eng' => $this->userLogged['name_title_eng'] . $this->userLogged['fullname_eng'],
            'id_card' => $this->userLogged['id_card'],
            'birth' => $this->userLogged['birth'],
            'email' => $this->userLogged['email'],
            'mobile' => $this->userLogged['mobile'],
            'address' => $this->userLogged['address'],
            'province' => $this->userLogged['province'],
            'district' => $this->userLogged['district'],
            'sub_district' => $this->userLogged['sub_district'],
            'postal_code' => $this->userLogged['postal_code'],
            'invoice_no' => $newInvoiceNo,
            'invoice_name' => $invoiceLocat == 'DEFAULT' ? $this->userLogged['name_title_tha'] . $this->userLogged['fullname_tha'] : $invoiceName,
            'invoice_tax_id' => $invoiceLocat == 'DEFAULT' ? $this->userLogged['id_card'] : $invoiceTaxId,
            'invoice_address' => $invoiceLocat == 'DEFAULT' ? $this->userLogged['address'] : $invoiceAddress,
            'invoice_province' => $invoiceLocat == 'DEFAULT' ? $this->userLogged['province'] : $invoiceProvince,
            'invoice_district' => $invoiceLocat == 'DEFAULT' ? $this->userLogged['district'] : $invoiceDistrict,
            'invoice_sub_district' => $invoiceLocat == 'DEFAULT' ? $this->userLogged['sub_district'] : $invoiceSubDistrict,
            'invoice_postal_code' => $invoiceLocat == 'DEFAULT' ? $this->userLogged['postal_code'] : $invoicePostalCode,
            'inspector' => 0,
            'has_alert' => 1,
            'enrolled' => date('Y-m-d H:i:s')
        ])) return $this->renderSuccess($render, 'คุณได้ลงทะเบียน ['.$course['title'].'] เรียบร้อยแล้ว<br>โปรดรออีเมลแจ้งผลการลงทะเบียนหลังจากวันที่สิ้นสุดการลงทะเบียน 2-3 วันทำการ<br>ขอบคุณค่ะ', $redirect, false, false);
        return $this->renderError($render, 'เกิดข้อผิดพลาดในการลงทะเบียน ['.$course['title'].']', $redirect, false, false);
    }
}
