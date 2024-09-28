<?php
namespace App\Controller\Api;

use App\Controller\Api\AppController;
use Firebase\JWT\JWT;

class UsersController extends AppController
{
    public $paginate = [
        'page' => 1,
        'limit' => 5,
        'maxLimit' => 15,
        'sortWhitelist' => [
            'id', 'name'
        ]
    ];

    public function initialize(): void
    {
        parent::initialize();

        $this->Authentication->allowUnauthenticated(['token']);

    }


    public function token()
    {


        $result = $this->Authentication->getResult();
        if ($result->isValid()) {
            $privateKey = file_get_contents(CONFIG . '/jwt.key');
            $user = $result->getData();
            $payload = [
                'iss' => 'myapp',
                'sub' => $user->id,
                'exp' => time() + 60
//                    60*60*24,  add this for 24 hours valid token      by nik
            ];
            $json = [
                'token' => JWT::encode($payload, $privateKey, 'RS256'),
            ];
            $this->set(compact('json'));
            $this->set([
                'success' => true,
                'data' => $json,
                '_serialize' => ['success', 'data']
            ]);
        } else {
            $this->response = $this->response->withStatus(401);
            $json = [];
            $this->set(compact('json'));
            $this->set([
                'success' => false,
                'data' => ['error_code'=>-1001, 'error_message'=>'Invalid username and password'],
                '_serialize' => ['success', 'data']
            ]);
        }

        //  $this->viewBuilder()->setOption('serialize', 'json');
    }


}
