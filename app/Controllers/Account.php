<?php
/* Shaoransoft Developer */
namespace App\Controllers;

use App\Models\ProvinceModel;
use App\Models\UsersModel;

use App\Extension\Date;

class Account extends BaseController
{
    public function Info()
    {
        if (!session()->get('LOGGED_IN'))
            return redirect()->to('/');

        $res = ['submit' => false, 'success' => false, 'message' => ''];
        $form = $this->request->getPost();
        if (!empty($form))
        {
            $res['submit'] = true;
            $nameTitleTha = $form['nameTitleTha'];
            $firstnameTha = $form['firstnameTha'];
            $lastnameTha = $form['lastnameTha'];
            $nameTitleEng = $form['nameTitleEng'];
            $firstnameEng = $form['firstnameEng'];
            $lastnameEng = $form['lastnameEng'];
            $birthDate = $form['birthDate'];
            $birthMonth = $form['birthMonth'];
            $birthYear = $form['birthYear'];
            $mobile = $form['mobile'];
            $address = $form['address'];
            $province = $form['province'];
            $district = $form['district'];
            $subDistrict = $form['subDistrict'];
            $postalCode = $form['postalCode'];

            $usersModel = new UsersModel;
            $err = [];
            if (empty($nameTitleTha))
                $err[] = 'กรุณาเลือกคำนำหน้าชื่อ';
            if (empty($firstnameTha))
                $err[] = 'กรุณากรอกชื่อ ภาษาไทย';
            if (empty($lastnameTha))
                $err[] = 'กรุณากรอกนามสกุล ภาษาไทย';
            if (empty($nameTitleEng))
                $err[] = 'กรุณาเลือกคำนำหน้าชื่อ';
            if (empty($firstnameEng))
                $err[] = 'กรุณากรอกชื่อ ภาษาอังกฤษ';
            if (empty($lastnameEng))
                $err[] = 'กรุณากรอกนามสกุล ภาษาอังกฤษ';
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
            if (count($err) > 0)
                $res['message'] = join('<br>', $err);
            else
            {
                if ($usersModel->update($this->userLogged['user_id'], [
                    'name_title_tha' => $nameTitleTha,
                    'firstname_tha' => $firstnameTha,
                    'lastname_tha' => $lastnameTha,
                    'fullname_tha' => $firstnameTha.' '.$lastnameTha,
                    'name_title_eng' => $nameTitleEng,
                    'firstname_eng' => $firstnameEng,
                    'lastname_eng' => $lastnameEng,
                    'fullname_eng' => $firstnameEng.' '.$lastnameEng,
                    'birth' => $birthYear.'-'.$birthMonth.'-'.$birthDate,
                    'mobile' => $mobile,
                    'address' => $address,
                    'sub_district' => $subDistrict,
                    'district' => $district,
                    'province' => $province,
                    'postal_code' => $postalCode
                ]))
                {
                    $res = [
                        'submit' => true,
                        'success' => true,
                        'message' => 'บันทึกการเปลี่ยนแปลงข้อมูลสำเร็จแล้ว'
                    ];
                }
                else $res['message'] = 'เกิดข้อผิดพลาดในการบันทึกการเปลี่ยนแปลงข้อมูล กรุณาลองใหม่อีกครั้ง';
            }
        }

        return $this->render('Account/' . __FUNCTION__, [
            'provinceList' => (new ProvinceModel)->orderBy('name', 'ASC')->findAll(),
            'res' => $res,
            'dateExtension' => new Date,
        ]);
    }

    public function ChangePassword()
    {
        if (!session()->get('LOGGED_IN'))
            return redirect()->to('/');

        $res = ['submit' => false, 'success' => false, 'message' => ''];
        $form = $this->request->getPost();
        if (!empty($form))
        {
            $res['submit'] = true;
            $curPassword = $form['curPassword'];
            $newPassword = $form['newPassword'];
            $cnfPassword = $form['cnfPassword'];

            $usersModel = new UsersModel;
            $user = $usersModel->find($this->userLogged['user_id']);
            $err = [];
            if (empty($curPassword))
                $err[] = 'กรุณากรอกรหัสผ่านเดิม';
            if (!password_verify($curPassword, $user['login_pwd']))
                $err[] = 'รหัสผ่านเดิมไม่ถูกต้อง';
            unset($user['login_pwd']);
            if (empty($newPassword) || strlen($newPassword) < 8)
                $err[] = 'กรุณากรอกรหัสผ่านใหม่อย่างน้อย 8 อักขระขึ้นไป';
            if (!preg_match("/^[a-zA-Z0-9]+$/", $newPassword))
                $err[] = 'รหัสผ่านต้องเป็นอักขระ a-z, A-Z, 0-9 เท่านั้น';
            if ($curPassword === $newPassword)
                $err[] = 'รหัสผ่านใหม่ต้องไม่เหมือนกับรหัสผ่านเดิม';
            if (empty($cnfPassword))
                $err[] = 'กรุณากรอกการยืนยันรหัสผ่านใหม่';
            if ($newPassword !== $cnfPassword)
                $err[] = 'การยืนยันรหัสผ่านใหม่ไม่ถูกต้อง';
            if (count($err) > 0)
                $res['message'] = join('<br>', $err);
            else
            {
                if ($usersModel->update($this->userLogged['user_id'], ['login_pwd' => password_hash($newPassword, PASSWORD_BCRYPT, ['cost' => 12])]))
                {
                    $res = [
                        'submit' => true,
                        'success' => true,
                        'message' => 'เปลี่ยนรหัสผ่านใหม่สำเร็จแล้ว'
                    ];
                }
                else $res['message'] = 'เกิดข้อผิดพลาดในการเปลี่ยนรหัสผ่าน กรุณาลองใหม่อีกครั้ง';
            }
        }

        return $this->render('Account/' . __FUNCTION__, ['res' => $res]);
    }
}
