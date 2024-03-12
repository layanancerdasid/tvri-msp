<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master3 extends CI_Controller {
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
		$data['breadcrumbs'] = $this->Global_model->create_breadcrumbs(["Master","Wilayah"]);
		$this->load->view('layout/header',$head);
		$this->load->view('layout/sidebar');
		$this->load->view('blank',$data);
		$this->load->view('layout/footer');
	}

	public function lokasi()
	{
		$this->db_conf = array(
			'type' => $this->db->dbdriver,
			'server' => $this->config->item('con_svr'),
			'user' => $this->db->username,
			'password' => $this->db->password,
			'database' => $this->db->database);
		$this->load->library('gridlibrary');
		$g = new jqgrid($this->db_conf);
		$caps = "Lokasi";
		
		$grid["caption"] = $caps;
		$grid["rowNum"] = 20; 
		$grid["rowList"] = array(20,40,100,'All');
		$grid["rownumbers"] = true;
		// $grid["sortname"] = 'idsatuan'; 
		$grid["autowidth"] = true;
		$grid["shrinkToFit"] = true;
		$grid["forceFit"] = false;
		$grid["resizable"] = true;
		$grid["autoresize"] = false;
		$grid["multiselect"] = false; 
		$grid["toolbar"] = "buttom"; 
		$grid["add_options"] = array("width"=>"400");
		$grid["edit_options"] = array("width"=>"400");
		$grid["view_options"] = array("width"=>"400");
		$grid["export"] = array("format"=>"xls", "filename"=>$this->file_name, "sheetname"=>"master-kategoriuji");
		
		$g->set_actions(array(
				"add"=>true,
				"edit"=>true,
				"delete"=>true,
				"rowactions"=>false,
				"export"=>true,
				"autofilter" => true,
				"search" => "advance"
			)
		);
		
		$g->select_command = "SELECT * FROM ";
		$g->table = "ms_wilayah_layanan";
				
		
		// $g->set_columns($cols);
		$g->set_options($grid);

		
		$data['gridout'] = $g->render("list1");
		$this->load->model('Global_model');
		$head['collapse'] = false;
		$head['title'] = "Home";
		$data['breadcrumbs'] = $this->Global_model->create_breadcrumbs(["Master","Lokasi"]);
		$this->load->view('layout/header',$head);
		$this->load->view('layout/sidebar');
		$this->load->view('grid_master',$data);
		$this->load->view('layout/footer');
	}

	public function vendor()
	{
		$this->db_conf = array(
			'type' => $this->db->dbdriver,
			'server' => $this->config->item('con_svr'),
			'user' => $this->db->username,
			'password' => $this->db->password,
			'database' => $this->db->database);
		$this->load->library('gridlibrary');
		$g = new jqgrid($this->db_conf);
		$caps = "Vendor";
		
		$grid["caption"] = $caps;
		$grid["rowNum"] = 20; 
		$grid["rowList"] = array(20,40,100,'All');
		$grid["rownumbers"] = true;
		// $grid["sortname"] = 'idsatuan'; 
		$grid["autowidth"] = true;
		$grid["shrinkToFit"] = true;
		$grid["forceFit"] = false;
		$grid["resizable"] = true;
		$grid["autoresize"] = false;
		$grid["multiselect"] = false; 
		$grid["toolbar"] = "buttom"; 
		$grid["add_options"] = array("width"=>"400");
		$grid["edit_options"] = array("width"=>"400");
		$grid["view_options"] = array("width"=>"400");
		$grid["export"] = array("format"=>"xls", "filename"=>$this->file_name, "sheetname"=>"master-kategoriuji");
		
		$g->set_actions(array(
				"add"=>true,
				"edit"=>true,
				"delete"=>true,
				"rowactions"=>false,
				"export"=>true,
				"autofilter" => true,
				"search" => "advance"
			)
		);
		$g->select_command = "SELECT idvendor, nama, bentuk_usaha, npwp, no_pkp, alamat, idprovinsi, idkabupaten, telp, fax, email, website, created, iduser_created FROM ms_vendor";
		$g->table = "ms_vendor";
		
		
		$col = array();
		$col["title"] = "ID";
		$col["name"] = "idvendor";
		$col["editable"] = "idvendor";
		$col["hidden"] = true;
		$col["isnull"] = true;
		$col["autoid"] = true;
		$col["export"] = false;
		$col[] = $col;
		
		$col = array();
		$col["title"] = "Nama Vendor";
		$col["name"] = "nama";
		$col["search"] = true;
		$col["align"] = "center";
		$col["editable"] = true;
		$col["width"] = "200";
		$col["editrules"] = array("required"=>true);
		$col["editoptions"] = array("maxlength" => "40", "size"=>45, "placeholder"=>"Masukan Nama Vendor...");
		$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Bentuk Usaha";
		$col["name"] = "bentuk_usaha";
		$col["search"] = true;
		$col["align"] = "center";
		$col["editable"] = true;
		$col["width"] = "200";
		$col["editrules"] = array("required"=>true);
		$col["editoptions"] = array("maxlength" => "40", "size"=>45, "placeholder"=>"Masukan Nama Usaha...");
		$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Npwp";
		$col["name"] = "npwp";
		$col["search"] = true;
		$col["align"] = "center";
		$col["editable"] = true;
		$col["width"] = "200";
		$col["editrules"] = array("required"=>true);
		$col["editoptions"] = array("maxlength" => "40", "size"=>45, "placeholder"=>"Masukan Nomor Npwp...");
		$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Nomor PKP";
		$col["name"] = "no_pkp";
		$col["search"] = true;
		$col["align"] = "center";
		$col["editable"] = true;
		$col["width"] = "200";
		$col["editrules"] = array("required"=>true);
		$col["editoptions"] = array("maxlength" => "40", "size"=>45, "placeholder"=>"Masukan Nomor PKP...");
		$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Alamat";
		$col["name"] = "alamat";
		$col["search"] = true;
		$col["align"] = "center";
		$col["editable"] = true;
		$col["width"] = "200";
		$col["editrules"] = array("required"=>true);
		$col["editoptions"] = array("maxlength" => "40", "size"=>45, "placeholder"=>"Masukan Alamat...");
		$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "ID Provinsi";
		$col["name"] = "idprovinsi";
		$col["search"] = true;
		$col["align"] = "center";
		$col["editable"] = true;
		$col["width"] = "200";
		$col["editrules"] = array("required"=>true);
		$col["editoptions"] = array("maxlength" => "40", "size"=>45, "placeholder"=>"Masukan Id Provinsi...");
		$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "ID Kabupaten";
		$col["name"] = "idkabupaten";
		$col["search"] = true;
		$col["align"] = "center";
		$col["editable"] = true;
		$col["width"] = "200";
		$col["editrules"] = array("required"=>true);
		$col["editoptions"] = array("maxlength" => "40", "size"=>45, "placeholder"=>"Masukan ID Kabupaten...");
		$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Nomor Telepon";
		$col["name"] = "telp";
		$col["search"] = true;
		$col["align"] = "center";
		$col["editable"] = true;
		$col["width"] = "200";
		$col["editrules"] = array("required"=>true);
		$col["editoptions"] = array("maxlength" => "40", "size"=>45, "placeholder"=>"Masukan Nomor Telepon...");
		$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Nomor Fax";
		$col["name"] = "fax";
		$col["search"] = true;
		$col["align"] = "center";
		$col["editable"] = true;
		$col["width"] = "200";
		$col["editrules"] = array("required"=>true);
		$col["editoptions"] = array("maxlength" => "40", "size"=>45, "placeholder"=>"Masukan Nomor Fax...");
		$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Email";
		$col["name"] = "email";
		$col["search"] = true;
		$col["align"] = "center";
		$col["editable"] = true;
		$col["width"] = "200";
		$col["editrules"] = array("required"=>true);
		$col["editoptions"] = array("maxlength" => "40", "size"=>45, "placeholder"=>"Masukan Email...");
		$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Website";
		$col["name"] = "website";
		$col["search"] = true;
		$col["align"] = "center";
		$col["editable"] = true;
		$col["width"] = "200";
		$col["editrules"] = array("required"=>true);
		$col["editoptions"] = array("maxlength" => "40", "size"=>45, "placeholder"=>"Masukan Alamat Website...");
		$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Created";
		$col["name"] = "created";
		$col["search"] = true;
		$col["align"] = "center";
		$col["editable"] = true;
		$col["width"] = "200";
		$col["editrules"] = array("required"=>true);
		$col["editoptions"] = array("maxlength" => "40", "size"=>45, "placeholder"=>"Masukan Tanggal Dibuat...");
		$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "ID User Created";
		$col["name"] = "iduser_created";
		$col["search"] = true;
		$col["align"] = "center";
		$col["editable"] = true;
		$col["width"] = "200";
		$col["editrules"] = array("required"=>true);
		$col["editoptions"] = array("maxlength" => "40", "size"=>45, "placeholder"=>"Masukan ID Yang Buat...");
		$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
		$cols[] = $col;
		$g->set_columns($cols);
		$g->set_options($grid);
	

		
		$data['gridout'] = $g->render("list1");
		$this->load->model('Global_model');
		$head['collapse'] = false;
		$head['title'] = "Home";
		$data['breadcrumbs'] = $this->Global_model->create_breadcrumbs(["Master","Vendor"]);
		$this->load->view('layout/header',$head);
		$this->load->view('layout/sidebar');
		$this->load->view('grid_master',$data);
		$this->load->view('layout/footer');
	}
	
	public function kantor()
	{
		$this->db_conf = array(
			'type' => $this->db->dbdriver,
			'server' => $this->config->item('con_svr'),
			'user' => $this->db->username,
			'password' => $this->db->password,
			'database' => $this->db->database);
		$this->load->library('gridlibrary');
		$g = new jqgrid($this->db_conf);
		$caps = "Kantor TVRI.Kantor Pusat. Daerah .Tranmisi";
		
		$grid["caption"] = $caps;
		$grid["rowNum"] = 20; 
		$grid["rowList"] = array(20,40,100,'All');
		$grid["rownumbers"] = true;
		// $grid["sortname"] = 'idsatuan'; 
		$grid["autowidth"] = true;
		$grid["shrinkToFit"] = true;
		$grid["forceFit"] = false;
		$grid["resizable"] = true;
		$grid["autoresize"] = false;
		$grid["multiselect"] = false; 
		$grid["toolbar"] = "buttom"; 
		$grid["add_options"] = array("width"=>"400");
		$grid["edit_options"] = array("width"=>"400");
		$grid["view_options"] = array("width"=>"400");
		$grid["export"] = array("format"=>"xls", "filename"=>$this->file_name, "sheetname"=>"master-kategoriuji");
		
		$g->set_actions(array(
				"add"=>true,
				"edit"=>true,
				"delete"=>true,
				"rowactions"=>false,
				"export"=>true,
				"autofilter" => true,
				"search" => "advance"
			)
		);
		
		$g->select_command = "SELECT * FROM ms_jenis_kantor";
		$g->table = "ms_jenis_kantor";
				
		
		// $g->set_columns($cols);
		$g->set_options($grid);

		
		$data['gridout'] = $g->render("list1");
		$this->load->model('Global_model');
		$head['collapse'] = false;
		$head['title'] = "Home";
		$data['breadcrumbs'] = $this->Global_model->create_breadcrumbs(["Master","Kantor TVRI"]);
		$this->load->view('layout/header',$head);
		$this->load->view('layout/sidebar');
		$this->load->view('grid_master',$data);
		$this->load->view('layout/footer');
		
	}

	public function satker()
	{
		$this->db_conf = array(
			'type' => $this->db->dbdriver,
			'server' => $this->config->item('con_svr'),
			'user' => $this->db->username,
			'password' => $this->db->password,
			'database' => $this->db->database);
		$this->load->library('gridlibrary');
		$g = new jqgrid($this->db_conf);
		$caps = "Satuan Kerja";
		
		$grid["caption"] = $caps;
		$grid["rowNum"] = 20; 
		$grid["rowList"] = array(20,40,100,'All');
		$grid["rownumbers"] = true;
		// $grid["sortname"] = 'idsatuan'; 
		$grid["autowidth"] = true;
		$grid["shrinkToFit"] = true;
		$grid["forceFit"] = false;
		$grid["resizable"] = true;
		$grid["autoresize"] = false;
		$grid["multiselect"] = false; 
		$grid["toolbar"] = "buttom"; 
		$grid["add_options"] = array("width"=>"400");
		$grid["edit_options"] = array("width"=>"400");
		$grid["view_options"] = array("width"=>"400");
		$grid["export"] = array("format"=>"xls", "filename"=>$this->file_name, "sheetname"=>"master-kategoriuji");
		
		$g->set_actions(array(
				"add"=>true,
				"edit"=>true,
				"delete"=>true,
				"rowactions"=>false,
				"export"=>true,
				"autofilter" => true,
				"search" => "advance"
			)
		);
		
		$g->select_command = "SELECT * FROM ms_kanal";
		$g->table = "ms_kanal";
				
		
		// $g->set_columns($cols);
		$g->set_options($grid);

		
		$data['gridout'] = $g->render("list1");
		$this->load->model('Global_model');
		$head['collapse'] = false;
		$head['title'] = "Home";
		$data['breadcrumbs'] = $this->Global_model->create_breadcrumbs(["Master","Satuan Kerja"]);
		$this->load->view('layout/header',$head);
		$this->load->view('layout/sidebar');
		$this->load->view('grid_master',$data);
		$this->load->view('layout/footer');
	}


}
