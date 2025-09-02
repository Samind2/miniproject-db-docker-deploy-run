<?php
/* Shaoransoft Developer */
namespace App\Controllers\Api;

use CodeIgniter\API\ResponseTrait;

use App\Models\FacultyModel;

class FacultyApi extends ApiController
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
            'name_tha',
            'name_eng',
            'branch_nums',
            null
        ];

        $facultyModel = (new FacultyModel)->select('faculty.*,'
            .'(select count(*) from branch where branch.faculty_id = faculty.faculty_id) as branch_nums,'
            .'row_number() over (order by faculty.name_tha) row_num')
            ->groupStart()
                ->Like('name_tha', $searchValue)
                ->orLike('name_eng', $searchValue)
            ->groupEnd()
            ->orderBy($columns[array_key_exists($orderColumn, $columns) ? $orderColumn : 0], $orderDir);
        $facultyList = $facultyModel->findAll($length, $start);
        $numRows = $facultyModel->countAllResults();
        $res = [
            'draw' => $req['draw'] ?? 1,
            'recordsTotal' => $numRows,
            'recordsFiltered' => $numRows
        ];
        foreach ($facultyList as $faculty)
        {
            $res['data'][] = [
                $faculty['row_num'],
                $faculty['name_tha'],
                $faculty['name_eng'],
                number_format($faculty['branch_nums'], 0),
                null,
                $faculty['faculty_id'],
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
            $faculty = (new FacultyModel)->find($id);
            return $this->respondSuccess('success', $faculty);
        }
        catch (\Exception $e)
        {
            return $this->respondError($e->getMessage());
        }
    }

    public function Create()
    {
        if (!session()->get('LOGGED_IN'))
            return $this->unauthorized();
        if ($this->userLogged['user_level'] != 'ADMINISTRATOR')
            return $this->unauthorized();

        $form = $this->request->getPost();
        if (empty($form))
            return $this->respondError('กรุณากรอกแบบฟอร์ม');
        $nameTha = $form['nameTha'];
        $nameEng = $form['nameEng'];

        $facultyModel = new FacultyModel;
        $err = [];
        if (empty($nameTha))
            $err[] = 'กรุณากรอกชื่อภาษาไทย';
        if (empty($nameEng))
            $err[] = 'กรุณากรอกชื่อภาษาอังกฤษ';
        if (count($err) > 0)
            return $this->respondError(join('<br>', $err));
        if ($facultyModel->insert([
            'name_tha' => $nameTha,
            'name_eng' => $nameEng
        ])) return $this->respondSuccess('เพิ่มข้อมูลเรียบร้อยแล้ว');
        return $this->respondError('เกิดข้อผิดพลาดในการเพิ่มข้อมูล กรุณาลองใหม่อีกครั้ง');
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
        $facultyId = $form['facultyId'];
        $nameTha = $form['nameTha'];
        $nameEng = $form['nameEng'];

        $facultyModel = new FacultyModel;
        $faculty = $facultyModel->find($facultyId);
        if (empty($faculty))
            return $this->respondError('ไม่พบข้อมูลคณะ');
        $err = [];
        if (empty($nameTha))
            $err[] = 'กรุณากรอกชื่อภาษาไทย';
        if (empty($nameEng))
            $err[] = 'กรุณากรอกชื่อภาษาอังกฤษ';
        if (count($err) > 0)
            return $this->respondError(join('<br>', $err));
        if ($facultyModel->update($facultyId, [
            'name_tha' => $nameTha,
            'name_eng' => $nameEng
        ])) return $this->respondSuccess('บันทึกการเปลี่ยนแปลงข้อมูลเรียบร้อยแล้ว');
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

        $facultyModel = new FacultyModel;
        $faculty = $facultyModel->find($id);
        if (empty($faculty))
            return $this->respondError('ไม่พบข้อมูลคณะ');
        if ($facultyModel->delete($id))
            return $this->respondSuccess('ลบข้อมูลสำเร็จแล้ว');
        return $this->respondError('ไม่สามารถลบข้อมูลได้ กรุณาลองใหม่อีกครั้ง');
    }
}