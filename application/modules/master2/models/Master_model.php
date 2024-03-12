<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Global Model
 */
class Master_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	function get_crud_priv($debug=false){
		$str = "SELECT * FROM (
			SELECT id,idmenu,idgroup,crud_option FROM app_menu_priv WHERE idgroup IN (1,6) AND idmenu=15
		) rpt 
		WHERE 1=1";
		if($debug)
			return $str;
		else{
			$qry = $this->db->query($str);
			if ($qry->num_rows() > 0){
				return $qry->result();
			}
			return null;
		}
	}
	
}