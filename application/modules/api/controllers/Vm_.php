<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//1. include library
require 'Base_Controller.php';

//2. extends REST_Controller
class Vm extends Base_Controller{
    
    function __construct($config = 'rest') {
        parent::__construct($config);
    }

    function index_get(){
        $info = [
            'version' => '0.1-dev',
            'name' => 'API TVRI'
        ];
        $this->response($info);
    }

    public function login_post() {
        error_reporting(E_ERROR);
        $this->ion_auth_model->identity_column = 'phone';
        $phone = $this->input->post('phone');
        $device_id = $this->post('device_id');
        if ($this->ion_auth->login($phone, $this->input->post('password'))) {
            $this->load->model('users_model', 'user');
            $user = $this->user->find_by_phone($phone);
            $token = "";
            $token = $user['token'];
            if($token == "" or $token == NULL){
                $token = md5(rand(0, 10000000));
                $this->ion_auth->update($user['id'], [
                    'token' => $token,
                'device_id' => $device_id
                ]);
            }
            $this->ion_auth->update($user['id'], 
            ['device_id' => $device_id
            ]);

            $this->response($user);
        } else {
            $error_messages = $this->ion_auth->errors();
            $this->response($error_messages, REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}