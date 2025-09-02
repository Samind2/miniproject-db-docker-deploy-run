<?php
/* Shaoransoft Developer */
namespace App\Controllers\Api;

use CodeIgniter\API\ResponseTrait;

use App\Models\UsersModel;

class UserApi extends ApiController
{
    use ResponseTrait;

    public function GetDT()
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
            'fullname_tha',
            'id_card',
            'email',
            'mobile',
            'user_level',
            'authorized',
            null
        ];

        $usersModel = (new UsersModel)->select('users.*,'
            .'row_number() over (order by users.user_id) row_num')
            ->groupStart()
                ->like('fullname_tha', $searchValue)
                ->orLike('id_card', $searchValue)
                ->orLike('email', $searchValue)
                ->orLike('mobile', $searchValue)
            ->groupEnd()
            ->orderBy($columns[array_key_exists($orderColumn, $columns) ? $orderColumn : 0], $orderDir);
        $userList = $usersModel->findAll($length, $start);
        $numRows = $usersModel->countAllResults();
        $res = [
            'draw' => $req['draw'] ?? 1,
            'recordsTotal' => $numRows,
            'recordsFiltered' => $numRows
        ];
        foreach ($userList as $user)
        {
            $res['data'][] = [
                $user['row_num'],
                $user['name_title_tha'].' '.$user['fullname_tha'],
                $user['id_card'],
                $user['email'],
                $user['mobile'],
                $user['user_level'],
                $user['authorized'],
                null,
                $user['user_id'],
            ];
        }

        return $this->respond($res);
    }

    public function Get($id = null)
    {
        if (!session()->get('LOGGED_IN'))
            return $this->unauthorized();
        if ($this->userLogged['user_level'] != 'ADMINISTRATOR')
            return $this->unauthorized();
        if (empty($id))
            return $this->respondError('ไม่พบไอดีอ้างอิง');
        try
        {
            $user = (new UsersModel)->find($id);
            unset($user['login_pwd']);
            return $this->respondSuccess('success', $user);
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
        if ($this->userLogged['user_level'] != 'ADMINISTRATOR')
            return $this->unauthorized();

        $form = $this->request->getPost();
        if (empty($form))
            return $this->respondError('กรุณากรอกแบบฟอร์ม');
        $userId = $form['userId'];
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
        $email = $form['email'];
        $address = $form['address'];
        $province = $form['province'];
        $district = $form['district'];
        $subDistrict = $form['subDistrict'];
        $postalCode = $form['postalCode'];
        $userLevel = $form['userLevel'];
        $password = $form['password'];
        $authorized = $form['authorized'] ?? 'FALSE';

        $usersModel = new UsersModel;
        $user = $usersModel->find($userId);
        if (empty($user))
            return $this->respondError('ไม่พบข้อมูลผู้ใช้งาน');
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
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            $err[] = 'รูปแบบอีเมลไม่ถูกต้อง';
        if ($usersModel->where(['user_id !=' => $userId, 'email' => $email])->countAllResults() > 0)
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
        if (!empty($password) && strlen($password) < 8)
            $err[] = 'กรุณากรอกรหัสผ่านอย่างน้อย 8 อักขระขึ้นไป';
        if (!empty($password) && !preg_match("/^[a-zA-Z0-9]+$/", $password))
            $err[] = 'รหัสผ่านต้องเป็นอักขระ a-z, A-Z, 0-9 เท่านั้น';
        if (count($err) > 0)
            return $this->respondError(join('<br>', $err));
        $update = [
            'user_level' => $userLevel,
            'authorized' => $authorized,
            'name_title_tha' => $nameTitleTha,
            'firstname_tha' => $firstnameTha,
            'lastname_tha' => $lastnameTha,
            'fullname_tha' => $firstnameTha.' '.$lastnameTha,
            'name_title_eng' => $nameTitleEng,
            'firstname_eng' => $firstnameEng,
            'lastname_eng' => $lastnameEng,
            'fullname_eng' => $firstnameEng.' '.$lastnameEng,
            'birth' => $birthYear.'-'.$birthMonth.'-'.$birthDate,
            'email' => $email,
            'mobile' => $mobile,
            'address' => $address,
            'sub_district' => $subDistrict,
            'district' => $district,
            'province' => $province,
            'postal_code' => $postalCode
        ];
        if (!empty($password))
            $update['login_pwd'] = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
        if ($usersModel->update($userId, $update))
            return $this->respondSuccess('บันทึกการเปลี่ยนแปลงข้อมูลเรียบร้อยแล้ว');
        return $this->respondError('เกิดข้อผิดพลาดในการบันทึกข้อมูล กรุณาลองใหม่อีกครั้ง');
    }

    public function Delete($id = null)
    {
        if (!session()->get('LOGGED_IN'))
            return $this->unauthorized();
        if ($this->userLogged['user_level'] != 'ADMINISTRATOR')
            return $this->unauthorized();
        if (empty($id))
            return $this->respondError('ไม่พบไอดีอ้างอิง');

        $usersModel = new UsersModel;
        $user = $usersModel->find($id);
        if (empty($user))
            return $this->respondError('ไม่พบข้อมูลผู้ใช้งาน');
        if ($usersModel->delete($id))
            return $this->respondSuccess('ลบข้อมูลสำเร็จแล้ว');
        return $this->respondError('ไม่สามารถลบข้อมูลได้ กรุณาลองใหม่อีกครั้ง');
    }
}