<?php
/* Shaoransoft Developer */
namespace App\Controllers;

use App\Models\EnrollModel;
use App\Models\PaymentModel;

use App\ViewModels\PaymentViewModel;

class Payment extends BaseController
{
    public function Index()
    {
        if (!session()->get('LOGGED_IN'))
            return redirect()->to('/');

        $enrollModel = new EnrollModel;
        $fileImage = PaymentViewModel::$fileImage;
        $res = ['submit' => false, 'success' => false, 'message' => ''];
        $form = $this->request->getPost();
        if (!empty($form))
        {
            $res['submit'] = true;
            $enrollId = $form['enroll'];
            $slipDate = $form['date'];
            $slipTime = $form['time'];
            $slipAmount = $form['amount'];
            $image = $this->request->getFile('image');

            $paymentModel = new PaymentModel;
            $err = [];
            if (empty($enrollId))
                $err[] = 'กรุณาเลือกการสมัครที่ต้องการชำระ';
            if (empty($slipDate))
                $err[] = 'กรุณากรอกวันที่ทำรายการชำระ';
            if (empty($slipTime))
                $err[] = 'กรุณากรอกเวลาทำรายการชำระ';
            if (empty($slipAmount))
                $err[] = 'กรุณากรอกจำนวนเงินที่ชำระ';
            if (!$image->isValid())
                $err[] = 'กรุณาอัปโหลดรูปหลักฐานการชำระเงิน';
            if (count($err) > 0)
                $res['message'] = join('<br>', $err);
            elseif ($enrollId == 'null')
                $res['message'] = 'ไม่พบรายการค้างชำระ';
            elseif (!$this->validate([
                'image' => [
                    'label' => 'Image Slip',
                    'rules' => 'uploaded[image]'
                        .'|is_image[image]'
                        .'|mime_in[image,'.join(',', $fileImage['accept']).']'
                        .'|ext_in[image,'.join(',', $fileImage['extension']).']'
                        .'|max_size[image,'.$fileImage['maxSize'].']'
                ]
            ])) $res['message'] = join(',', $this->validator->getErrors());
            else
            {
                $enroll = $enrollModel->find($enrollId);
                if (empty($enroll))
                    $res['message'] = 'เกิดข้อผิดพลาดในการบันทึกการเปลี่ยนแปลงข้อมูล กรุณาลองใหม่อีกครั้ง';
                elseif ($enroll['status'] !== 'PENDING_PAY')
                    $res['message'] = 'การสมัครหลักสูตรอบรมดังกล่าวไม่ใช่สถานะรอการชำระเงิน';
                elseif ($enroll['regis_fee'] !== $slipAmount)
                    $res['message'] = 'จำนวนชำระไม่ตรงกับยอดที่ต้องชำระ';
                elseif ($paymentModel->where([
                    'enroll_id' => $enrollId,
                    'user_id' => $this->userLogged['user_id'],
                    'status !=' => 'CANCELED'
                ])->countAllResults() > 0)
                    $res['message'] = 'คุณได้แจ้งการชำระเงินการสมัครหลักสูตรดังกล่าวเรียบร้อยแล้ว';
                else
                {
                    $imageNewName = $image->getRandomName();
                    $image->move($fileImage['path'], $imageNewName);
                    if ($paymentModel->insert([
                        'status' => 'PENDING',
                        'enroll_id' => $enrollId,
                        'user_id' => $this->userLogged['user_id'],
                        'slip_date' => $slipDate,
                        'slip_time' => $slipTime,
                        'slip_amount' => $slipAmount,
                        'slip_image' => $fileImage['path'] . '/' .$imageNewName,
                        'created' => date('Y-m-d H:i:s')
                    ]))
                    {
                        $enrollModel->update($enrollId, [
                            'status' => 'CHECKING_PAY',
                            'has_alert' => 1
                        ]);
                        $res = [
                            'submit' => true,
                            'success' => true,
                            'message' => 'บันทึกการแจ้งชำระเงินสำเร็จแล้ว โปรดรอเจ้าหน้าที่ตรวจสอบการชำระเงินของท่าน'
                        ];
                    }
                    else $res['message'] = 'เกิดข้อผิดพลาดในการบันทึกการแจ้งชำระเงิน กรุณาลองใหม่อีกครั้ง';
                }
            }
        }

        helper('number');
        return $this->render('Payment/' . __FUNCTION__, [
            'enrollList' => $enrollModel->select('enroll.*,'
                .'(select count(*) from payment where payment.enroll_id = enroll.enroll_id and payment.status != \'CANCELED\') as paid_count')
                ->where([
                    'enroll.user_id' => $this->userLogged['user_id'],
                    'enroll.status' => 'PENDING_PAY'
                ])
                ->findAll(),
            'res' => $res,
            'fileImage' => $fileImage,
            'form' => $form
        ]);
    }
}
