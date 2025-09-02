<?php
/* Shaoransoft Developer */
namespace App\Controllers\Api;

use CodeIgniter\API\ResponseTrait;

use App\Models\EnrollModel;
use App\Models\PaymentModel;

use App\Extension\Date;

class PaymentApi extends ApiController
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
            'payment.status',
            'enroll.fullname_tha',
            'courses.title',
            'payment.slip_date',
            'payment.slip_time',
            'payment.slip_amount',
            'payment.created',
            'payment.inspector',
            null
        ];

        $paymentModel = (new PaymentModel)->select('payment.*,'
            .'enroll.invoice_no as enroll_invoice_no,'
            .'enroll.fullname_tha as enroll_fullname_tha,'
            .'enroll.course_id as enroll_course_id,'
            .'courses.title as course_title,'
            .'ifnull((select users.fullname_tha from users where payment.inspector = users.user_id), \'\') as inspector_fullname,'
            .'row_number() over (order by payment.modified desc) row_num')
            ->join('enroll', 'enroll.enroll_id = payment.enroll_id', 'left')
            ->join('courses', 'courses.course_id = enroll.course_id', 'left');
        if ($this->userLogged['user_level'] === 'OFFICER')
            $paymentModel->where('courses.creator', $this->userLogged['user_id']);
        if ($reqStatus !== '' && $reqStatus !== 'all')
            $paymentModel->where('payment.status', strtoupper($reqStatus));
        $paymentModel->groupStart()
                ->like('enroll.invoice_no', $searchValue)
                ->orLike('enroll.fullname_tha', $searchValue)
                ->orLike('courses.title', $searchValue)
            ->groupEnd()
            ->orderBy($columns[array_key_exists($orderColumn, $columns) ? $orderColumn : 0], $orderDir);
        $paymentList = $paymentModel->findAll($length, $start);
        $paymentModel->join('enroll', 'enroll.enroll_id = payment.enroll_id', 'left')
            ->join('courses', 'courses.course_id = enroll.course_id', 'left');
        if ($this->userLogged['user_level'] === 'OFFICER')
            $paymentModel->where('courses.creator', $this->userLogged['user_id']);
        if ($reqStatus !== '' && $reqStatus !== 'all')
            $paymentModel->where('payment.status', strtoupper($reqStatus));
        $numRows = $paymentModel->countAllResults();
        $res = [
            'draw' => $req['draw'] ?? 1,
            'recordsTotal' => $numRows,
            'recordsFiltered' => $numRows
        ];
        foreach ($paymentList as $payment)
        {
            $res['data'][] = [
                $payment['row_num'],
                $payment['enroll_invoice_no'],
                $payment['status'],
                $payment['enroll_fullname_tha'],
                $payment['course_title'],
                Date::thai_format('d/m/Y', $payment['slip_date']),
                Date::thai_format('H:i', $payment['slip_time']),
                number_format($payment['slip_amount'], 2),
                Date::thai_format('d/m/Y', $payment['created']),
                $payment['inspector_fullname'],
                null,
                $payment['payment_id'],
                $payment['enroll_course_id']
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
            $payment = (new PaymentModel)->select('payment.*,'
                .'enroll.invoice_no as enroll_invoice_no,'
                .'enroll.fullname_tha as enroll_fullname_tha,'
                .'enroll.status as enroll_status,'
                .'courses.creator as course_creator,'
                .'ifnull((select users.fullname_tha from users where payment.inspector = users.user_id), \'\') as inspector_fullname')
                ->join('enroll', 'enroll.enroll_id = payment.enroll_id', 'left')
                ->join('courses', 'courses.course_id = enroll.course_id', 'left')
                ->where('payment.payment_id', $id)
                ->first();
            if (!empty($payment) && $this->userLogged['user_level'] === 'OFFICER' && $this->userLogged['user_id'] !== $payment['course_creator'])
                return $this->unauthorized();
            return $this->respondSuccess('success', $payment);
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
        $paymentId = $form['paymentId'];
        $status = $form['status'];

        $paymentModel = new PaymentModel;
        $enrollModel = new EnrollModel;
        $payment = $paymentModel->find($paymentId);
        if (empty($payment))
            return $this->respondError('ไม่พบข้อมูลการชำระเงิน');
        $enroll = $enrollModel->find($payment['enroll_id']);
        $err = [];
        if (empty($status))
            $err[] = 'กรุณาเลือกสถานะการชำระเงิน';
        if (count($err) > 0)
            return $this->respondError(join('<br>', $err));
        if ($enroll['status'] === 'SUCCESS')
            return $this->respondError('เนื่องจากสถานะการสมัครหลักสูตรอบรมผ่านการยืนยันเรียบร้อยแล้ว จึงไม่สามารถแก้ไขข้อมูลการชำระเงินได้');
        if ($paymentModel->update($paymentId, [
            'status' => $status,
            'inspector' => $status != 'PENDING' ? $this->userLogged['user_id'] : 0
        ]))
        {
            $enrollModel->update($payment['enroll_id'], [
                'status' => in_array($status, ['PENDING', 'CANCELED']) ? 'PENDING_PAY' : 'CONFIRM_PAID'
            ]);
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

        $paymentModel = new PaymentModel;
        $payment = $paymentModel->find($id);
        if (empty($payment))
            return $this->respondError('ไม่พบข้อมูลการลงทะเบียนหลักสูตร');
        if ($payment['slip_image'] !== '' && file_exists($payment['slip_image']))
            unlink($payment['slip_image']);
        if ($paymentModel->delete($id))
            return $this->respondSuccess('ลบข้อมูลสำเร็จแล้ว');
        return $this->respondError('ไม่สามารถลบข้อมูลได้ กรุณาลองใหม่อีกครั้ง');
    }
}