<?php
/* Shaoransoft Developer */
namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

use App\Models\UsersModel;

class ApiController extends ResourceController
{
    use ResponseTrait;

    protected $userLogged = [];

    function __construct()
    {
        if (session()->get('LOGGED_IN'))
        {
            $userLogged = (new UsersModel)->where('user_id', base64_decode(session()->get('UID')))->first();
            if ($userLogged)
            {
                unset($userLogged['login_pwd']);
                $this->userLogged = $userLogged;
            }
        }
    }

    protected function unauthorized()
    {
        $output = $this->format([
            'status' => 401,
            'error' => 401,
            'messages' => [
                'error' => 'Unauthorized'
            ]
        ]);
        return $this->response->setJSON($output)->setStatusCode(401);
    }

    protected function respondError(string $message = '')
    {
        return $this->response->setJSON(['success' => false, 'message' => $message]);
    }

    protected function respondSuccess(string $message = '', array $data = null)
    {
        $response = ['success' => true, 'message' => $message];
        if (!empty($data)) $response['data'] = $data;
        return $this->response->setJSON($response);
    }
}
