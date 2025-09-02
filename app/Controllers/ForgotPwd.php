<?php
/* Shaoransoft Developer */
namespace App\Controllers;

use App\Models\UsersModel;
use App\Models\ResetPwdModel;

class ForgotPwd extends BaseController
{
    public function Index()
    {
        if (session()->get('LOGGED_IN'))
            return redirect()->to('/');

        return $this->render('ForgotPwd/' . __FUNCTION__);
    }

    public function Action()
    {
        if (session()->get('LOGGED_IN'))
            return redirect()->to('/');

        $res = ['success' => false, 'message' => ''];
        $form = $this->request->getPost();
        if (!empty($form))
        {
            $username = $form['username'];

            if (empty($username))
                $res['message'] = 'กรุณากรอกอีเมลเพื่อกู้คืนบัญชีของคุณ';
            else
            {
                $usersModel = new UsersModel;
                $resetPwdModel = new ResetPwdModel;
                $user = $usersModel->where('email', $username)->first();
                if (empty($user))
                    $res['message'] = 'ไม่พบบัญชีผู้ใช้ของคุณ กรุณาลองใหม่อีกครั้ง';
                elseif ($resetPwdModel->where([
                    'user_id' => $user['user_id'],
                    'date(created)' => date('Y-m-d')
                ])->countAllResults() >= 3)
                    $res['message'] = 'ขอยื่นกู้คืนบัญชี '.$username.' ครบ 3 ครั้งแล้วในวันนี้';
                else
                {
                    $token = hash('sha256', sprintf('%04d', rand('1', '9999')) . date('YmdHis'));
                    $message = "คลิกลิงก์เพื่อทำการรีเซ็ตรหัสผ่านบัญชี ".$user['email']."\r\n";
                    $message .= base_url()."/resetpwd?token=".$token."\r\n\r\n";
                    $message .= "ลิงก์รีเซ็ตรหัสผ่านมีอายุ 30 นาที หลังจากส่งเข้าอีเมลของคุณ\r\n\r\n";
                    $message .= "หลักสูตรระยะสั้น คณะวิทยาสตร์และเทคโนโลยี\r\n";
                    $message .= "มหาวิทยาลัยราชภัฏนครปฐม";

                    $emailService = \Config\Services::email();
                    $emailService->setTo($user['email']);
                    $emailService->setSubject('SC NPRU Shortcourses - รีเซ็ตรหัสผ่านบัญชี');
                    $emailService->setMessage($message);
                    if ($emailService->send())
                    {
                        $resetPwdModel->insert([
                            'user_id' => $user['user_id'],
                            'token' => $token,
                            'status' => 'PENDING',
                            'expiration_date' => date('Y-m-d H:i:s', strtotime('+30 minutes')),
                            'created' => date('Y-m-d H:i:s')
                        ]);
                        $res = [
                            'submit' => true,
                            'success' => true,
                            'message' => 'กรุณาตรวจสอบอีเมลใน '.$user['email'].' และทำรายการภายใน 30 นาที'
                        ];
                    }
                    else $res['message'] = 'ไม่สามารถส่งอีเมลไปยัง '.$user['email'].' ได้ อาจเกิดจาก Server ของผู้ให้บริการอีเมลปลายทางมีปัญหาหรืออีเมลแอดเดรสไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง';
                }
            }
        }
        else $res['message'] = 'กรุณากรอกแบบฟอร์ม';

        return $this->render('ForgotPwd/' . __FUNCTION__, [
            'res' => $res,
        ]);
    }
}
