<?php
/* Shaoransoft Developer */
namespace App\Controllers\Api;

use CodeIgniter\API\ResponseTrait;

use App\Models\EnrollModel;
use App\Models\PaymentModel;
use App\Models\CoursesModel;
use App\Models\CourseBatchModel;

use App\Extension\Date;
use App\Models\UsersModel;

class EnrollApi extends ApiController
{
    use ResponseTrait;

    public function GetDT($reqStatus = null)
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
            'enroll.invoice_no',
            'enroll.status',
            'enroll.fullname_tha',
            'enroll.mobile',
            'enroll.email',
            'courses.title',
            'course_batch.start_classroom',
            'enroll.regis_fee',
            'enroll.enrolled',
            'enroll.inspector',
            null
        ];

        $enrollModel = (new EnrollModel)->select('enroll.*,'
            .'courses.title as course_title,'
            .'ifnull((select fullname_tha from users where enroll.inspector = users.user_id), \'\') as inspector_fullname,'
            .'course_batch.start_classroom as course_batch_start_classroom,'
            .'course_batch.end_classroom as course_batch_end_classroom,'
            .'row_number() over (order by enroll.modified desc) row_num')
            ->join('courses', 'courses.course_id = enroll.course_id', 'left')
            ->join('course_batch', 'course_batch.course_batch_id = enroll.course_batch_id', 'left');
        if ($this->userLogged['user_level'] === 'OFFICER')
            $enrollModel->where('courses.creator', $this->userLogged['user_id']);
        if ($reqStatus !== '' && $reqStatus !== 'all')
            $enrollModel->where('enroll.status', strtoupper($reqStatus));
        $enrollModel->groupStart()
                ->like('enroll.fullname_tha', $searchValue)
                ->orLike('enroll.id_card', $searchValue)
                ->orLike('enroll.mobile', $searchValue)
                ->orLike('enroll.email', $searchValue)
                ->orLike('courses.title', $searchValue)
            ->groupEnd()
            ->orderBy($columns[array_key_exists($orderColumn, $columns) ? $orderColumn : 0], $orderDir);
        $enrollList = $enrollModel->findAll($length, $start);
        $enrollModel->join('courses', 'courses.course_id = enroll.course_id', 'left')
            ->join('course_batch', 'course_batch.course_batch_id = enroll.course_batch_id', 'left');
        if ($this->userLogged['user_level'] === 'OFFICER')
            $enrollModel->where('courses.creator', $this->userLogged['user_id']);
        if ($reqStatus !== '' && $reqStatus !== 'all')
            $enrollModel->where('enroll.status', strtoupper($reqStatus));
        $numRows = $enrollModel->countAllResults();
        $res = [
            'draw' => $req['draw'] ?? 1,
            'recordsTotal' => $numRows,
            'recordsFiltered' => $numRows
        ];
        foreach ($enrollList as $enroll)
        {
            $res['data'][] = [
                $enroll['row_num'],
                $enroll['invoice_no'],
                $enroll['status'],
                $enroll['fullname_tha'],
                $enroll['mobile'],
                $enroll['email'],
                $enroll['course_title'],
                Date::thai_range_format('d M Y', $enroll['course_batch_start_classroom'], $enroll['course_batch_end_classroom']),
                number_format($enroll['regis_fee'], 0),
                Date::thai_format('d/m/Y', $enroll['enrolled']),
                $enroll['inspector_fullname'],
                null,
                $enroll['enroll_id'],
                $enroll['course_id'],
                $enroll['course_batch_id'],
                $enroll['has_alert'],
                $enroll['regis_fee']
            ];
        }

        return $this->respond($res);
    }

    public function GetCourseDT($id = null)
    {
        if (!session()->get('LOGGED_IN'))
            return $this->unauthorized();
        if (!in_array($this->userLogged['user_level'], ['OFFICER','ADMINISTRATOR']))
            return $this->unauthorized();
        if (empty($id) || $id == 0)
            return $this->respond(['data' => [], 'recordsTotal' => 0, 'recordsFiltered' => 0]);

        $req = $this->request->getPost();
        $searchValue = $req['search']['value'] ?? '';
        $start = $req['start'] ?? 0;
        $length = $req['length'] ?? 0;
        if ($length == -1) $start = $length = 0;
        $orderColumn = $req['order'][0]['column'] ?? 0;
        $orderDir = $req['order'][0]['dir'] ?? 'asc';

        $columns = [
            'row_num',
            'enroll.invoice_no',
            'enroll.status',
            'enroll.fullname_tha',
            'enroll.mobile',
            'enroll.email',
            'enroll.regis_fee',
            'enroll.enrolled',
            null
        ];

        $enrollModel = (new EnrollModel)->select('enroll.*,'
            .'ifnull((select fullname_tha from users where enroll.inspector = users.user_id), \'\') as inspector_fullname,'
            .'row_number() over (order by enroll.modified) row_num')
            ->join('courses', 'courses.course_id = enroll.course_id', 'left')
            ->where('enroll.course_id', $id);
        if ($this->userLogged['user_level'] === 'OFFICER')
            $enrollModel->where('courses.creator', $this->userLogged['user_id']);
        $enrollModel->groupStart()
                ->like('enroll.fullname_tha', $searchValue)
                ->orLike('enroll.id_card', $searchValue)
                ->orLike('enroll.mobile', $searchValue)
                ->orLike('enroll.email', $searchValue)
            ->groupEnd()
            ->orderBy($columns[array_key_exists($orderColumn, $columns) ? $orderColumn : 0], $orderDir);
        $enrollList = $enrollModel->findAll($length, $start);
        $enrollModel->join('courses', 'courses.course_id = enroll.course_id', 'left')
            ->where('enroll.course_id', $id);
        if ($this->userLogged['user_level'] === 'OFFICER')
            $enrollModel->where('courses.creator', $this->userLogged['user_id']);
        $numRows = $enrollModel->countAllResults();
        $res = [
            'draw' => $req['draw'] ?? 1,
            'recordsTotal' => $numRows,
            'recordsFiltered' => $numRows
        ];
        foreach ($enrollList as $enroll)
        {
            $res['data'][] = [
                $enroll['row_num'],
                $enroll['invoice_no'],
                $enroll['status'],
                $enroll['fullname_tha'],
                $enroll['mobile'],
                $enroll['email'],
                number_format($enroll['regis_fee'], 0),
                Date::thai_format('d/m/Y', $enroll['enrolled']),
                $enroll['inspector_fullname'],
                null,
                $enroll['enroll_id'],
                $enroll['has_alert'],
            ];
        }

        return $this->respond($res);
    }

    public function GetCourseBatchDT($id = null, $reqStatus = null)
    {
        if (!session()->get('LOGGED_IN'))
            return $this->unauthorized();
        if (!in_array($this->userLogged['user_level'], ['OFFICER','ADMINISTRATOR']))
            return $this->unauthorized();
        if (empty($id) || $id == 0)
            return $this->respond(['data' => [], 'recordsTotal' => 0, 'recordsFiltered' => 0]);

        $req = $this->request->getPost();
        $searchValue = $req['search']['value'] ?? '';
        $start = $req['start'] ?? 0;
        $length = $req['length'] ?? 0;
        if ($length == -1) $start = $length = 0;
        $orderColumn = $req['order'][0]['column'] ?? 0;
        $orderDir = $req['order'][0]['dir'] ?? 'asc';

        $columns = [
            'row_num',
            'enroll.invoice_no',
            'enroll.status',
            'enroll.fullname_tha',
            'enroll.mobile',
            'enroll.email',
            'enroll.regis_fee',
            'enroll.enrolled',
            null
        ];

        $enrollModel = (new EnrollModel)->select('enroll.*,'
            .'ifnull((select fullname_tha from users where enroll.inspector = users.user_id), \'\') as inspector_fullname,'
            .'row_number() over (order by enroll.enrolled desc) row_num')
            ->join('courses', 'courses.course_id = enroll.course_id', 'left')
            ->where('enroll.course_batch_id', $id);
        if ($this->userLogged['user_level'] === 'OFFICER')
            $enrollModel->where('courses.creator', $this->userLogged['user_id']);
        if ($reqStatus !== '' && $reqStatus !== 'all')
            $enrollModel->where('enroll.status', strtoupper($reqStatus));
        $enrollModel->groupStart()
                ->like('enroll.fullname_tha', $searchValue)
                ->orLike('enroll.id_card', $searchValue)
                ->orLike('enroll.mobile', $searchValue)
                ->orLike('enroll.email', $searchValue)
            ->groupEnd()
            ->orderBy($columns[array_key_exists($orderColumn, $columns) ? $orderColumn : 0], $orderDir);
        $enrollList = $enrollModel->findAll($length, $start);
        $enrollModel->join('courses', 'courses.course_id = enroll.course_id', 'left')
            ->where('enroll.course_batch_id', $id);
        if ($this->userLogged['user_level'] === 'OFFICER')
            $enrollModel->where('courses.creator', $this->userLogged['user_id']);
        if ($reqStatus !== '' && $reqStatus !== 'all')
            $enrollModel->where('enroll.status', strtoupper($reqStatus));
        $numRows = $enrollModel->countAllResults();
        $res = [
            'draw' => $req['draw'] ?? 1,
            'recordsTotal' => $numRows,
            'recordsFiltered' => $numRows
        ];
        foreach ($enrollList as $enroll)
        {
            $res['data'][] = [
                $enroll['row_num'],
                $enroll['invoice_no'],
                $enroll['status'],
                $enroll['fullname_tha'],
                $enroll['mobile'],
                $enroll['email'],
                number_format($enroll['regis_fee'], 0),
                Date::thai_format('d/m/Y', $enroll['enrolled']),
                $enroll['inspector_fullname'],
                null,
                $enroll['enroll_id'],
                $enroll['has_alert'],
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
            $enrollModel = new EnrollModel;
            $enroll = $enrollModel->select('enroll.*,'
                .'courses.creator as course_creator')
                ->join('courses', 'courses.course_id = enroll.course_id', 'left')
                ->where('enroll_id', $id)
                ->first();
            if (!empty($enroll) && $this->userLogged['user_level'] === 'OFFICER' && $this->userLogged['user_id'] !== $enroll['course_creator'])
                return $this->unauthorized();
            $enrollModel->update($id, ['has_alert' => 0]);
            return $this->respondSuccess('success', $enroll);
        }
        catch (\Exception $e)
        {
            return $this->respondError($e->getMessage());
        }
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
        $enrollId = $form['enrollId'];
        $status = $form['status'];
        $description = $status == 'OTHER' ? $form['description'] : '';
        $fullnameTha = $form['fullnameTha'];
        $fullnameEng = $form['fullnameEng'];
        $birthDate = $form['birthDate'];
        $birthMonth = $form['birthMonth'];
        $birthYear = $form['birthYear'];
        $mobile = $form['mobile'];
        $email = $form['email'];
        $address = $form['address'];
        $province = $form['province'];
        $district = $form['district'];
        $subDistrict = $form['subDistrict'];
        $postalCode = $form['postalCode'];
        $invoiceName = $form['invoiceName'];
        $invoiceTaxId = $form['invoiceTaxId'];
        $invoiceAddress = $form['invoiceAddress'];
        $invoiceProvince = $form['invoiceProvince'];
        $invoiceDistrict = $form['invoiceDistrict'];
        $invoiceSubDistrict = $form['invoiceSubDistrict'];
        $invoicePostalCode = $form['invoicePostalCode'];

        $enrollModel = new EnrollModel;
        $enroll = $enrollModel->find($enrollId);
        if (empty($enroll))
            return $this->respondError('ไม่พบข้อมูลการลงทะเบียนหลักสูตร');
        $course = (new CoursesModel)->find($enroll['course_id']);
        if ($this->userLogged['user_level'] === 'OFFICER' && $this->userLogged['user_id'] !== $course['creator'])
            return $this->respondError('คุณไม่ใช่ผู้สร้างหลักสูตร '.$course['title'].' ไม่มีสิทธิ์แก้ไขข้อมูล');
        $err = [];
        if (empty($status))
            $err[] = 'กรุณาเลือกสถานะการลงทะเบียน';
        if (empty($fullnameTha))
            $err[] = 'กรุณากรอกชื่อ-นามกสุล ภาษาไทย';
        if (empty($fullnameEng))
            $err[] = 'กรุณากรอกชื่อ-นามกสุล ภาษาอังกฤษ';
        if (empty($birthDate))
            $err[] = 'กรุณาเลือกวันเกิด';
        if (empty($birthMonth))
            $err[] = 'กรุณาเลือกเดือนเกิด';
        if (empty($birthYear))
            $err[] = 'กรุณาเลือกปีเกิด (พ.ศ.)';
        if (!checkdate($birthMonth, $birthDate, $birthYear))
            $err[] = 'รูปแบบวันเกิดไม่ถูกต้อง';
        if (empty($mobile) || strlen($mobile) != 10)
            $err[] = 'กรุณากรอกเบอร์มือถือ';
        if (!preg_match("/^0[0-9]{9}$/", $mobile))
            $err[] = 'รูปแบบเบอร์มือถือไม่ถูกต้อง';
        if (empty($email))
            $err[] = 'กรุณากรอกอีเมล';
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            $err[] = 'รูปแบบอีเมลไม่ถูกต้อง';
        if (empty($address))
            $err[] = 'กรุณากรอกรายละเอียดที่อยู่';
        if (empty($province))
            $err[] = 'กรุณาเลือกจังหวัด';
        if (empty($district))
            $err[] = 'กรุณากรอกเขต/อำเภอ';
        if (empty($subDistrict))
            $err[] = 'กรุณากรอกแขวง/ตำบล';
        if (empty($postalCode) || strlen($postalCode) != 5)
            $err[] = 'กรุณากรอกรหัสไปรษณีย์';
        if (!preg_match("/^[0-9]{5}$/", $postalCode))
            $err[] = 'รูปแบบรหัสไปรษณีย์ไม่ถูกต้อง';
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
            return $this->respondError(join('<br>', $err));
        if ($enroll['status'] === 'PENDING' && $status === 'PENDING_PAY')
        {
            $courseBatch = (new CourseBatchModel)->find($enroll['course_batch_id']);

            $message = "เรียนคุณ ".$enroll['fullname_tha']."\r\n";
            $message .= "ใบแจ้งชำระเงินค่าอบรมหลักสูตร ".$course['title']."\r\n\r\n";
            $message .= "โปรดชำระเงินและส่งหลักฐานการชำระเงินก่อนวันที่ ".Date::thai_format('d/m/Y', $courseBatch['end_payment'])." จำนวนเงิน ".number_format($enroll['regis_fee'], 2)." บาท\r\n";
            $message .= "ธนาคารกรุงไทย ชื่อบัญชี มหาวิทยาลัยราชภัฏนครปฐม\r\n";
            $message .= "ประเภทกระแสรายวัน\r\n";
            $message .= "เลขบัญชี 986-5-34173-5\r\n\r\n";
            $message .= "วิธีแจ้งชำระเงิน\r\n";
            $message .= "1.เข้าสู่ระบบ ".base_url()."/signin\r\n";
            $message .= "2.ไปที่เมนู ชื่อผู้ใช้งาน\r\n";
            $message .= "3.ไปที่เมนู แจ้งการชำระเงิน\r\n";
            $message .= "4.เลือกรายการค้างชำระ\r\n";
            $message .= "5.กรอกข้อมูลวันที่เวลาชำระเงิน และจำนวนเงิน\r\n";
            $message .= "6.อัปโหลดรูปหลักฐานการชำระเงิน\r\n";
            $message .= "7.กดปุ่ม ยืนยันการส่งหลักฐาน\r\n\r\n";
            $message .= "หลักสูตรระยะสั้น คณะวิทยาสตร์และเทคโนโลยี\r\n";
            $message .= "มหาวิทยาลัยราชภัฏนครปฐม";
            
            $emailService = \Config\Services::email();
            $emailService->setTo($enroll['email']);
            $emailService->setSubject('SC NPRU Shortcourses - ใบแจ้งชำระเงินค่าอบรมหลักสูตร');
            $emailService->setMessage($message);
            if (!$emailService->send())
                return $this->respondError('ไม่สามารถส่งอีเมลถึง '.$enroll['email'].' ได้ อาจเกิดจาก Server ของผู้ให้บริการอีเมลปลายทางมีปัญหาหรืออีเมลแอดเดรสไม่ถูกต้อง กรุณาให้ผู้ใช้งานตรวจสอบอีเมลอีกครั้ง');
        }
        if ($enroll['status'] === 'PENDING_PAY' && $status === 'CONFIRM_PAID')
        {
            $paymentModel = new PaymentModel;
            $payment = $paymentModel->where([
                'enroll_id' => $enroll['enroll_id'],
                'status !=' => 'CANCELED' 
            ])->first();
            if (empty($payment))
                return $this->respondError('ไม่พบข้อมูลการชำระเงิน ไม่สามารถยืนยันการชำระเงินได้');
            $paymentModel->update($payment['payment_id'], [
                'status' => 'SUCCESS',
                'inspector' => $this->userLogged['user_id']
            ]);
        }
        if ($enroll['status'] === 'CONFIRM_PAID' && in_array($status, ['CHECKING_PAY', 'PENDING_PAY', 'PENDING']))
        {
            $paymentModel = new PaymentModel;
            $payment = $paymentModel->where([
                'enroll_id' => $enroll['enroll_id'],
                'status !=' => 'CANCELED'
            ])->first();
            if (!empty($payment))
            {
                $paymentModel->update($payment['payment_id'], [
                    'status' => 'PENDING',
                    'inspector' => 0
                ]);
            }
        }
        if ($enroll['status'] === 'CONFIRM_PAID' && $status === 'PENDING' && $course['regis_fee'] == 0)
        {
            $courseBatch = (new CourseBatchModel)->find($enroll['course_batch_id']);

            $message = "เรียนคุณ ".$enroll['fullname_tha']."\r\n";
            $message .= "คุณได้รับการยืนยันเข้าร่วมอบรมหลักสูตร ".$course['title']."\r\n\r\n";
            $message .= "โปรดมาแสดงตัวตนในวันที่ ".Date::thai_format('d/m/Y', $courseBatch['start_classroom'])."\r\n";
            if ($course['is_onsite'] == 'TRUE')
            {
                $message .= "ผ่านช่องทาง ".$course['online_url']."\r\n";
                if ($course['online_requirement'] !== '') $message .= "เพิ่มเติม: ".$course['online_requirement']."\r\n";
            }
            else $message .= "สถานที่ ".$course['location']."\r\n";
            $message .= "\r\nหลักสูตรระยะสั้น คณะวิทยาสตร์และเทคโนโลยี\r\n";
            $message .= "มหาวิทยาลัยราชภัฏนครปฐม";
            
            $emailService = \Config\Services::email();
            $emailService->setTo($enroll['email']);
            $emailService->setSubject('SC NPRU Shortcourses - ใบแจ้งชำระเงินค่าอบรมหลักสูตร');
            $emailService->setMessage($message);
            if (!$emailService->send())
                return $this->respondError('ไม่สามารถส่งอีเมลถึง '.$enroll['email'].' ได้ อาจเกิดจาก Server ของผู้ให้บริการอีเมลปลายทางมีปัญหาหรืออีเมลแอดเดรสไม่ถูกต้อง กรุณาให้ผู้ใช้งานตรวจสอบอีเมลอีกครั้ง');
        }
        if ($enrollModel->update($enrollId, [
            'status' => $status,
            'description' => $description,
            'fullname_tha' => $fullnameTha,
            'fullname_eng' => $fullnameEng,
            'birth' => $birthYear.'-'.$birthMonth.'-'.$birthDate,
            'email' => $email,
            'mobile' => $mobile,
            'address' => $address,
            'province' => $province,
            'district' => $district,
            'sub_district' => $subDistrict,
            'postal_code' => $postalCode,
            'invoice_name' => $invoiceName,
            'invoice_tax_id' => $invoiceTaxId,
            'invoice_address' => $invoiceAddress,
            'invoice_province' => $invoiceProvince,
            'invoice_district' => $invoiceDistrict,
            'invoice_sub_district' => $invoiceSubDistrict,
            'invoice_postal_code' => $invoicePostalCode,
            'inspector' => ($status != 'PENDING' ? $this->userLogged['user_id'] : 0),
            'has_alert' => 0
        ])) return $this->respondSuccess('บันทึกการเปลี่ยนแปลงข้อมูลเรียบร้อยแล้ว');
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

        $enrollModel = new EnrollModel;
        $enroll = $enrollModel->find($id);
        if (empty($enroll))
            return $this->respondError('ไม่พบข้อมูลการลงทะเบียนหลักสูตร');
        $course = (new CoursesModel)->find($enroll['course_id']);
        if ($this->userLogged['user_level'] === 'OFFICER' && $this->userLogged['user_id'] !== $course['creator'])
            return $this->respondError('คุณไม่ใช่ผู้สร้างหลักสูตร '.$course['title'].' ไม่มีสิทธิ์ลบข้อมูล');
        if ($enrollModel->delete($id))
        {
            $paymentModel = new PaymentModel;
            $payment = $paymentModel->where('enroll_id', $enroll['enroll_id'])->first();
            if ($payment)
            {
                if ($payment['slip_image'] !== '' && file_exists($payment['slip_image']))
                    unlink($payment['slip_image']);
                $paymentModel->where('enroll_id', $enroll['enroll_id'])->delete();
            }
            return $this->respondSuccess('ลบข้อมูลสำเร็จแล้ว');
        }
        return $this->respondError('ไม่สามารถลบข้อมูลได้ กรุณาลองใหม่อีกครั้ง');
    }

    public function ModifyAlert()
    {
        if (!session()->get('LOGGED_IN'))
            return $this->unauthorized();
        if (!in_array($this->userLogged['user_level'], ['OFFICER','ADMINISTRATOR']))
            return $this->unauthorized();

        $form = $this->request->getPost();
        if (empty($form))
            return $this->respondError('กรุณากรอกแบบฟอร์ม');
        $enrollId = $form['enrollId'];

        $enrollModel = new EnrollModel;
        $enroll = $enrollModel->find($enrollId);
        if (empty($enroll))
            return $this->respondError('ไม่พบข้อมูลการลงทะเบียนหลักสูตร');
        $course = (new CoursesModel)->find($enroll['course_id']);
        if ($this->userLogged['user_level'] === 'OFFICER' && $this->userLogged['user_id'] !== $course['creator'])
            return $this->respondError('คุณไม่ใช่ผู้สร้างหลักสูตร '.$course['title'].' ไม่มีสิทธิ์แก้ไขข้อมูล');
        if ($enrollModel->update($enrollId, ['has_alert' => $enroll['has_alert'] === '0' ? 1 : 0]))
            return $this->respondSuccess('บันทึกการเปลี่ยนแปลงข้อมูลเรียบร้อยแล้ว');
        return $this->respondError('เกิดข้อผิดพลาดในการบันทึกข้อมูล กรุณาลองใหม่อีกครั้ง');
    }

    public function GetJoinedDT($id = null)
    {
        if (empty($id) || $id == 0)
            return $this->respond(['data' => [], 'recordsTotal' => 0, 'recordsFiltered' => 0]);

        $req = $this->request->getPost();
        $searchValue = $req['search']['value'] ?? '';
        $start = $req['start'] ?? 0;
        $length = $req['length'] ?? 0;
        if ($length == -1) $start = $length = 0;
        $orderColumn = $req['order'][0]['column'] ?? 0;
        $orderDir = $req['order'][0]['dir'] ?? 'asc';

        $columns = [
            'row_num',
            'enroll.fullname_eng',
            'enroll.status'
        ];

        $enrollModel = (new EnrollModel)->select('enroll.fullname_eng,'
            .'enroll.status,'
            .'course_batch.max_enroll,'
            .'course_batch.min_enroll,'
            .'row_number() over (order by field(enroll.status, \'SUCCESS\', \'CONFIRM_PAID\', \'CHECKING_PAY\', \'PENDING_PAY\', \'PENDING\', \'CANCELED\', \'OTHER\')) row_num')
            ->join('course_batch', 'enroll.course_batch_id = course_batch.course_batch_id', 'left')
            ->where([
                'enroll.course_batch_id' => $id,
                'course_batch.end_enrollment <' => date('Y-m-d')
            ])
            ->groupStart()
                ->like('enroll.fullname_eng', $searchValue)
            ->groupEnd()
            ->orderBy($columns[array_key_exists($orderColumn, $columns) ? $orderColumn : 0], $orderDir);
        $enrollList = $enrollModel->findAll($length, $start);
        $enrollModel->join('course_batch', 'enroll.course_batch_id = course_batch.course_batch_id', 'left')
            ->where([
                'enroll.course_batch_id' => $id,
                'course_batch.end_enrollment <' => date('Y-m-d')
            ]);
        $numRows = $enrollModel->countAllResults();
        $res = [
            'draw' => $req['draw'] ?? 1,
            'recordsTotal' => $numRows,
            'recordsFiltered' => $numRows
        ];
        $i = 0;
        $statusMsg = [
            'PENDING' => 'รอตรวจสอบ',
            'PENDING_PAY' => 'รอการชำระเงิน',
            'CHECKING_PAY' => 'รอตรวจสอบชำระเงิน',
            'CONFIRM_PAID' => 'ยืนยันการชำระเงิน',
            'SUCCESS' => 'เสร็จสมบูรณ์',
            'CANCELED' => 'ยกเลิก',
            'OTHER' => 'อื่นๆ'
        ];
        foreach ($enrollList as $enroll)
        {
            $showJoined = ($numRows >= round(($enroll['max_enroll'] / 100) * $enroll['min_enroll']));
            if ($showJoined)
            {
                $res['data'][] = [
                    $enroll['row_num'],
                    $enroll['fullname_eng'],
                    $statusMsg[$enroll['status']]
                ];
                $i++;
            }
        }
        if ($i == 0)
            return $this->respond(['data' => [], 'recordsTotal' => 0, 'recordsFiltered' => 0]);
        return $this->respond($res);
    }
}