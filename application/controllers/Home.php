<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
	var $db_conf;
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->model('Global_model');
		$head['collapse'] = false;
		$head['title'] = "Home";
		$data['breadcrumbs'] = $this->Global_model->create_breadcrumbs(["Master", "Wilayah"]);
		$this->load->view('layout/header', $head);
		$this->load->view('layout/sidebar');
		$this->load->view('blank', $data);
		$this->load->view('layout/footer');
	}

	public function grid()
	{
		$this->db_conf = array(
			'type' => $this->db->dbdriver,
			'server' => $this->config->item('con_svr'),
			'user' => $this->db->username,
			'password' => $this->db->password,
			'database' => $this->db->database
		);
		$this->load->library('gridlibrary');
		$g = new jqgrid($this->db_conf);
		$caps = "Satuan";

		$grid["caption"] = $caps;
		$grid["rowNum"] = 20;
		$grid["rowList"] = array(20, 40, 100, 'All');
		$grid["rownumbers"] = true;
		// $grid["sortname"] = 'idsatuan'; 
		$grid["autowidth"] = true;
		$grid["shrinkToFit"] = true;
		$grid["forceFit"] = false;
		$grid["resizable"] = true;
		$grid["autoresize"] = false;
		$grid["multiselect"] = false;
		$grid["toolbar"] = "buttom";
		$grid["add_options"] = array("width" => "400");
		$grid["edit_options"] = array("width" => "400");
		$grid["view_options"] = array("width" => "400");
		$grid["export"] = array("format" => "xls", "filename" => $this->file_name, "sheetname" => "master-kategoriuji");

		$g->set_actions(
			array(
				"add" => true,
				"edit" => true,
				"delete" => true,
				"rowactions" => false,
				"export" => true,
				"autofilter" => true,
				"search" => "advance"
			)
		);

		$g->select_command = "SELECT * FROM auth_users";
		$g->table = "auth_users";


		// $g->set_columns($cols);
		$g->set_options($grid);


		$data['gridout'] = $g->render("list1");
		$this->load->model('Global_model');
		$head['collapse'] = false;
		$head['title'] = "Home";
		$data['breadcrumbs'] = $this->Global_model->create_breadcrumbs(["Contoh", "Grid"]);
		$this->load->view('layout/header', $head);
		$this->load->view('layout/sidebar');
		$this->load->view('grid_master', $data);
		$this->load->view('layout/footer');
	}
}
