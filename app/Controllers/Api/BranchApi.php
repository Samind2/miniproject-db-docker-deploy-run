<?php
/* Shaoransoft Developer */
namespace App\Controllers\Api;

use CodeIgniter\API\ResponseTrait;

use App\Models\BranchModel;
use App\Models\FacultyModel;

class BranchApi extends ApiController
{
    use ResponseTrait;

    public function GetDT($id = null)
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
            'branch.code',
            'branch.name_tha',
            'branch.name_eng',
            null
        ];

        $branchModel = (new BranchModel)->select('branch.*,'
            .'row_number() over (order by branch.name_tha) row_num')
            ->where('branch.faculty_id', $id)
            ->groupStart()
                ->Like('branch.code', $searchValue)
                ->orLike('branch.name_tha', $searchValue)
                ->orLike('branch.name_eng', $searchValue)
            ->groupEnd()
            ->orderBy($columns[array_key_exists($orderColumn, $columns) ? $orderColumn : 0], $orderDir);
        $branchList = $branchModel->findAll($length, $start);
        $numRows = $branchModel->countAllResults();
        $res = [
            'draw' => $req['draw'] ?? 1,
            'recordsTotal' => $numRows,
            'recordsFiltered' => $numRows
        ];
        foreach ($branchList as $branch)
        {
            $res['data'][] = [
                $branch['row_num'],
                $branch['code'],
                $branch['name_tha'],
                $branch['name_eng'],
                null,
                $branch['branch_id'],
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
            $branch = (new BranchModel)->find($id);
            return $this->respondSuccess('success', $branch);
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
        $faculty = $form['faculty'];
        $code = $form['code'];
        $nameTha = $form['nameTha'];
        $nameEng = $form['nameEng'];

        $branchModel = new BranchModel;
        $err = [];
        if (empty($faculty))
            $err[] = 'กรุณาเลือกสังกัดภายใต้คณะ';
        if ((new FacultyModel)->where('faculty_id', $faculty)->countAllResults() == 0)
            $err[] = 'ไม่พบข้อมูลคณะ';
        if (empty($code))
            $err[] = 'กรุณากรอกรหัสสาขาวิชา';
        if ($branchModel->where('code', $code)->countAllResults() > 0)
            $err[] = 'รหัสสาขาวิชาดังกล่าวมีในระบบแล้ว';
        if (empty($nameTha))
            $err[] = 'กรุณากรอกชื่อภาษาไทย';
        if (empty($nameEng))
            $err[] = 'กรุณากรอกชื่อภาษาอังกฤษ';
        if (count($err) > 0)
            return $this->respondError(join('<br>', $err));
        if ($branchModel->insert([
            'faculty_id' => $faculty,
            'code' => $code,
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
        $branchId = $form['branchId'];
        $faculty = $form['faculty'];
        $code = $form['code'];
        $nameTha = $form['nameTha'];
        $nameEng = $form['nameEng'];

        $branchModel = new BranchModel;
        $branch = $branchModel->find($branchId);
        if (empty($branch))
            return $this->respondError('ไม่พบข้อมูลสาขาวิชา');
        $err = [];
        if (empty($faculty))
            $err[] = 'กรุณาเลือกสังกัดภายใต้คณะ';
        if ((new FacultyModel)->where('faculty_id', $faculty)->countAllResults() == 0)
            $err[] = 'ไม่พบข้อมูลคณะ';
        if (empty($code))
            $err[] = 'กรุณากรอกรหัสสาขาวิชา';
        if ($branchModel->where(['branch_id !=' => $branchId, 'code' => $code])->countAllResults() > 0)
            $err[] = 'รหัสสาขาวิชาดังกล่าวมีในระบบแล้ว';
        if (empty($nameTha))
            $err[] = 'กรุณากรอกชื่อภาษาไทย';
        if (empty($nameEng))
            $err[] = 'กรุณากรอกชื่อภาษาอังกฤษ';
        if (count($err) > 0)
            return $this->respondError(join('<br>', $err));
        if ($branchModel->update($branchId, [
            'faculty_id' => $faculty,
            'code' => $code,
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

        $branchModel = new BranchModel;
        $branch = $branchModel->find($id);
        if (empty($branch))
            return $this->respondError('ไม่พบข้อมูลสาขาวิชา');
        if ($branchModel->delete($id))
            return $this->respondSuccess('ลบข้อมูลสำเร็จแล้ว');
        return $this->respondError('ไม่สามารถลบข้อมูลได้ กรุณาลองใหม่อีกครั้ง');
    }
}