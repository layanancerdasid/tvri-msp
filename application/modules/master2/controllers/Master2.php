<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master2 extends CI_Controller {
	
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
	 echo 'test'; die;
	public function index()
	{
		$this->load->model('Global_model');
		$head['collapse'] = false;
		$head['title'] = "wilayah";
		$data['breadcrumbs'] = $this->Global_model->create_breadcrumbs(["Master","Wilayah"]);
		$this->load->view('layout/header',$head);
		$this->load->view('layout/sidebar');
		$this->load->view('blank',$data);
		$this->load->view('layout/footer');
	}

 public function provinsi()
	{
		$this->db_conf = array(
			'type' => $this->db->dbdriver,
			'server' => $this->config->item('con_svr'),
			'user' => $this->db->username,
			'password' => $this->db->password,
			'database' => $this->db->database);
		$this->load->model('Global_model');
			if(in_array(1,$this->session->userdata('priv')) == FALSE) return redirect('404_override');
	
		$this->load->library('gridlibrary');
		$g = new jqgrid($this->db_conf);
		$caps = "Master Provinsi";
		
		$grid["caption"] = $caps;
		$grid["rowNum"] = 20; 
		$grid["rowList"] = array(20,40,100,'All');
		$grid["rownumbers"] = true;
		$grid["sortname"] = 'idprovinsi'; 
		$grid["autowidth"] = true;
		$grid["shrinkToFit"] = true;
		$grid["forceFit"] = false;
		$grid["resizable"] = true;
		// $grid["autoresize"] = false;
		$grid["multiselect"] = false; 
		$grid["rowactions"] = true; 
		$grid["toolbar"] = "both"; 
		$grid["height"] = ""; 
		$grid["autoresize"] = true;
		// $grid["responsive"] = true;
		$grid["add_options"] = array("width"=>"360");
		$grid["edit_options"] = array("width"=>"360");
		$grid["view_options"] = array("width"=>"360");
		$grid["export"] = array("format"=>"xls", "filename"=>$this->file_name, "sheetname"=>"master");
		
		$grid["subGrid"] = true; 
		$grid["subgridurl"] = "kabupaten";
		$grid["subgridparams"] = "idprovinsi, nama_provinsi";
		
		
		$g->set_actions(array(
				"add"=>true,
				"edit"=>true,
				"delete"=>false,
				"rowactions"=>false,
				"export"=>true,
				"autofilter" => true,
				"search" => false
			)
		);
		
		$g->select_command = "SELECT idprovinsi,nama_provinsi,tanggal_nonaktif FROM ms_provinsi";
		$g->table = "ms_provinsi";
		
		$col = array();
		$col["title"] = "ID";
		$col["name"] = "idprovinsi";
		$col["editoptions"] = array("maxlength" => "2");
		$col["search"] = true;
		$col["editable"] = true;
		// $col["hidden"] = true;
		$col["isnull"] = true;	
		$col["autoid"] = false;	
		$col["align"] = "center";
		$col["width"] = "120";
		$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
		$cols[] = $col;
	
	$col = array();
		$col["title"] = "Provinsi";
		$col["name"] = "nama_provinsi";
		$col["editoptions"] = array("maxlength" => "50");
		$col["search"] = true;
		$col["editable"] = true;
		$col["width"] = "250";
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Tgl Nonaltif";
		$col["name"] = "tanggal_nonaktif";
		$col["search"] = true;
		$col["editable"] = true;
		$col["align"] = "center";
		$col["formatter"] = "date"; 
		$col["formatoptions"] = array("srcformat"=>'Y-m-d',"newformat"=>'d-m-Y');
		$col["width"] = "120";
		$cols[] = $col;
		
		
		$g->set_columns($cols);
		$g->set_options($grid);

		// $head[''] = $caps;
		// helper_log(); 
		
		
		$data['gridout'] = $g->render("list1");
		$this->load->model('Global_model');
		$head['collapse'] = false;
		$head['title'] = "Home";
		$data['breadcrumbs'] = $this->Global_model->create_breadcrumbs(["master2","provinsi"]);
		$this->load->view('layout/header',$head);
		$this->load->view('layout/sidebar');
		$this->load->view('grid_master',$data);
		$this->load->view('layout/footer');
	}
  
 /* public function kabupaten()
	{
		$this->db_conf = array(
			'type' => $this->db->dbdriver,
			'server' => $this->config->item('con_svr'),
			'user' => $this->db->username,
			'password' => $this->db->password,
			'database' => $this->db->database);
		$this->load->model('Global_model');
			if(in_array(1,$this->session->userdata('priv')) == FALSE) return redirect('404_override');
	
		$this->load->library('gridlibrary');
		$g = new jqgrid($this->db_conf);
		$caps = "Master Kabupaten";
		
		$grid["caption"] = $caps;
		$grid["rowNum"] = 20; 
		$grid["rowList"] = array(20,40,100,'All');
		$grid["rownumbers"] = true;
		$grid["sortname"] = 'idkabupaten'; 
		$grid["autowidth"] = true;
		$grid["shrinkToFit"] = true;
		$grid["forceFit"] = false;
		$grid["resizable"] = true;
		// $grid["autoresize"] = false;
		$grid["multiselect"] = false; 
		$grid["rowactions"] = true; 
		$grid["toolbar"] = "both"; 
		$grid["height"] = ""; 
		$grid["autoresize"] = true;
		// $grid["responsive"] = true;
		$grid["add_options"] = array("width"=>"360");
		$grid["edit_options"] = array("width"=>"360");
		$grid["view_options"] = array("width"=>"360");
		$grid["export"] = array("format"=>"xls", "filename"=>$this->file_name, "sheetname"=>"master");
		
		/* // /$grid["subGrid"] = true; 
		$grid["subgridurl"] = "kabupaten";
		$grid["subgridparams"] = "idprovinsi, nama_provinsi";
		 */
		
		/* $g->set_actions(array(
				"add"=>true,
				"edit"=>true,
				"delete"=>false,
				"rowactions"=>false,
				"export"=>true,
				"autofilter" => true,
				"search" => false
			)
		);
		
		$g->select_command = "SELECT idprovinsi,idkabupaten,nama_kabupaten,tanggal_nonaktif FROM ms_kabupaten";
		$g->table = "ms_kabupaten";
		
		$col = array();
		$col["title"] = "ID";
		$col["name"] = "idkabupaten";
		$col["editoptions"] = array("maxlength" => "4");
		$col["search"] = true;
		$col["editable"] = true;
		// $col["hidden"] = true;
		$col["isnull"] = true;	
		$col["autoid"] = false;	
		$col["align"] = "center";
		$col["width"] = "120";
		$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
		$cols[] = $col;
	
	$col = array();
		$col["title"] = "Kabupaten";
		$col["name"] = "nama_kabupaten";
		$col["editoptions"] = array("maxlength" => "50");
		$col["search"] = true;
		$col["editable"] = true;
		$col["width"] = "250";
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Tgl Nonaltif";
		$col["name"] = "tanggal_nonaktif";
		$col["search"] = true;
		$col["editable"] = true;
		$col["align"] = "center";
		$col["formatter"] = "date"; 
		$col["formatoptions"] = array("srcformat"=>'Y-m-d',"newformat"=>'d-m-Y');
		$col["width"] = "120";
		$cols[] = $col;
		
		
		$g->set_columns($cols);
		$g->set_options($grid);

		// $head[''] = $caps;
		// helper_log(); 
		
		
		$data['gridout'] = $g->render("list1");
		echo $data['gridout'];
	}
   */
  
public function kabupaten()
	{
		if(in_array(2,$this->session->userdata('priv')) == FALSE) return redirect('404_override');
		$this->load->library('gridlibrary');
		$g = new jqgrid($this->db_conf);
		$caps = "Master Kabupaten/Kota";
		
		$idprovinsi= $_REQUEST['rowid'];
		$nama_provinsi = $_REQUEST["nama_provinsi"];
		if($idprovinsi){
			$caps .= ", Propinsi ".$nama_provinsi;			
			$filter = "WHERE idprovinsi='$idprovinsi' ";	
			$grid["subGrid"] = true; 
			$grid["subgridurl"] = "kecamatan";
			$grid["subgridparams"] = "idkabupaten, nama_kabupaten";
		}
		
		
		$grid["caption"] = $caps;
		$grid["rowNum"] = 20; 
		$grid["rowList"] = array(20,40,100,'All');
		$grid["rownumbers"] = true;
		$grid["sortname"] = 'idkabupaten'; 
		$grid["autowidth"] = true;
		$grid["shrinkToFit"] = true;
		$grid["forceFit"] = false;
		$grid["resizable"] = true;
		$grid["autoresize"] = false;
		$grid["multiselect"] = false; 
		$grid["rowactions"] = true; 
		$grid["toolbar"] = "both"; 
		$grid["height"] = ""; 
		$grid["add_options"] = array("width"=>"460");
		$grid["edit_options"] = array("width"=>"460");
		$grid["view_options"] = array("width"=>"460");
		$grid["export"] = array("format"=>"xls", "filename"=>$this->file_name, "sheetname"=>"master");
		
		$g->set_actions(array(
				"add"=>true,
				"edit"=>true,
				"delete"=>false,
				"rowactions"=>false,
				"export"=>true,
				"autofilter" => true,
				"search" => false
			)
		);
		
		$g->select_command = "SELECT idprovinsi,idkabupaten,nama_kabupaten,tanggal_nonaktif FROM ms_kabupaten $filter";
		$g->table = "ms_kabupaten";
		
		$col = array();
		$col["title"] = "ID";
		$col["name"] = "idkabupaten";
		$col["search"] = true;
		$col["editable"] = true;
		$col["isnull"] = true;	
		$col["autoid"] = false;	
		$col["width"] = "120";
		$col["align"] = "center";
		$col["editoptions"] = array("maxlength" => "4");
		$col["editrules"] = array("required"=>true); 
		$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
		$cols[] = $col;
			
		$col = array();
		$col["title"] = "Provinsi";
		$col["name"] = "idprovinsi";
		$col["width"] = "180";
		$col["search"] = true;
		$col["editable"] = true;
		$col["align"] = "left";
		$col["editrules"] = array("required"=>true); 
		$col["edittype"] = "select";
		$col["stype"] = "select";
		$col["formatter"] = "select";
		$col["editrules"] = array("required"=>true); 
		$str = $g->get_dropdown_values("SELECT DISTINCT idprovinsi AS k, nama_provinsi AS v  FROM ms_provinsi WHERE idprovinsi<>0 ORDER BY 2");
		$col["searchoptions"] = array("value" =>"0:NA;".$str, "separator" => ":", "delimiter" => ";");
		$col["editoptions"] = array("value" =>"0:NA;".$str, "separator" => ":", "delimiter" => ";" );
		$col["show"] = array("list"=>!($idprovinsi),"edit"=>true,"add"=>true,"view"=>true);
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Kabupaten/Kota";
		$col["name"] = "nama_kabupaten";
		$col["search"] = true;
		$col["editable"] = true;
		$col["width"] = "180";
		$col["editoptions"] = array("maxlength" => "50");
		$col["editrules"] = array("required"=>true); 
		$cols[] = $col; 
		
		$col = array();
		$col["title"] = "Tgl Nonaltif";
		$col["name"] = "tanggal_nonaktif";
		$col["search"] = true;
		$col["editable"] = true;
		$col["formatter"] = "date"; 
		$col["formatoptions"] = array("srcformat"=>'Y-m-d',"newformat"=>'d-m-Y');
		$col["width"] = "120";
		$col["align"] = "center";
		$cols[] = $col;

		$g->set_columns($cols);
		$g->set_options($grid);

		$head['title'] = $caps;
		$data['breadcrumbs'] = $this->Global_model->create_breadcrumbs(["master2","kabupaten"]);
		
		$data['gridout'] = $g->render("list1");
		if($idprovinsi){
			echo $data['gridout']; exit;
		}
		
		helper_log();
		$this->load->view('layout/header',$head);
		$this->load->view('layout/sidebar');
		$this->load->view('grid_master',$data);
		$this->load->view('layout/footer');
	}
	
	public function kecamatan()
	{
		if(in_array(2,$this->session->userdata('priv')) == FALSE) return redirect('404_override');
		$this->load->library('gridlibrary');
		$g = new jqgrid($this->db_conf);
		$caps = "Master Kecamatan";
		
		$idkabupaten= $_REQUEST['rowid'];
		$nama_kabupaten = $_REQUEST["nama_kabupaten"];
		if($idkabupaten){
			$caps .= ", Kabupaten/Kota ".$nama_kabupaten;			
			$filter = "WHERE idkabupaten='$idkabupaten' ";	
			$grid["subGrid"] = true; 
			$grid["subgridurl"] = "kelurahan";
			$grid["subgridparams"] = "idkec, nama_kec";
		}
		
		
		$grid["caption"] = $caps;
		$grid["rowNum"] = 50; 
		$grid["rowList"] = array(50,100,200,'All');
		$grid["rownumbers"] = true;
		$grid["sortname"] = 'idkec'; 
		$grid["autowidth"] = true;
		$grid["shrinkToFit"] = true;
		$grid["forceFit"] = false;
		$grid["resizable"] = true;
		$grid["autoresize"] = false;
		$grid["multiselect"] = false; 
		$grid["rowactions"] = true; 
		$grid["toolbar"] = "both"; 
		$grid["height"] = ""; 
		$grid["add_options"] = array("width"=>"460");
		$grid["edit_options"] = array("width"=>"460");
		$grid["view_options"] = array("width"=>"460");
		$grid["export"] = array("format"=>"xls", "filename"=>$this->file_name, "sheetname"=>"master");
		
		$g->set_actions(array(
				"add"=>true,
				"edit"=>true,
				"delete"=>false,
				"rowactions"=>false,
				"export"=>true,
				"autofilter" => true,
				"search" => false
			)
		);
		
		$g->select_command = "SELECT idkec,idkabupaten,nama_kec FROM ms_kecamatan $filter";
		$g->table = "ms_kecamatan";
		
		$col = array();
		$col["title"] = "ID";
		$col["name"] = "idkec";
		$col["search"] = true;
		$col["editable"] = true;
		$col["isnull"] = true;	
		$col["autoid"] = false;	
		$col["width"] = "120";
		$col["align"] = "center";
		$col["editoptions"] = array("maxlength" => "7");
		$col["editrules"] = array("required"=>true); 
		$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
		$cols[] = $col;
			
		$col = array();
		$col["title"] = "Kabupaten/Kota";
		$col["name"] = "idkabupaten";
		$col["width"] = "180";
		$col["search"] = true;
		$col["editable"] = true;
		$col["align"] = "left";
		$col["editrules"] = array("required"=>true); 
		$col["edittype"] = "select";
		$col["stype"] = "select";
		$col["formatter"] = "select";
		$col["editrules"] = array("required"=>true); 
		$str = $g->get_dropdown_values("SELECT DISTINCT idkabupaten AS k, nama_kabupaten AS v  FROM ms_kabupaten WHERE idkabupaten<>0 AND idkabupaten like '$idkabupaten%' ORDER BY 2");
		$col["searchoptions"] = array("value" =>"0:NA;".$str, "separator" => ":", "delimiter" => ";");
		$col["editoptions"] = array("value" =>"0:NA;".$str, "separator" => ":", "delimiter" => ";" );
		$col["show"] = array("list"=>!($idkabupaten),"edit"=>true,"add"=>true,"view"=>true);
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Kecamatan";
		$col["name"] = "nama_kec";
		$col["search"] = true;
		$col["editable"] = true;
		$col["width"] = "180";
		$col["editoptions"] = array("maxlength" => "50");
		$col["editrules"] = array("required"=>true); 
		$cols[] = $col; 
		
		// $col = array();
		// $col["title"] = "Tgl Nonaltif";
		// $col["name"] = "tanggal_nonaktif";
		// $col["search"] = true;
		// $col["editable"] = true;
		// $col["formatter"] = "date"; 
		// $col["formatoptions"] = array("srcformat"=>'Y-m-d',"newformat"=>'d-m-Y');
		// $col["width"] = "120";
		// $col["align"] = "center";
		// $cols[] = $col;

		$g->set_columns($cols);
		$g->set_options($grid);

		$head['title'] = $caps;
		$data['breadcrumbs'] = $this->Global_model->create_breadcrumbs(["master2","kecamatan"]);
		
		$data['gridout'] = $g->render("list1");
		if($idkabupaten){
			echo $data['gridout']; exit;
		}
		
		helper_log();
		$this->load->view('layout/header',$head);
		$this->load->view('layout/sidebar');
		$this->load->view('grid_master',$data);
		$this->load->view('layout/footer');
	}
	
	public function kelurahan()
	{
		if(in_array(2,$this->session->userdata('priv')) == FALSE) return redirect('404_override');
		$this->load->library('gridlibrary');
		$g = new jqgrid($this->db_conf);
		$caps = "Master Kelurahan";
		
		$idkec= $_REQUEST['rowid'];
		$nama_kec = $_REQUEST["nama_kec"];
		if($idkec){
			$caps .= ", Kecamatan ".$nama_kec;			
			$filter = "WHERE idkec='$idkec' ";	
		}
		
		
		$grid["caption"] = $caps;
		$grid["rowNum"] = 50; 
		$grid["rowList"] = array(50,100,200,'All');
		$grid["rownumbers"] = true;
		$grid["sortname"] = 'idkec'; 
		$grid["autowidth"] = true;
		$grid["shrinkToFit"] = true;
		$grid["forceFit"] = false;
		$grid["resizable"] = true;
		$grid["autoresize"] = false;
		$grid["multiselect"] = false; 
		$grid["rowactions"] = true; 
		$grid["toolbar"] = "both"; 
		$grid["height"] = ""; 
		$grid["add_options"] = array("width"=>"460");
		$grid["edit_options"] = array("width"=>"460");
		$grid["view_options"] = array("width"=>"460");
		$grid["export"] = array("format"=>"xls", "filename"=>$this->file_name, "sheetname"=>"master");
		
		$g->set_actions(array(
				"add"=>true,
				"edit"=>true,
				"delete"=>false,
				"rowactions"=>false,
				"export"=>true,
				"autofilter" => true,
				"search" => false
			)
		);
		
		$g->select_command = "SELECT iddesa,idkec,nama_desa FROM ms_desa $filter";
		$g->table = "ms_desa";
		
		$col = array();
		$col["title"] = "ID";
		$col["name"] = "iddesa";
		$col["search"] = true;
		$col["editable"] = true;
		$col["isnull"] = true;	
		$col["autoid"] = false;	
		$col["width"] = "120";
		$col["align"] = "center";
		$col["editoptions"] = array("maxlength" => "10");
		$col["editrules"] = array("required"=>true); 
		$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
		$cols[] = $col;
			
		$col = array();
		$col["title"] = "Kecamatan";
		$col["name"] = "idkec";
		$col["width"] = "180";
		$col["search"] = true;
		$col["editable"] = true;
		$col["align"] = "left";
		$col["editrules"] = array("required"=>true); 
		$col["edittype"] = "select";
		$col["stype"] = "select";
		$col["formatter"] = "select";
		$col["editrules"] = array("required"=>true); 
		$str = $g->get_dropdown_values("SELECT DISTINCT idkec AS k, nama_kec AS v  FROM ms_kecamatan WHERE idkec<>0 and idkec like '$idkec%' ORDER BY 2"); 
		$col["searchoptions"] = array("value" =>"0:NA;".$str, "separator" => ":", "delimiter" => ";");
		$col["editoptions"] = array("value" =>"0:NA;".$str, "separator" => ":", "delimiter" => ";" );
		$col["show"] = array("list"=>!($idkec),"edit"=>true,"add"=>true,"view"=>true);
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Nama Desa";
		$col["name"] = "nama_desa";
		$col["search"] = true;
		$col["editable"] = true;
		$col["width"] = "180";
		$col["editoptions"] = array("maxlength" => "50");
		$col["editrules"] = array("required"=>true); 
		$cols[] = $col; 
		
		// $col = array();
		// $col["title"] = "Tgl Nonaltif";
		// $col["name"] = "tanggal_nonaktif";
		// $col["search"] = true;
		// $col["editable"] = true;
		// $col["formatter"] = "date"; 
		// $col["formatoptions"] = array("srcformat"=>'Y-m-d',"newformat"=>'d-m-Y');
		// $col["width"] = "120";
		// $col["align"] = "center";
		// $cols[] = $col;

		$g->set_columns($cols);
		$g->set_options($grid);

		$head['title'] = $caps;
		$data['breadcrumbs'] = $this->Global_model->create_breadcrumbs(["master2","kelurahan"]);
		
		$data['gridout'] = $g->render("list1");
		if($idkec){
			echo $data['gridout']; exit;
		}
		
		helper_log();
		$this->load->view('layout/header',$head);
		$this->load->view('layout/sidebar');
		$this->load->view('grid_master',$data);
		$this->load->view('layout/footer');
	}
}