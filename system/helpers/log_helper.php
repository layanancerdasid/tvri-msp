<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function helper_log($log_user, $log_tipe = "", $log_aksi = "", $log_item= ""){
    $CI =& get_instance();
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
   // paramter
    $param['log_user']      = $CI->session->userdata('username');
    $param['log_tipe']      = $log_tipe;
    $param['log_user']      = ($param['log_user'])? $param['log_user']:$log_user;
	$param['log_item']      = $log_item;
	$param['log_aksi']      = $log_aksi;
    $param['ip_address']      = $ipaddress;;
    //load model log
    $CI->load->model('log_model','m_log');
 
    //save to database
    $CI->m_log->save_log($param);
 
}

?>