<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Proyek extends CI_Controller
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
	public function index()
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
		$grid["shrinkToFit"] = false;
		$grid["forceFit"] = false;
		$grid["resizable"] = false;
		$grid["autoresize"] = true;
		$grid["multiselect"] = false; 
		$grid["edittable"] = false;
		$grid["toolbar"] = "buttom"; 
		$grid["add_options"] = array("width"=>"700");
		$grid["edit_options"] = array("width"=>"700");
		$grid["view_options"] = array("width"=>"700");
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
		
		$g->select_command = "SELECT id_proyek, tr_proyek.satker, nama_proyek, tgl_kontrak, tgl_pelaksanaan, tgl_berakhir, masa_pekerjaan, kategori, ms_pegawai.nama_lengkap, nilai_kontrak, no_bast, tgl_bast, dok_kontrak, idvendor, status_paket, pic, no_kontrak, tr_proyek.iduser_created, tr_proyek.created, ms_satker_tvri.nama_satker  FROM tr_proyek 
		LEFT JOIN ms_pegawai on ms_pegawai.idpeg = tr_proyek.pic
		LEFT JOIN ms_satker_tvri on ms_satker_tvri.idsatker=tr_proyek.satker";
		$g->table = "tr_proyek";
		
		$col = array();
		$col["title"] = "ID";
		$col["name"] = "id_proyek";
		$col["editable"] = true;
		$col["hidden"] = true;
		$col["isnull"] = true;	
		$col["autoid"] = true;	
		$col["export"] = false;	
		$cols[] = $col;
				
		$col = array();
		$col["title"] = "Kegiatan/Uraian Pekerjaan";
		$col["name"] = "nama_proyek";
		$col["search"] = true;
		$col["align"] = "left";
		$col["editable"] = true;
		$col["width"] = "200";
		$col["editrules"] = array("required"=>true);
		$col["editoptions"] = array("maxlength" => "150", "size"=>80, "placeholder"=>"Masukan Nama Kontrak...");
		$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Kategori";
		$col["name"] = "kategori";
		$col["search"] = true;
		$col["align"] = "left";
		$col["editable"] = true;
		$col["width"] = "200";
		$col["edittype"] = "select";
		$col["stype"] = "select";
		$col["formatter"] = "select";
		$col["editrules"] = array("required"=>true);
		$str="Perbaikan:Perbaikan;Pemeliharaan:Pemeliharaan";
		$col["editoptions"] = array("value" => $str);
		$col["searchoptions"] = array("value" => ":;".$str);
		$col["export"] = false;
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Satuan Kerja";
		$col["name"] = "satker"; 
		$col["editable"] = true;
		$col["hidden"] = true;
		$col["export"] = false;
		$cols[] = $col;	
		
		$col = array();
		$col["title"] = "Satuan Kerja";
		$col["name"] = "nama_satker";
		$col["dbname"] = "nama_satker";
		$col["editable"] = true;
		$col["width"] = "380";
		$col["formatter"] = "autocomplete"; // autocomplete
		$col["editoptions"] = array("placeholder"=>"Masukan nama satuan kerja...", "size"=>80);
		$col["formatoptions"] = array("sql"=>"SELECT idsatker as k, nama_satker as v FROM ms_satker_tvri", "update_field"=>"satker");
		$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
		$cols[] = $col;
		
		
		$col = array();
		$col["title"] = "Nomor Kontrak";
		$col["name"] = "no_kontrak";
		$col["search"] = true;
		$col["align"] = "center";
		$col["editable"] = true;
		$col["width"] = "200";
		$col["editrules"] = array("required"=>true);
		$col["editoptions"] = array("maxlength" => "40", "size"=>80, "placeholder"=>"Masukan Nomor Kontrak...");
		$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
		$cols[] = $col;
				
		$col = array();
		$col["title"] = "Tgl Kontrak";
		$col["name"] = "tgl_kontrak";
		$col["search"] = true;
		$col["align"] = "left";
		$col["editable"] = true;
		$col["width"] = "200";
		$col["editrules"] = array("required"=>true);
		$col["formatter"] 		= "date";
		$col["formatoptions"] = array("srcformat"=>'Y-m-d',"newformat"=>'d-m-Y', "opts" => array("changeYear" => true, "changeMonth" => true));
		$col["editoptions"] = array("maxlength" => "", "size"=>30, "placeholder"=>"Masukan Tanggal Kontrak...");
		$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Tgl Pelaksanaan";
		$col["name"] = "tgl_pelaksanaan";
		$col["search"] = true;
		$col["align"] = "left";
		$col["editable"] = true;
		$col["width"] = "200";
		#$col["editrules"] = array("required"=>true);
		$col["editoptions"] = array("size"=>20, "defaultValue" => date("d-m-Y"));
		$col["formatter"] 		= "date";
		$col["formatoptions"] = array("srcformat"=>'Y-m-d',"newformat"=>'d-m-Y', "opts" => array("changeYear" => true, "changeMonth" => true));
		$col["editoptions"] = array("maxlength" => "", "size"=>30, "placeholder"=>"Masukan Tanggal Pelaksanaan...");
		$cols[] = $col;
		
		
		$col = array();
		$col["title"] = "Tgl Berakhir";
		$col["name"] = "tgl_berakhir";
		$col["search"] = true;
		$col["align"] = "left";
		$col["editable"] = true;
		$col["width"] = "200";
		//$col["editrules"] = array("required"=>true);
		$col["formatter"] 		= "date";
		$col["formatoptions"] = array("srcformat"=>'Y-m-d',"newformat"=>'d-m-Y', "opts" => array("changeYear" => true, "changeMonth" => true));
		$col["editoptions"] = array("maxlength" => "", "size"=>30, "placeholder"=>"Masukan Tanggal Berakhir...");
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Masa Pekerjaan (hari)";
		$col["name"] = "masa_pekerjaan";
		$col["search"] = true;
		$col["align"] = "center";
		$col["editable"] = true;
		$col["width"] = "200";
		$col["editrules"] = array("required"=>true);
		$col["editoptions"] = array("maxlength" => "3", "size"=>15, "placeholder"=>"Masa Pelaksanaan...");
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
		$col["title"] = "PIC";
		$col["name"] = "pic"; 
		$col["editable"] = true;
		$col["hidden"] = true;
		$cols[] = $col;	
		
		$col = array();
		$col["title"] = "PIC";
		$col["name"] = "nama_lengkap";
		$col["dbname"] = "nama_lengkap";
		$col["editable"] = true;
		$col["width"] = "80";
		$col["formatter"] = "autocomplete"; // autocomplete
		$col["editoptions"] = array("placeholder"=>"Masukan Pic...");
		$col["formatoptions"] = array("sql"=>"SELECT idpeg as k, nama_lengkap as v FROM ms_pegawai where aktif='1' order by nama_lengkap", "update_field"=>"pic");
		$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
		$cols[] = $col;	
		
		
		
		$col = array();
		$col["title"] = "Nama Vendor";
		$col["name"] = "idvendor";
		$col["editable"] = true;
		$col["edittype"] = "select";
		$col["stype"] = "select";		
		$col["formatter"] = "select";
		$str = $g->get_dropdown_values("SELECT DISTINCT idvendor AS k, concat(nama,' - ',bentuk_usaha) AS v FROM ms_vendor ORDER BY 2");
		$col["editoptions"] = array("value" => $str);
		$col["searchoptions"] = array("value" => ":;".$str);
		$col["export"] = false;	
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
		$col["searchoptions"] = array("value" => ":;".$str);
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
		$col["editrules"] = array("required"=>false);
		//$col["editoptions"] = array("maxlength" => "150", "size"=>200, "placeholder"=>"Masukan Dokumen Kontrak...");
		$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
		$cols[] = $col;
		
		
		
		$col = array();
		$col["title"] = "ID User Created";
		$col["name"] = "iduser_created";
		$col["editable"] = true;
		$col["hidden"] = true;
		$col["export"] = false;	
		$col["width"] = "200";
		$col["editoptions"] = array("maxlength" => "", "size"=>30, "placeholder"=>"Masukan ID User Created...");
		#$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Created";
		$col["name"] = "created";
		$col["search"] = true;
		$col["align"] = "left";
		$col["editable"] = true;
		$col["hidden"] = true;
		$col["export"] = false;	
		$col["width"] = "200";
		$col["editoptions"] = array("maxlength" => "", "size"=>30, "placeholder"=>"Masukan Created...");
		#$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
		$cols[] = $col;
		

		$g->set_columns($cols);
		$g->set_options($grid);

		
		$data['gridout'] = $g->render("list1");
		$this->load->model('Global_model');
		$head['collapse'] = false;
		$head['title'] = "Monitoring Proyek";
		$data['breadcrumbs'] = $this->Global_model->create_breadcrumbs(["Features","Monitoring Proyek"]);
		$this->load->view('layout/header',$head);
		$this->load->view('layout/sidebar');
		$this->load->view('grid_master',$data);
		$this->load->view('layout/footer');
	}

}
