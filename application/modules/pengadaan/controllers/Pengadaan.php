<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Auth
 * @property Ion_auth|Ion_auth_model $ion_auth        The ION Auth spark
 * @property CI_Form_validation      $form_validation The form validation library
 */
class Pengadaan extends CI_Controller
{
	var $file_name;
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth', 'form_validation'));
		$this->load->helper(array('url', 'language'));
		$this->db_conf = array(
			'type' => $this->db->dbdriver,
			'server' => $this->config->item('con_svr'),
			'user' => $this->db->username,
			'password' => $this->db->password,
			'database' => $this->db->database);
		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
		$this->lang->load('auth');
	}

	/**
	 * Redirect if needed, otherwise display the user list
	 */
	public function lelang()
	{
		$this->db_conf = array(
			'type' => $this->db->dbdriver,
			'server' => $this->config->item('con_svr'),
			'user' => $this->db->username,
			'password' => $this->db->password,
			'database' => $this->db->database);
		$this->load->library('gridlibrary');
		$g = new jqgrid($this->db_conf);
		$caps = "Proyek Pengadaan Kat. Lelang";
		$this->file_name = $caps;
		
		$grid["caption"] = $caps;
		$grid["rowNum"] = 20; 
		$grid["rowList"] = array(20,40,100,'All');
		$grid["rownumbers"] = true;
		// $grid["sortname"] = 'idsatuan'; 
		$grid["autowidth"] = true;
		$grid["shrinkToFit"] = true;
		$grid["forceFit"] = false;
		$grid["resizable"] = false;
		$grid["autoresize"] = true;
		$grid["multiselect"] = false; 
		$grid["edittable"] = false;
		$grid["toolbar"] = "buttom"; 
		$grid["add_options"] = array("width"=>"800");
		$grid["edit_options"] = array("width"=>"400");
		$grid["view_options"] = array("width"=>"400");
		$grid["export"] = array("format"=>"xls", "filename"=>$this->file_name, "sheetname"=>"proyek_lelang");
		
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
		
		$g->select_command = "SELECT idkontrak, nomor, nama, tgl_kontrak, tgl_pelaksanaan, tgl_berakhir, nilai_pagu, nilai_kontrak, idpengadaan, jenis_masa, dok_kontrak, idvendor, privadmin, status_paket, path_laporan_akhir, email_pic, iduser_created, created FROM trx_kontrak";
		$g->table = "trx_kontrak";
		
		$col = array();
		$col["title"] = "ID";
		$col["name"] = "idkontrak";
		$col["editable"] = true;
		$col["hidden"] = true;
		$col["isnull"] = true;	
		$col["autoid"] = true;	
		$col["export"] = false;	
		$cols[] = $col;
				
		$col = array();
		$col["title"] = "Nomor Kontrak";
		$col["name"] = "nomor";
		$col["search"] = true;
		$col["align"] = "center";
		$col["editable"] = true;
		$col["width"] = "200";
		$col["editrules"] = array("required"=>true);
		$col["editoptions"] = array("maxlength" => "40", "size"=>45, "placeholder"=>"Masukan Nomor Kontrak...");
		$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Nama Kontrak";
		$col["name"] = "nama";
		$col["search"] = true;
		$col["align"] = "left";
		$col["editable"] = true;
		$col["width"] = "200";
		$col["editrules"] = array("required"=>true);
		$col["editoptions"] = array("maxlength" => "200", "size"=>200, "placeholder"=>"Masukan Nama Kontrak...");
		$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Tanggal Kontrak";
		$col["name"] = "tgl_kontrak";
		$col["search"] = true;
		$col["align"] = "left";
		$col["editable"] = true;
		$col["width"] = "200";
		$col["editrules"] = array("required"=>true);
		$col["editoptions"] = array("maxlength" => "", "size"=>30, "placeholder"=>"Masukan Tanggal Kontrak...");
		$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Tanggal Pelaksanaan";
		$col["name"] = "tgl_pelaksanaan";
		$col["search"] = true;
		$col["align"] = "left";
		$col["editable"] = true;
		$col["isnull"] = true;
		$col["width"] = "200";
		$col["editrules"] = array("required"=>true);
		$col["editoptions"] = array("maxlength" => "", "size"=>30, "placeholder"=>"Masukan Tanggal Pelaksanaan...");
		$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Tanggal Berakhir";
		$col["name"] = "tgl_berakhir";
		$col["search"] = true;
		$col["align"] = "left";
		$col["editable"] = true;
		$col["isnull"] = true;
		$col["width"] = "200";
		$col["editrules"] = array("required"=>true);
		$col["editoptions"] = array("maxlength" => "", "size"=>30, "placeholder"=>"Masukan Tanggal Berakhir...");
		$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Nilai Pagu";
		$col["name"] = "nilai_pagu";
		$col["search"] = true;
		$col["align"] = "center";
		$col["editable"] = true;
		$col["isnull"] = true;
		$col["width"] = "200";
		$col["editrules"] = array("required"=>true);
		$col["editoptions"] = array("maxlength" => "", "size"=>25, "placeholder"=>"Masukan Nilai Pagu...");
		$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Nilai Kontrak";
		$col["name"] = "nilai_kontrak";
		$col["search"] = true;
		$col["align"] = "center";
		$col["editable"] = true;
		$col["width"] = "200";
		$col["editrules"] = array("required"=>true);
		$col["editoptions"] = array("maxlength" => "40", "size"=>45, "placeholder"=>"Masukan Nilai Kontrak...");
		$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Kategori Pengadaan";
		$col["name"] = "idpengadaan";
		$col["editable"] = true;
		$col["isnull"] = true;
		$col["edittype"] = "select"; 
		$col["formatter"] = "select";
		$str = $g->get_dropdown_values("SELECT DISTINCT idpengadaan AS k, concat('[',proses,'] ',kategori) AS v FROM ms_katpengadaan ORDER BY 2");
		$col["editoptions"] = array("value" => $str);
		$col["export"] = false;	
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Jenis Masa";
		$col["name"] = "jenis_masa";
		$col["search"] = true;
		$col["align"] = "left";
		$col["editable"] = true;
		$col["width"] = "200";
		$col["edittype"] = "select";
		$col["stype"] = "select";
		$col["formatter"] = "select";
		$col["editrules"] = array("required"=>true);
		$str="Tunggal:Tahun Tunggal;Jamak:Tahun Jamak";
		$col["editoptions"] = array("value" => $str);
		$col["export"] = false;
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Dokumen Kontrak";
		$col["name"] = "dok_kontrak"; 
		$col["width"] = "50";
		$col["editable"] = true; // this column is editable
		$col["isnull"] = true;
		$col["edittype"] = "file"; // render as file
		$col["upload_dir"] = "files"; // upload here
		// $col["add_options"]["bottominfo"] = "Only pdf"; 
		$col["editrules"] = array("ifexist"=>"rename"); // "rename", "override" can also be set
		$col["show"] = array("list"=>false,"edit"=>true,"add"=>true); // only show in add/edit dialog
		$cols[] = $col;
		
		/*$col["on_data_display"] = array("display_icon","");
		function display_icon($data)
		{
			// get upload folder url for display in grid -- change it as per your upload path
			$upload_url = explode("/",$_SERVER["REQUEST_URI"]);
			array_pop($upload_url);
			$upload_url = implode("/",$upload_url)."/";
			
			$file = $data["dok_kontrak"];

			$arr = explode(".",$file);
			$ext = $arr[count($arr)-1];

			if (empty($file))
				return "None";
			else if (strtolower($ext) == "pdf only")
				return "<a href='$upload_url/$file' target='_blank'>Dokumen Kontrak</a>";
			else
				return $file;
		} 
		$cols[] = $col;
		*/
		
		$col = array();
		$col["title"] = "Nama Vendor";
		$col["name"] = "idvendor";
		$col["editable"] = true;
		$col["edittype"] = "select"; 
		$col["formatter"] = "select";
		$str = $g->get_dropdown_values("SELECT DISTINCT idvendor AS k, concat('[',nama,'] ',bentuk_usaha) AS v FROM ms_vendor ORDER BY 2");
		$col["editoptions"] = array("value" => $str);
		$col["export"] = false;	
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Priv Admin";
		$col["name"] = "privadmin";
		$col["search"] = true;
		$col["align"] = "left";
		$col["editable"] = true;
		$col["width"] = "200";
		$col["editrules"] = array("required"=>true);
		$col["editoptions"] = array("maxlength" => "1", "size"=>15, "placeholder"=>"Masukan Priv Admin...");
		$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Status Paket";
		$col["name"] = "status_paket";
		$col["search"] = true;
		$col["align"] = "left";
		$col["editable"] = true;
		$col["width"] = "200";
		$col["edittype"] = "select";
		$col["stype"] = "select";
		$col["formatter"] = "select";
		$col["editrules"] = array("required"=>true);
		$str="Belum:Belum;Berjalan:Sedang Berjalan;Selesai:Sudah Selesai";
		$col["editoptions"] = array("value" => $str);
		$col["export"] = false;
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Path Laporan Akhir";
		$col["name"] = "path_laporan_akhir";
		$col["search"] = true;
		$col["align"] = "left";
		$col["editable"] = true;
		$col["isnull"] = true;
		$col["width"] = "200";
		$col["edittype"] = "file";
		//$col["stype"] = "file";
		//$col["formatter"] = "file";
		$col["editrules"] = array("required"=>true);
		//$col["editoptions"] = array("maxlength" => "150", "size"=>200, "placeholder"=>"Masukan Dokumen Kontrak...");
		$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Email Pic";
		$col["name"] = "email_pic";
		$col["search"] = true;
		$col["align"] = "left";
		$col["editable"] = true;
		$col["isnull"] = true;
		$col["width"] = "200";
		$col["editrules"] = array("required"=>true);
		$col["editoptions"] = array("maxlength" => "255", "size"=>100, "placeholder"=>"Masukan Email Pic...");
		$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "ID User Created";
		$col["name"] = "iduser_created";
		$col["editable"] = true;
		$col["hidden"] = false;
		$col["isnull"] = true;	
		$col["autoid"] = true;	
		$col["export"] = false;	
		$col["width"] = "200";
		$col["editrules"] = array("required"=>true);
		$col["editoptions"] = array("maxlength" => "", "size"=>30, "placeholder"=>"Masukan ID User Created...");
		$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Created";
		$col["name"] = "created";
		$col["search"] = true;
		$col["align"] = "left";
		$col["editable"] = true;
		$col["width"] = "200";
		$col["editrules"] = array("required"=>true);
		$col["editoptions"] = array("maxlength" => "", "size"=>30, "placeholder"=>"Masukan Created...");
		$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
		$cols[] = $col;
		

		$g->set_columns($cols);
		$g->set_options($grid);

		
		$data['gridout'] = $g->render("list1");
		$this->load->model('Global_model');
		$head['collapse'] = false;
		$head['title'] = "Home";
		$data['breadcrumbs'] = $this->Global_model->create_breadcrumbs(["Features","Proyek Pengadaan","Pengadaan Non Lelang"]);
		$this->load->view('layout/header',$head);
		$this->load->view('layout/sidebar');
		$this->load->view('v_pengadaan',$data);
		$this->load->view('layout/footer');
	}

	public function nonlelang()
		{
			$this->db_conf = array(
				'type' => $this->db->dbdriver,
				'server' => $this->config->item('con_svr'),
				'user' => $this->db->username,
				'password' => $this->db->password,
				'database' => $this->db->database);
			$this->load->library('gridlibrary');
			$g = new jqgrid($this->db_conf);
			$caps = "Proyek Pengadaan Kat. Non Lelang";
			$this->file_name = $caps;
			
			$grid["caption"] = $caps;
			$grid["rowNum"] = 20; 
			$grid["rowList"] = array(20,40,100,'All');
			$grid["rownumbers"] = true;
			// $grid["sortname"] = 'idsatuan'; 
			$grid["autowidth"] = true;
			$grid["shrinkToFit"] = true;
			$grid["forceFit"] = false;
			$grid["resizable"] = false;
			$grid["autoresize"] = true;
			$grid["multiselect"] = false; 
			$grid["toolbar"] = "buttom"; 
			$grid["add_options"] = array("width"=>"800");
			$grid["edit_options"] = array("width"=>"400");
			$grid["view_options"] = array("width"=>"400");
			$grid["export"] = array("format"=>"xls", "filename"=>$this->file_name, "sheetname"=>"proyek_nonlelang");
			
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
			
			$g->select_command = "SELECT idkontrak, nomor, nama, tgl_kontrak, tgl_pelaksanaan, tgl_berakhir, nilai_pagu, nilai_kontrak, idpengadaan, jenis_masa, dok_kontrak, idvendor, privadmin, status_paket, path_laporan_akhir, email_pic, iduser_created, created FROM trx_kontrak";
			$g->table = "trx_kontrak";
			
			$col = array();
			$col["title"] = "ID";
			$col["name"] = "idkontrak";
			$col["editable"] = true;
			$col["hidden"] = true;
			$col["isnull"] = true;	
			$col["autoid"] = true;	
			$col["export"] = false;	
			$cols[] = $col;
					
			$col = array();
			$col["title"] = "Nomor Kontrak";
			$col["name"] = "nomor";
			$col["search"] = true;
			$col["align"] = "center";
			$col["editable"] = true;
			$col["width"] = "200";
			$col["editrules"] = array("required"=>true);
			$col["editoptions"] = array("maxlength" => "40", "size"=>45, "placeholder"=>"Masukan Nomor Kontrak...");
			$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "Nama Kontrak";
			$col["name"] = "nama";
			$col["search"] = true;
			$col["align"] = "left";
			$col["editable"] = true;
			$col["width"] = "200";
			$col["editrules"] = array("required"=>true);
			$col["editoptions"] = array("maxlength" => "200", "size"=>200, "placeholder"=>"Masukan Nama Kontrak...");
			$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "Tanggal Kontrak";
			$col["name"] = "tgl_kontrak";
			$col["search"] = true;
			$col["align"] = "left";
			$col["editable"] = true;
			$col["width"] = "200";
			$col["editrules"] = array("required"=>true);
			$col["editoptions"] = array("maxlength" => "", "size"=>30, "placeholder"=>"Masukan Tanggal Kontrak...");
			$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "Tanggal Pelaksanaan";
			$col["name"] = "tgl_pelaksanaan";
			$col["search"] = true;
			$col["align"] = "left";
			$col["editable"] = true;
			$col["width"] = "200";
			$col["editrules"] = array("required"=>true);
			$col["editoptions"] = array("maxlength" => "", "size"=>30, "placeholder"=>"Masukan Tanggal Pelaksanaan...");
			$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "Tanggal Berakhir";
			$col["name"] = "tgl_berakhir";
			$col["search"] = true;
			$col["align"] = "left";
			$col["editable"] = true;
			$col["width"] = "200";
			$col["editrules"] = array("required"=>true);
			$col["editoptions"] = array("maxlength" => "", "size"=>30, "placeholder"=>"Masukan Tanggal Berakhir...");
			$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "Nilai Pagu";
			$col["name"] = "nilai_pagu";
			$col["search"] = true;
			$col["align"] = "center";
			$col["editable"] = true;
			$col["width"] = "200";
			$col["editrules"] = array("required"=>true);
			$col["editoptions"] = array("maxlength" => "", "size"=>25, "placeholder"=>"Masukan Nilai Pagu...");
			$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "Nilai Kontrak";
			$col["name"] = "nilai_kontrak";
			$col["search"] = true;
			$col["align"] = "center";
			$col["editable"] = true;
			$col["width"] = "200";
			$col["editrules"] = array("required"=>true);
			$col["editoptions"] = array("maxlength" => "40", "size"=>45, "placeholder"=>"Masukan Nilai Kontrak...");
			$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "Kategori Pengadaan";
			$col["name"] = "idpengadaan";
			$col["editable"] = true;
			$col["edittype"] = "select"; 
			$col["formatter"] = "select";
			$str = $g->get_dropdown_values("SELECT DISTINCT idpengadaan AS k, concat('[',proses,'] ',kategori) AS v FROM ms_katpengadaan ORDER BY 2");
			$col["editoptions"] = array("value" => $str);
			$col["export"] = false;	
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "Jenis Masa";
			$col["name"] = "jenis_masa";
			$col["search"] = true;
			$col["align"] = "left";
			$col["editable"] = true;
			$col["width"] = "200";
			$col["edittype"] = "select";
			$col["stype"] = "select";
			$col["formatter"] = "select";
			$col["editrules"] = array("required"=>true);
			$str="Tunggal:Tahun Tunggal;Jamak:Tahun Jamak";
			$col["editoptions"] = array("value" => $str);
			$col["export"] = false;
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "Dokumen Kontrak";
			$col["name"] = "dok_kontrak";
			$col["search"] = true;
			$col["align"] = "left";
			$col["editable"] = true;
			$col["width"] = "200";
			$col["edittype"] = "file";
			$col["editrules"] = array("required"=>true);
			//$col["editoptions"] = array("maxlength" => "150", "size"=>200, "placeholder"=>"Masukan Dokumen Kontrak...");
			$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "Nama Vendor";
			$col["name"] = "idvendor";
			$col["editable"] = true;
			$col["edittype"] = "select"; 
			$col["formatter"] = "select";
			$str = $g->get_dropdown_values("SELECT DISTINCT idvendor AS k, concat('[',nama,'] ',bentuk_usaha) AS v FROM ms_vendor ORDER BY 2");
			$col["editoptions"] = array("value" => $str);
			$col["export"] = false;	
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "Priv Admin";
			$col["name"] = "privadmin";
			$col["search"] = true;
			$col["align"] = "left";
			$col["editable"] = true;
			$col["width"] = "200";
			$col["editrules"] = array("required"=>true);
			$col["editoptions"] = array("maxlength" => "1", "size"=>15, "placeholder"=>"Masukan Priv Admin...");
			$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "Status Paket";
			$col["name"] = "status_paket";
			$col["search"] = true;
			$col["align"] = "left";
			$col["editable"] = true;
			$col["width"] = "200";
			$col["edittype"] = "select";
			$col["stype"] = "select";
			$col["formatter"] = "select";
			$col["editrules"] = array("required"=>true);
			$str="Belum:Belum;Berjalan:Sedang Berjalan;Selesai:Sudah Selesai";
			$col["editoptions"] = array("value" => $str);
			$col["export"] = false;
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "Path Laporan Akhir";
			$col["name"] = "path_laporan_akhir";
			$col["search"] = true;
			$col["align"] = "left";
			$col["editable"] = true;
			$col["width"] = "200";
			$col["edittype"] = "file";
			//$col["stype"] = "file";
			//$col["formatter"] = "file";
			$col["editrules"] = array("required"=>true);
			//$col["editoptions"] = array("maxlength" => "150", "size"=>200, "placeholder"=>"Masukan Dokumen Kontrak...");
			$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "Email Pic";
			$col["name"] = "email_pic";
			$col["search"] = true;
			$col["align"] = "left";
			$col["editable"] = true;
			$col["width"] = "200";
			$col["editrules"] = array("required"=>true);
			$col["editoptions"] = array("maxlength" => "255", "size"=>100, "placeholder"=>"Masukan Email Pic...");
			$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "ID User Created";
			$col["name"] = "iduser_created";
			$col["editable"] = true;
			$col["hidden"] = false;
			$col["isnull"] = true;	
			$col["autoid"] = true;	
			$col["export"] = false;	
			$col["width"] = "200";
			$col["editrules"] = array("required"=>true);
			$col["editoptions"] = array("maxlength" => "", "size"=>30, "placeholder"=>"Masukan ID User Created...");
			$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "Created";
			$col["name"] = "created";
			$col["search"] = true;
			$col["align"] = "left";
			$col["editable"] = true;
			$col["width"] = "200";
			$col["editrules"] = array("required"=>true);
			$col["editoptions"] = array("maxlength" => "", "size"=>30, "placeholder"=>"Masukan Created...");
			$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
			$cols[] = $col;
			

			$g->set_columns($cols);
			$g->set_options($grid);

			
			$data['gridout'] = $g->render("list1");
			$this->load->model('Global_model');
			$head['collapse'] = false;
			$head['title'] = "Home";
			$data['breadcrumbs'] = $this->Global_model->create_breadcrumbs(["Features","Proyek Pengadaan","Pengadaan Non Lelang"]);
			$this->load->view('layout/header',$head);
			$this->load->view('layout/sidebar');
			$this->load->view('v_pengadaan',$data);
			$this->load->view('layout/footer');
		}


}
