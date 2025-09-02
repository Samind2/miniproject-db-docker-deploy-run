<?php
/* Shaoransoft Developer */
namespace App\Controllers;

use App\Models\ProvinceModel;
use App\Models\UsersModel;

use App\Extension\Date;

class Authorization extends BaseController
{
    public function Signin()
    {
        if (session()->get('LOGGED_IN'))
            return redirect()->to('/');

        $callback = $this->request->getVar('callback');
        $res = ['submit' => false, 'success' => false, 'message' => '', 'callback' => ''];
        $form = $this->request->getPost();
        if (!empty($form))
        {
            $res['submit'] = true;
            $callback = $form['callback'] ?? '';
            $username = $form['username'];
            $password = $form['password'];
            $err = [];
            if (empty($username))
                $err[] = 'กรุณากรอกอีเมลของท่าน';
            if (empty($password))
                $err[] = 'กรุณากรอกรหัสผ่าน';
            if (count($err) > 0)
                $res['message'] = join('<br>', $err);
            else
            {
                $user = (new UsersModel())->where('email', $username)->first();
                if ($user)
                {
                    if (password_verify($password, $user['login_pwd']))
                    {
                        unset($user['login_pwd']);
                        if ($user['authorized'] == 'TRUE')
                        {
                            $session = session();
                            $session->set([
                                'LOGGED_IN' => true,
                                'LOGGED_TIME' => time(),
                                'UID' => base64_encode($user['user_id'])
                            ]);
                            $res = [
                                'submit' => true,
                                'success' => true,
                                'message' => 'ยินดีต้อนรับคุณ '.$user['fullname_tha']
                            ];
                        }
                        else $res['message'] = 'บัญชีผู้ใช้ไม่ได้รับอนุญาตใช้งาน กรุณาติดต่อทางเจ้าหน้าที่';
                    }
                    else $res['message'] = 'รหัสผ่านไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง';
                }
                else $res['message'] = 'เลขที่บัตรประชาชนไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง';
            }
        }

        return $this->render('Authorization/' . __FUNCTION__, [
            'res' => $res,
            'callback' => $callback
        ]);
    }

    public function Signup()
    {
        if (session()->get('LOGGED_IN'))
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
            $idCard = $form['idCard'];
            $password = $form['password'];
            $mobile = $form['mobile'];
            $email = $form['email'];
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
            if (empty($idCard) || strlen($idCard) != 13)
                $err[] = 'กรุณากรอกเลขที่บัตรประชาชน';
            if (!preg_match("/^[0-9]+$/", $idCard))
                $err[] = 'รูปแบบเลขที่บัตรประชาชนไม่ถูกต้อง';
            if ($usersModel->where('id_card', $idCard)->countAllResults() > 0)
                $err[] = 'เลขที่บัตรประชาชนดังกล่าวถูกลงทะเบียนไว้แล้ว';
            if (empty($password) || strlen($password) < 8)
                $err[] = 'กรุณากรอกรหัสผ่านอย่างน้อย 8 อักขระขึ้นไป';
            if (!preg_match("/^[a-zA-Z0-9]+$/", $password))
                $err[] = 'รหัสผ่านต้องเป็นอักขระ a-z, A-Z, 0-9 เท่านั้น';
            if (empty($mobile) || strlen($mobile) != 10)
                $err[] = 'กรุณากรอกเบอร์มือถือ';
            if (!preg_match("/^0[0-9]{9}$/", $mobile))
                $err[] = 'รูปแบบเบอร์มือถือไม่ถูกต้อง';
            if (empty($email))
                $err[] = 'กรุณากรอกอีเมล';
            if (!filter_var($email, FILTER_VALIDATE_EMAIL))
                $err[] = 'รูปแบบอีเมลไม่ถูกต้อง';
            if ($usersModel->where('email', $email)->countAllResults() > 0)
                $err[] = 'อีเมลดังกล่าวถูกลงทะเบียนไว้แล้ว';
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
                if ($usersModel->insert([
                    'user_level' => 'USER',
                    'login_pwd' => password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]),
                    'authorized' => 'TRUE',
                    'name_title_tha' => $nameTitleTha,
                    'firstname_tha' => $firstnameTha,
                    'lastname_tha' => $lastnameTha,
                    'fullname_tha' => $firstnameTha.' '.$lastnameTha,
                    'name_title_eng' => $nameTitleEng,
                    'firstname_eng' => $firstnameEng,
                    'lastname_eng' => $lastnameEng,
                    'fullname_eng' => $firstnameEng.' '.$lastnameEng,
                    'id_card' => $idCard,
                    'birth' => $birthYear.'-'.$birthMonth.'-'.$birthDate,
                    'email' => $email,
                    'mobile' => $mobile,
                    'address' => $address,
                    'sub_district' => $subDistrict,
                    'district' => $district,
                    'province' => $province,
                    'postal_code' => $postalCode,
                    'register' => date('Y-m-d H:i:s')
                ]))
                {
                    $res = [
                        'submit' => true,
                        'success' => true,
                        'message' => 'การลงทะเบียนสำเร็จแล้ว'
                    ];
                }
                else $res['message'] = 'เกิดข้อผิดพลาดในการบันทึกข้อมูลลงทะเบียน กรุณาลองใหม่อีกครั้ง';
            }
        }

        return $this->render('Authorization/' . __FUNCTION__, [
            'provinceList' => (new ProvinceModel)->orderBy('name', 'ASC')->findAll(),
            'form' => $form,
            'res' => $res,
            'dateExtension' => new Date,
        ]);
    }

    public function Signout()
    {
        $session = session();
        $session->destroy();
        return $this->render('Authorization/' . __FUNCTION__, [], false, false);
    }
}
