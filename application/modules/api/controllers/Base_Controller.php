<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Base_Controller extends REST_Controller {

    var $roles = [];
    var $role_check = [];
    var $is_secure = false;
    public $user_id;
    public $idgroup;

    function __construct($config = 'rest', $secure = FALSE) {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: POST,GET");
        header('Access-Control-Allow-Headers: Authorization');
        parent::__construct($config);
        $this->is_secure = $secure;
        //apakah secure?
        if ($this->is_secure == TRUE) {
            //token
            $token = $this->input->get_request_header('Authorization', TRUE);
            if (!$token) {
                $token = $this->input->get('token');
                if (!$token) {
                    $this->response('token tidak ada atau tidak valid', REST_Controller::HTTP_FORBIDDEN);
                }
            }
            //iddevice
            /*
            $iddevice = $this->post('iddevice', TRUE) != NULL ? $this->post('iddevice', TRUE) : $this->get('iddevice', TRUE);
            if (!$iddevice) {
                $this->response("access denied", REST_Controller::HTTP_FORBIDDEN);
            }*/
            //cek token
            $this->load->model('users_model', 'user');
            $user = $this->user->find_by_token($token);
            if (!$user) {
                $this->response('token tidak ada atau tidak valid', REST_Controller::HTTP_FORBIDDEN);
            }
            $this->user_id = $user['id'];
            $this->idgroup = $user['idgroup'];
            //get role
            /*
              $user = $this->user->id_user_by_token($token);
              if ($user) {
              $user_roles = $this->ion_auth->get_users_groups($user['id'])->result_array();
              foreach ($user_roles as $role) {
              $this->roles[] = $role['name'];
              }
              } else {
              $this->response('data user tidak valid', REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
              } */
/*
            $iddevice_user = $user['iddevice'];
            if (!$iddevice_user) {
                $this->response("invalid device", REST_Controller::HTTP_FORBIDDEN);
            }

            if ($iddevice != $iddevice_user) {
                $this->response("invalid credential", REST_Controller::HTTP_FORBIDDEN);
            }*/
        }
    }

    private function role_check() {
        foreach ($this->role_check as $key => $value) {
            if (in_array($value, $this->roles)) {
                return TRUE;
            }
        }
        return FALSE;
    }

    protected function is_authorized($roles = []) {
        if ($this->is_secure == TRUE) {
            $this->role_check = $roles;
            if ($this->role_check() === FALSE) {
                $this->response('anda tidak berhak mengakses halaman ini', REST_Controller::HTTP_UNAUTHORIZED);
            }
        }
    }

    function save_post() {
        if ($this->model->run_validation()) {
            $id = $this->model->save();
            if ($id) {
                $this->response($id, REST_Controller::HTTP_CREATED);
            } else {
                $this->response($id, REST_Controller::HTTP_BAD_REQUEST);
            }
        } else {
            $this->response($this->model->validation_errors, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    function update_post() {
        if ($this->model->run_validation()) {
            $id = $this->post('id');
            $res = $this->model->save($id);
            if ($res) {
                $this->response($id, REST_Controller::HTTP_OK);
            } else {
                $this->response($id, REST_Controller::HTTP_BAD_REQUEST);
            }
        } else {
            $this->response($this->model->validation_errors, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    function delete_post() {
        //$this->is_authorized(['admin']);
        $id = $this->post('id');
        $res = $this->model->delete($id);
        $this->response($res, REST_Controller::HTTP_OK);
    }

    function index_get() {
        //$this->is_authorized(['admin']);
        $res = $this->model->get()->result_array();
        if ($res) {
            $this->response($res, REST_Controller::HTTP_OK);
        } else {
            $this->response($res, REST_Controller::HTTP_OK);
        }
    }

    function byid_get() {
        //$this->is_authorized(['admin']);
        $id = $this->get('id');
        $res = $this->model->get_by_id($id);
        if ($res) {
            $this->response($res, REST_Controller::HTTP_OK);
        } else {
            $this->response($res, REST_Controller::HTTP_OK);
        }
    }

    function __destruct() {
        //log_message('DEBUG', $this->db->last_query());
    }

}
