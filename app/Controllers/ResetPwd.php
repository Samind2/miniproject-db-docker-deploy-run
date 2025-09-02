<?php
/* Shaoransoft Developer */
namespace App\Controllers;

use App\Models\UsersModel;
use App\Models\ResetPwdModel;

class ResetPwd extends BaseController
{
    public function Index()
    {
        if (session()->get('LOGGED_IN'))
            return redirect()->to('/');

        $token = $this->request->getVar('token');
        $resetPwdModel = new ResetPwdModel;
        $resetPwd = $resetPwdModel->where('token', $token)->first();
        if (empty($resetPwd))
        {
            echo 'ไม่พบข้อมูลการรีเซ็ตรหัสผ่านบัญชี';
            exit;
        }
        if ($resetPwd['status'] !== 'PENDING')
        {
            echo 'เซสชั่นการทำรายการหมดอายุแล้ว';
            exit;
        }
        $now = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s')));
        $expirationDate = date('Y-m-d H:i:s', strtotime($resetPwd['expiration_date']));
        if ($now >= $expirationDate)
        {
            echo 'เซสชั่นการทำรายการหมดอายุแล้ว';
            exit;
        }
        
        $res = ['submit' => false, 'success' => false, 'message' => ''];
        $form = $this->request->getPost();
        if (!empty($form))
        {
            $res['submit'] = true;
            $newPassword = $form['newPassword'];

            if (empty($newPassword) || strlen($newPassword) < 8)
                $res['message'] = 'กรุณากรอกรหัสผ่านอย่างน้อย 8 อักขระขึ้นไป';
            elseif (!preg_match("/^[a-zA-Z0-9]+$/", $newPassword))
                $res['message'] = 'รหัสผ่านต้องเป็นอักขระ a-z, A-Z, 0-9 เท่านั้น';
            else
            {
                if ($resetPwdModel->update($resetPwd['reset_pwd_id'], ['status' => 'SUCCESS']))
                {
                    (new UsersModel)->update($resetPwd['user_id'], [
                        'login_pwd' => password_hash($newPassword, PASSWORD_BCRYPT, ['cost' => 12])
                    ]);
                    $res = [
                        'submit' => true,
                        'success' => true,
                        'message' => 'รหัสผ่านใหม่ของบัญชีของคุณพร้อมใช้งานแล้ว'
                    ];
                }
                else $res['message'] = 'ไม่สามารถรีเซ็ตรหัสผ่านได้ กรุณาลองใหม่อีกครั้ง';
            }
        }

        return $this->render('ResetPwd/' . __FUNCTION__, [
            'token' => $token,
            'res' => $res
        ]);
    }
}
