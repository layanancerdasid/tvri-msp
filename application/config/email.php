<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
| ------------------------------------------------------------------- 
| EMAIL CONFING 
| ------------------------------------------------------------------- 
| Configuration of outgoing mail server. 
| */

$config['protocol'] = 'smtp';
$config['smtp_host'] = 'ssl://smtp.googlemail.com';  
$config['smtp_port'] = '465';  
$config['smtp_timeout'] = '30';  
$config['smtp_user'] = 'ippl.kominfo@gmail.com';  
$config['smtp_pass'] = 'hvqrfnmkzvxznjxf';
$config['charset'] = 'iso-8859-1';
$config['mailtype'] = 'html';
$config['wordwrap'] = TRUE;
$config['newline'] = "\r\n";

/* End of file email.php */  
/* Location: ./system/application/config/email.php */