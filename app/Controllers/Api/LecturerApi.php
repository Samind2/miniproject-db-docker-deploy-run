<?php
/* Shaoransoft Developer */
namespace App\Controllers\Api;

use CodeIgniter\API\ResponseTrait;

use App\Models\LecturerModel;
use App\Models\BranchModel;
use App\Models\CourseLecturerModel;

use App\ViewModels\LecturerViewModel;

class LecturerApi extends ApiController
{
    use ResponseTrait;

    public function GetDT()
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
            'lecturer.image',
            'lecturer.fullname',
            'lecturer.is_internal',
            'branch.name_tha',
            null
        ];

        $lecturerModel = (new LecturerModel)->select('lecturer.*,'
            .'branch.name_tha as branch_name_tha,'
            .'row_number() over (order by lecturer.modified) row_num')
            ->join('branch', 'branch.branch_id = lecturer.branch_id', 'left')
            ->groupStart()
                ->like('lecturer.fullname', $searchValue)
                ->orLike('branch.name_tha', $searchValue)
            ->groupEnd()
            ->orderBy($columns[array_key_exists($orderColumn, $columns) ? $orderColumn : 0], $orderDir);
        $lecturerList = $lecturerModel->findAll($length, $start);
        $numRows = $lecturerModel->join('branch', 'branch.branch_id = lecturer.branch_id', 'left')
            ->groupStart()
                ->like('lecturer.fullname', $searchValue)
                ->orLike('branch.name_tha', $searchValue)
            ->groupEnd()
            ->countAllResults();
        $res = [
            'draw' => $req['draw'] ?? 1,
            'recordsTotal' => $numRows,
            'recordsFiltered' => $numRows
        ];
        foreach ($lecturerList as $lecturer)
        {
            $res['data'][] = [
                $lecturer['row_num'],
                $lecturer['image'],
                $lecturer['fullname'],
                $lecturer['is_internal'],
                $lecturer['branch_name_tha'],
                null,
                $lecturer['lecturer_id'],
                $lecturer['url']
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
            $lecturer = (new LecturerModel)->find($id);
            return $this->respondSuccess('success', $lecturer);
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
        if (!in_array($this->userLogged['user_level'], ['OFFICER','ADMINISTRATOR']))
            return $this->unauthorized();

        $form = $this->request->getPost();
        if (empty($form))
            return $this->respondError('กรุณากรอกแบบฟอร์ม');
        $firstname = $form['firstname'];
        $lastname = $form['lastname'];
        $url = $form['url'];
        $isInternal = $form['isInternal'];
        $branch = $form['branch'];
        $image = $this->request->getFile('image');

        $fileImage = LecturerViewModel::$fileImage;

        $err = [];
        if (empty($firstname))
            $err[] = 'กรุณากรอกชื่อวิทยากร';
        if (empty($lastname))
            $err[] = 'กรุณากรอกนามสกุลวิทยากร';
        if (empty($isInternal))
            $err[] = 'กรุณาเลือกประเภทวิทยากร';
        if (empty($branch))
            $err[] = 'กรุณาเลือกสังกัด';
        if (empty((new BranchModel)->find($branch)))
            $err[] = 'ไม่พบข้อมูลสังกัด';
        if (!$image->isValid())
            $err[] = 'กรุณาอัปโหลดรูปภาพ';
        if (count($err) > 0)
            return $this->respondError(join('<br>', $err));
        if (!$this->validate([
            'image' => [
                'label' => 'Image File',
                'rules' => 'uploaded[image]'
                    .'|is_image[image]'
                    .'|mime_in[image,'.join(',', $fileImage['accept']).']'
                    .'|max_size[image,'.$fileImage['maxSize'].']'
            ]
        ])) return $this->respondError(join(',', $this->validator->getErrors()));
        $imageNewName = $image->getRandomName();
        $image->move($fileImage['path'], $imageNewName);
        if ((new LecturerModel)->insert([
            'branch_id' => $branch,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'fullname' => $firstname.' '.$lastname,
            'url' => $url,
            'is_internal' => $isInternal,
            'image' => $fileImage['path'].'/'.$imageNewName
        ])) return $this->respondSuccess('เพิ่มข้อมูลเรียบร้อยแล้ว');
        return $this->respondError('เกิดข้อผิดพลาดในการเพิ่มข้อมูล กรุณาลองใหม่อีกครั้ง');
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
        $lecturerId = $form['lecturerId'];
        $firstname = $form['firstname'];
        $lastname = $form['lastname'];
        $url = $form['url'];
        $isInternal = $form['isInternal'];
        $branch = $form['branch'];
        $image = $this->request->getFile('image');

        $fileImage = LecturerViewModel::$fileImage;
        $lecturersModel = new LecturerModel;
        $lecturer = $lecturersModel->find($lecturerId);
        if (empty($lecturer))
            return $this->respondError('ไม่พบข้อมูลวิทยากร');
        $err = [];
        if (empty($firstname))
            $err[] = 'กรุณากรอกชื่อวิทยากร';
        if (empty($lastname))
            $err[] = 'กรุณากรอกนามสกุลวิทยากร';
        if (empty($isInternal))
            $err[] = 'กรุณาเลือกประเภทวิทยากร';
        if (empty($branch))
            $err[] = 'กรุณาเลือกสาขาวิชา';
        if (empty((new BranchModel)->find($branch)))
            $err[] = 'ไม่พบข้อมูลสังกัด';
        if (count($err) > 0)
            return $this->respondError(join('<br>', $err));
        if ($image->isValid() && !$this->validate([
            'image' => [
                'label' => 'Image File',
                'rules' => 'uploaded[image]'
                    .'|is_image[image]'
                    .'|mime_in[image,'.join(',', $fileImage['accept']).']'
                    .'|max_size[image,'.$fileImage['maxSize'].']'
            ]
        ])) return $this->respondError(join(',', $this->validator->getErrors()));
        $updateData = [
            'branch_id' => $branch,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'fullname' => $firstname.' '.$lastname,
            'url' => $url,
            'is_internal' => $isInternal
        ];
        if ($image->isValid())
        {
            if ($lecturer['image'] !== '' && file_exists($lecturer['image']))
                unlink($lecturer['image']);
            $imageNewName = $image->getRandomName();
            $image->move($fileImage['path'], $imageNewName);
            $updateData['image'] = $fileImage['path'].'/'.$imageNewName;
        }
        if ($lecturersModel->update($lecturerId, $updateData))
            return $this->respondSuccess('บันทึกการเปลี่ยนแปลงข้อมูลเรียบร้อยแล้ว');
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

        $lecturersModel = new LecturerModel;
        $lecturer = $lecturersModel->find($id);
        if (empty($lecturer))
            return $this->respondError('ไม่พบข้อมูลวิทยากร');
        if ($lecturer['image'] !== '' && file_exists($lecturer['image']))
            unlink($lecturer['image']);
        (new CourseLecturerModel)->where('lecturer_id', $id)->delete();
        if ($lecturersModel->delete($id))
            return $this->respondSuccess('ลบข้อมูลสำเร็จแล้ว');
        return $this->respondError('ไม่สามารถลบข้อมูลได้ กรุณาลองใหม่อีกครั้ง');
    }
}