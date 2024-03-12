<?php
/**
 * Name:    Global Model
 * Author:  elektra
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Global Model
 */
class Transmisi_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function create_breadcrumbs($arr)
	{
		$item ='<div class="d-flex align-items-baseline flex-wrap mr-5">
				<h5 class="text-dark font-weight-bold my-1 mr-5">e-Transmisi</h5>
				<ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">';
		foreach($arr as $key =>$v){
			if(count($arr)-1 !== $key){
				$item .= '<li class="breadcrumb-item"><a href="#" class="text-muted">'.$v.'</a></li>';
			}else{
				$item .= '<li class="breadcrumb-item"><a href="#" class="text-muted">'.$v.'</a></li>';
			}
		}
		$str = $item."</ul></div>";
		return $str;
	}
	
		public function get_lokasi($idlokasi)
	{
		
		$query = $this->db->query("select * from ms_lokasi_tvri where idlokasi= $idlokasi");
		if ($query->num_rows() > 0){
			return $query->row();
		}
		return null;
	}
	
	
}