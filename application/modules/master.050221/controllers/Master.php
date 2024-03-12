<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master extends CI_Controller {
	var $db_conf; 
	function __construct()
	{
		parent::__construct();
		if (!$this->ion_auth->logged_in()) redirect('auth/login', 'refresh');
		$this->db_conf = array(
			'type' => $this->db->dbdriver,
			'server' => $this->config->item('con_svr'),
			'user' => $this->db->username,
			'password' => $this->db->password,
			'database' => $this->db->database);
		$this->load->model('Global_model');
		$this->load->library('gridlibrary');
	}

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

	
	public function vendor()
	{
		if(in_array(177,$this->session->userdata('priv')) == FALSE) return redirect('403_override');
		$g = new jqgrid($this->db_conf);
		$caps = "Master Vendor TVRI";
		
		$grid["caption"] = $caps;
		$grid["height"] = "300"; 
		$grid["rowNum"] = 10; 
		$grid["rowList"] = array();$grid["viewrecords"] = true;
		$grid["rownumbers"] = true;
		$grid["sortname"] = 'idvendor'; 
		$grid["autowidth"] = true;
		$grid["shrinkToFit"] = false;
		$grid["forceFit"] = false;
		$grid["resizable"] = false;
		$grid["autoresize"] = true;
		$grid["responsive"] = true;
		$grid["multiselect"] = false; 
		$grid["rowactions"] = true; 
		$grid["toolbar"] = "both"; 
		$grid["add_options"] = array("width"=>"550");
		$grid["edit_options"] = array("width"=>"550");
		$grid["view_options"] = array("width"=>"550");
		$grid["export"] = array("format"=>"xls", "filename"=>$this->file_name, "sheetname"=>"master");
		
		$g->set_actions(array(
				"add"=>true,
				"edit"=>true,
				"delete"=>true,
				"rowactions"=>false,
				"export"=>true,
				"showhidecolumns"=>true,
				"autofilter" => true,
				"search" => false
			)
		);
		
		$g->select_command = "SELECT idvendor,nama,bentuk_usaha,npwp,kbli, nib, alamat,idprovinsi,idkabupaten,telp,fax, email, website FROM ms_vendor";
		$g->table = "ms_vendor";
		
		$col = array();
		$col["title"] = "ID";
		$col["name"] = "idvendor";
		$col["search"] = true;
		$col["editable"] = true;
		$col["hidden"] = true;
		$col["isnull"] = true;	
		$col["autoid"] = false;	
		$col["align"] = "center";
		$col["width"] = "120";
		// $col["formoptions"] = array("rowpos"=>"1", "colpos"=>"1");
		$cols[] = $col;
				
		$col = array();
		$col["title"] = "Nama Vendor";
		$col["name"] = "nama";
		$col["search"] = true;
		$col["editable"] = true;
		$col["width"] = "250";
		$col["editrules"] = array("required" => true);
		$col["editoptions"] = array("maxlength" => "100","size"=>65);
		// $col["formoptions"] = array("rowpos"=>"2", "colpos"=>"1");
		$col["visible"] = "lg+";
		$cols[] = $col; 
				
		$col = array();
		$col["title"] = "Bentuk/Badan<br>Usaha";
		$col["name"] = "bentuk_usaha";
		$col["search"] = true;
		$col["editable"] = true;
		$col["width"] = "180";
		$col["align"] = "center";
		$col["edittype"] = "select";
		$col["stype"] = "select";
		$col["formatter"] = "select";
		$col["searchoptions"] = array("value" =>"CV:CV;PT:PT;FIRMA:FIRMA;UD:UD;BUMN:BUMN;BUMD:BUMD;BUMS:BUMS;KOPERASI:KOPERASI;YAYASAN:YAYASAN;UKM:UKM;PERORANGAN:PERORANGAN;LAINNYA:LAINNYA");
		$col["editoptions"] = array("value" =>"CV:CV;PT:PT;FIRMA:FIRMA;UD:UD;BUMN:BUMN;BUMD:BUMD;BUMS:BUMS;KOPERASI:KOPERASI;YAYASAN:YAYASAN;UKM:UKM;PERORANGAN:PERORANGAN;LAINNYA:LAINNYA");
		// $col["formoptions"] = array("rowpos"=>"3", "colpos"=>"1");
		$col["editrules"] = array("required" => true);
		$col["visible"] = "xl";
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "N P W P";
		$col["name"] = "npwp";
		$col["search"] = true;
		$col["editable"] = true;
		$col["width"] = "150";
		$col["editoptions"] = array("maxlength" => "25", "size"=> "25");
		//$col["formoptions"] = array("rowpos"=>"9", "colpos"=>"1");
		// $col["editrules"] = array("required" => true);
		$col["editrules"] = array("required"=>true);  
  		$col["editoptions"] = array("onfocus"=>"set_mask_npwp(this)", "style"=>"text-align:left"); 
		//$col["visible"] = "md";
		$cols[] = $col;
			
		$col = array();
		$col["title"] = "KBLI";
		$col["name"] = "kbli";
		$col["search"] = true;
		$col["editable"] = true;
		$col["width"] = "100";
		$col["editoptions"] = array("maxlength" => "50");
		// $col["formoptions"] = array("rowpos"=>"5", "colpos"=>"1");
		$col["editrules"] = array("required" => true);
		$col["visible"] = "xl";
		$cols[] = $col;

		$col = array();
		$col["title"] = "N I B";
		$col["name"] = "nib";
		$col["search"] = true;
		$col["editable"] = true;
		$col["width"] = "100";
		$col["editoptions"] = array("maxlength" => "50");
		// $col["formoptions"] = array("rowpos"=>"5", "colpos"=>"1");
		//$col["editrules"] = array("required" => true);
		$col["visible"] = "xl";
		$cols[] = $col;
			
		//richtext
		$col = array();
		$col["title"] = "Alamat";
		$col["name"] = "alamat";
		$col["search"] = true;
		$col["editable"] = true;
		$col["width"] = "200";
		$col["edittype"] = "textarea"; 
		$col["editoptions"] = array("maxlength" => "255", "rows"=>"3", "cols"=>60);
		$col["editrules"] = array("required" => true);
		#$col["visible"] = "lg";
		$cols[] = $col; 
			
		$col = array();
		$col["title"] = "provinsi";
		$col["name"] = "idprovinsi";
		$col["width"] = "180";
		$col["search"] = true;
		$col["editable"] = true;
		$col["align"] = "left";
		$col["edittype"] = "select";
		$col["stype"] = "select";
		$col["formatter"] = "select"; 
		$str = $g->get_dropdown_values("SELECT DISTINCT idprovinsi AS k, nama_provinsi AS v  FROM ms_provinsi WHERE idprovinsi<>0 ORDER BY idprovinsi");
		$col["searchoptions"] = array("value" =>"0:NA;".$str, "separator" => ":", "delimiter" => ";");
		$col["editoptions"] = array("value" => "0:NA;".$str, 
										"separator" => ":", 
										"delimiter" => ";",
										"onchange" => array( "sql"=>"SELECT DISTINCT idkabupaten AS k, nama_kabupaten AS v  
																		FROM ms_kabupaten WHERE idkabupaten <>0 
																		AND idprovinsi={idprovinsi}
																		ORDER BY nama_kabupaten",
															"update_field" => "idkabupaten" )
										);
		// $col["formoptions"] = array("rowpos"=>"7", "colpos"=>"1");
		$col["editrules"] = array("required" => true);
		$col["visible"] = "xl";
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Kabupaten";
		$col["name"] = "idkabupaten";
		$col["width"] = "180";
		$col["search"] = true;
		$col["editable"] = true;
		$col["align"] = "left";
		$col["edittype"] = "select";
		$col["stype"] = "select";
		$col["formatter"] = "select";
		$str = $g->get_dropdown_values("SELECT DISTINCT idkabupaten AS k, nama_kabupaten AS v  FROM ms_kabupaten WHERE idkabupaten <>0 ORDER BY idkabupaten");
		$col["searchoptions"] = array("value" =>"0:NA;".$str, "separator" => ":", "delimiter" => ";");
		$col["editoptions"] = array("value" =>"0:NA;".$str, "separator" => ":", "delimiter" => ";" );
		// $col["formoptions"] = array("rowpos"=>"8", "colpos"=>"1");
		$col["editrules"] = array("required" => true);
		$col["visible"] = "xl";
		$cols[] = $col;
			
		$col = array();
		$col["title"] = "Telepon";
		$col["name"] = "telp";
		$col["search"] = true;
		$col["editable"] = true;
		$col["width"] = "180";
		$col["editoptions"] = array("maxlength" => "25");
		$col["formoptions"] = array("rowpos"=>"9", "colpos"=>"1");
		// $col["editrules"] = array("required" => true);
		$col["editrules"] = array("required"=>true);  
  		$col["editoptions"] = array("onfocus"=>"set_mask_telp(this)", "style"=>"text-align:left"); 
		$col["visible"] = "md";
		$cols[] = $col; 
			
		$col = array();
		$col["title"] = "Fax";
		$col["name"] = "fax";
		$col["search"] = true;
		$col["editable"] = true;
		$col["width"] = "180";
		$col["editoptions"] = array("maxlength" => "25");
		// $col["formoptions"] = array("rowpos"=>"10", "colpos"=>"1");
		$col["visible"] = "xl";
		$cols[] = $col; 
			
		$col = array();
		$col["title"] = "Email";
		$col["name"] = "email";
		$col["search"] = true;
		$col["editable"] = true;
		$col["isnull"] = true;
		$col["width"] = "180";
		$col["editoptions"] = array("maxlength" => "50","size"=>50);
		$col["editrules"] = array("email" => true,"required" => false);
		// $col["formoptions"] = array("rowpos"=>"11", "colpos"=>"1");
		$col["visible"] = "md";
		$cols[] = $col; 
			
		$col = array();
		$col["title"] = "Website";
		$col["name"] = "website";
		$col["search"] = true;
		$col["editable"] = true;
		$col["width"] = "180";
		$col["editoptions"] = array("maxlength" => "50","size"=>50);
		// $col["editrules"] = array("url" => true);
		// $col["formoptions"] = array("rowpos"=>"12", "colpos"=>"1");
		$col["visible"] = "xl";
		$cols[] = $col; 

		$g->set_columns($cols);
		$g->set_options($grid);

		$head['title'] = $caps;
		$data['breadcrumbs'] = $this->Global_model->create_breadcrumbs(["master","vendor"]);
		$data['fluid'] = true;
		$data['gridout'] = $g->render("list1");
		
		#helper_log();
		$this->load->view('layout/header',$head);
		$this->load->view('layout/sidebar');
		$this->load->view('v_master',$data);
		$this->load->view('layout/footer');
	}
	
	public function kantor()
	{
		
		$this->sizeInput=75;
		$g = new jqgrid($this->db_conf);
		$caps = "Kantor TVRI.Kantor Pusat. Daerah .Tranmisi";
		
		
		$this->load->model('Global_model');
		$data['jenis'] 		= $this->Global_model->get_data('ms_jenis_kantor','kode')->result();
		$data['kategori_kantor'] 		= $this->Global_model->get_data('ms_status_lahan','nama_status_lahan')->result();
		$head['collapse'] = false;
		$head['title'] = "Home";
		$data['breadcrumbs'] = $this->Global_model->create_breadcrumbs(["Master","Kantor TVRI"]);
		$this->load->view('layout/header',$head);
		$this->load->view('layout/sidebar');
		#$this->load->view('grid_master',$data);
		$this->load->view('map',$data);
		$this->load->view('layout/footer');
	}
	
	public function savekantor()
	{
		$this->load->model('General_model');
		//if($this->input->post('type')==1)
		//{
			$iddesa = $this->General_model->get_data('ms_desa', 'nama_desa', $this->input->post('administrative_area_level_4'), 'iddesa');
			$idprovinsi = $this->General_model->get_data('ms_provinsi', 'nama_provinsi', $this->input->post('administrative_area_level_1'), 'idprovinsi');
			$idkabupaten = $this->General_model->get_data('ms_kabupaten', 'nama_kabupaten', $this->input->post('administrative_area_level_2'), 'idkabupaten');
			$idkec = $this->General_model->get_data('ms_kecamatan', 'nama_kec', $this->input->post('administrative_area_level_3'), 'idkec');
			/*if($iddesa != ""){
				$idprovinsi = substr($iddesa, 0, 2);
				$idkabupaten = substr($iddesa, 0, 4);
				$idkec = substr($iddesa, 0, 7);
			}else{
				$idprovinsi = $this->General_model->get_data('ms_provinsi', 'nama_provinsi', $this->input->post('administrative_area_level_1'), 'idprovinsi');
				$idkabupaten = $this->General_model->get_data('ms_kabupaten', 'nama_kabupaten', $this->input->post('administrative_area_level_2'), 'idkabupaten');
				$idkec = $this->General_model->get_data('ms_kecamatan', 'nama_kec', $this->input->post('administrative_area_level_3'), 'idkec');
			}*/
			
			$data_lokasi = array(
					'nama_lokasi' => $this->input->post('kantor'),
					'latitude' => $this->input->post('lat'),
					'longitude' => $this->input->post('lng'),
					'alamat' => $this->input->post('alamat'),
					'jalan' => $this->input->post('route'),
					'jenis' => $this->input->post('kategori'),
					'status_lahan' => $this->input->post('status'),
					'no' => $this->input->post('street_number'),
					'plus_code' => $this->input->post('plus_code'),
					'kodepos' => $this->input->post('postal_code'),
					'idprovinsi' => $idprovinsi,
					'idkabupaten' => $idkabupaten,
					'idkec' => $idkec,
					'iddesa' => $iddesa
					);
					
			$data_lokasi_p = array(
					'nama_lokasi' => $this->input->post('kantor'),
					'latitude' => $this->input->post('lat')
					);
					
			$this->General_model->add('ms_lokasi_tvri', $data_lokasi_p);
			echo json_encode(array(
				"statusCode"=>200
			));
		#redirect('master/kantorList', 'refresh');
	}
	public function kantorList()
	{
		
		$this->sizeInput=75;
		$g = new jqgrid($this->db_conf);
		$caps = "Kantor TVRI.Kantor Pusat. Daerah .Transmisi";
		
		$col = array();
		$col["title"] = "ID Lokasi";
		$col["name"] = "idlokasi";
		$col["width"] = "40";
		$col["editable"] = true;
		$col["align"] = "center"; // this column is not editable
		$col["editrules"] = array("required"=>true); 
		#$col["editoptions"] = array("maxlength"=>2, "size"=>"10");
		$col["autoid"] = true;
		$col["hidden"] = true;
		$col["export"] = false;
		$cols[] = $col;

		$col = array();
		$col["title"] = "Nama Kantor";
		$col["name"] = "nama_lokasi";
		$col["width"] = "150";
		$col["align"] = "left";
		$col["editable"] = true;
		$col["editrules"] = array("required"=>true); 
		$col["editoptions"] = array("maxlength"=>240, "size"=>$this->sizeInput);
		$col["search"] = true;
		$col["editable"] = true;
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Status Lahan";
		$col["name"] = "status_lahan";
		$col["width"] = "100";
		$col["align"] = "left";
		$col["search"] = true;
		$col["editable"] = true;
		$col["edittype"] = "select"; // render as select
		$str = $g->get_dropdown_values("SELECT idstatuslahan AS k, nama_status_lahan AS v FROM ms_status_lahan where aktif='1' ORDER BY 2");
		$col["editoptions"] = array("value"=>":;".$str); 
		$col["formatter"] = "select"; // display label, not value
		$col["stype"] = "select"; // enable dropdown search
		$col["searchoptions"] = array("value" => ":;".$str);
		$col["editrules"] = array("required"=>true);
		$col["export"] = false;
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Status Lahan";
		$col["name"] = "nama_status";
		$col["width"] = "150";
		$col["align"] = "left";
		$col["hidden"] = true;
		$col["editrules"] = array("required"=>true); 
		$col["search"] = true;
		$col["editable"] = true;
		$cols[] = $col;
		
	

		$col = array();
		$col["title"] = "Aktif";
		$col["name"] = "aktif";
		$col["width"] = "50";
		$col["search"] = true;
		$col["editable"] = true;
		$col["align"] = "center";
		$col["edittype"] = "checkbox"; 
		$col["stype"] = "checkbox"; 
		$col["formatter"] = "checkbox";
		$col["editoptions"] = array("maxlength"=>1,"size"=>75,"value"=>"1:0","defaultValue"=>'1');
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "User Created";
		$col["name"] = "iduser_created";
		$col["search"] = false;
		$col["export"] = false;
		$col["editable"] = true;
		$col["hidden"] = true;
		$col["editoptions"] = array("defaultValue" => $this->session->userdata('user_id'));
		$cols[] = $col;

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
		$grid["add_options"] = array("width"=>"650");
		$grid["edit_options"] = array("width"=>"650");
		$grid["view_options"] = array("width"=>"650");
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
		
		$g->select_command = "SELECT idlokasi, nama_lokasi, status_lahan,  nama_status_lahan, ms_lokasi_tvri.aktif FROM ms_lokasi_tvri left join ms_status_lahan on ms_status_lahan.idstatuslahan=ms_lokasi_tvri.status_lahan ";
		$g->table = "ms_lokasi_tvri";
				
		
		 $g->set_columns($cols);
		$g->set_options($grid);

		
		$data['gridout'] = $g->render("list1");
		$this->load->model('Global_model');
		$head['collapse'] = false;
		$head['title'] = "Home";
		$data['breadcrumbs'] = $this->Global_model->create_breadcrumbs(["Master","Kantor TVRI"]);
		$this->load->view('layout/header',$head);
		$this->load->view('layout/sidebar');
		$this->load->view('grid_master',$data);
		#$this->load->view('map',$data);
		$this->load->view('layout/footer');
	}
	
	

	public function provinsi()
	{
		$this->sizeInput=75;
		$g = new jqgrid($this->db_conf);
		$caps = "Master Provinsi";
		
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
		$col["title"] = "Aktif";
		$col["name"] = "aktif";
		$col["width"] = "50";
		$col["search"] = true;
		$col["editable"] = true;
		$col["align"] = "center";
		$col["editrules"] = array("required"=>false); 
		$col["edittype"] = "checkbox"; 
		$col["stype"] = "checkbox"; 
		$col["formatter"] = "checkbox";
		$col["editoptions"] = array("maxlength"=>1,"size"=>75,"value"=>"1:0","defaultValue"=>'1');
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
		
		$g->select_command = "SELECT idprovinsi,nama_provinsi,aktif, tanggal_nonaktif FROM ms_provinsi";
		$g->table = "ms_provinsi";
				
		
		 $g->set_columns($cols);
		$g->set_options($grid);

		
		$head['title'] = $caps;
		$data['breadcrumbs'] = $this->Global_model->create_breadcrumbs(["Master","Wilayah (Propinsi - Desa)"]);
		$data['gridout'] = $g->render("list1");
		#helper_log();
		
		$this->load->view('layout/header',$head);
		$this->load->view('layout/sidebar');
		$this->load->view('grid_master',$data);
		$this->load->view('layout/footer');
	}
	
	public function kabupaten()
	{
		// if(in_array(177,$this->session->userdata('priv')) == FALSE) return redirect('403_override');
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
		
		$g->select_command = "SELECT idprovinsi,idkabupaten,nama_kabupaten,tanggal_nonaktif, populasi, aktif FROM ms_kabupaten $filter";
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
		$col["title"] = "Populasi Penduduk";
		$col["name"] = "populasi";
		$col["search"] = true;
		$col["editable"] = true;
		$col["width"] = "90";
		$col["editoptions"] = array("maxlength" => "9");
		$col["editrules"] = array("required"=>false); 
		$col["formatter"] = "currency";
			$col["formatoptions"] = array("prefix" => "",
                                "suffix" =>"",
                                "thousandsSeparator" => ".",
                                "decimalSeparator" => ",",
                                "decimalPlaces" => 0);
			$col["width"] = "150";
			$col["editrules"] = array("required"=>true);
			$col["editoptions"] = array("onfocus"=>"set_field_number0(this)", "maxlength" => "18", "size"=>40);
		$cols[] = $col; 
		
		$col = array();
		$col["title"] = "Aktif";
		$col["name"] = "aktif";
		$col["width"] = "50";
		$col["search"] = true;
		$col["editable"] = true;
		$col["align"] = "center";
		$col["editrules"] = array("required"=>false); 
		$col["edittype"] = "checkbox"; 
		$col["stype"] = "checkbox"; 
		$col["formatter"] = "checkbox";
		$col["editoptions"] = array("maxlength"=>1,"size"=>75,"value"=>"1:0","defaultValue"=>'1');
		$cols[] = $col;
		
		/*$col = array();
		$col["title"] = "Tgl Nonaltif";
		$col["name"] = "tanggal_nonaktif";
		$col["search"] = true;
		$col["editable"] = true;
		$col["formatter"] = "date"; 
		$col["formatoptions"] = array("srcformat"=>'Y-m-d',"newformat"=>'d-m-Y');
		$col["width"] = "120";
		$col["align"] = "center";
		$cols[] = $col;*/

		$g->set_columns($cols);
		$g->set_options($grid);

		$head['title'] = $caps;
		$data['breadcrumbs'] = $this->Global_model->create_breadcrumbs(["master","kabupaten"]);
		
		$data['gridout'] = $g->render("list1");
		if($idprovinsi){
			echo $data['gridout']; exit;
		}
		
		#helper_log();
		$this->load->view('layout/header',$head);
		$this->load->view('layout/sidebar');
		$this->load->view('grid_master',$data);
		$this->load->view('layout/footer');
	}
	
	public function kecamatan()
	{
		// if(in_array(177,$this->session->userdata('priv')) == FALSE) return redirect('403_override');
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
		
		$g->select_command = "SELECT idkec,idkabupaten,nama_kec, aktif FROM ms_kecamatan $filter";
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
		
		$col = array();
		$col["title"] = "Aktif";
		$col["name"] = "aktif";
		$col["width"] = "50";
		$col["search"] = true;
		$col["editable"] = true;
		$col["align"] = "center";
		$col["editrules"] = array("required"=>false); 
		$col["edittype"] = "checkbox"; 
		$col["stype"] = "checkbox"; 
		$col["formatter"] = "checkbox";
		$col["editoptions"] = array("maxlength"=>1,"size"=>75,"value"=>"1:0","defaultValue"=>'1');
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
		$data['breadcrumbs'] = $this->Global_model->create_breadcrumbs(["master","kecamatan"]);
		
		$data['gridout'] = $g->render("list1");
		if($idkabupaten){
			echo $data['gridout']; exit;
		}
		
		#helper_log();
		$this->load->view('layout/header',$head);
		$this->load->view('layout/sidebar');
		$this->load->view('grid_master',$data);
		$this->load->view('layout/footer');
	}
	
	public function kelurahan()
	{
		// if(in_array(177,$this->session->userdata('priv')) == FALSE) return redirect('403_override');
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
		
		$g->select_command = "SELECT iddesa,idkec,nama_desa, aktif FROM ms_desa $filter";
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
		
		$col = array();
		$col["title"] = "Aktif";
		$col["name"] = "aktif";
		$col["width"] = "50";
		$col["search"] = true;
		$col["editable"] = true;
		$col["align"] = "center";
		$col["editrules"] = array("required"=>false); 
		$col["edittype"] = "checkbox"; 
		$col["stype"] = "checkbox"; 
		$col["formatter"] = "checkbox";
		$col["editoptions"] = array("maxlength"=>1,"size"=>75,"value"=>"1:0","defaultValue"=>'1');
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
		$data['breadcrumbs'] = $this->Global_model->create_breadcrumbs(["master","kelurahan"]);
		
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
	
	public function kat_pengadaan()
	{
		if(in_array(3,$this->session->userdata('priv')) == FALSE) return redirect('404_override');
		$g = new jqgrid($this->db_conf);
		$caps = "Master Kategori Pengadaan";
		
		$grid["caption"] = $caps;
		// $grid["rowNum"] = 50; 
		// $grid["rowList"] = array(50,100,'All');
		$grid["height"] = ""; 
		$grid["rowNum"] = 20; 
		$grid["rowList"] = array();$grid["viewrecords"] = true;
		$grid["rownumbers"] = true;
		$grid["sortname"] = 'idpengadaan'; 
		$grid["autowidth"] = true;
		$grid["shrinkToFit"] = true;
		$grid["forceFit"] = false;
		$grid["resizable"] = false;
		$grid["autoresize"] = false;
		$grid["multiselect"] = false; 
		$grid["rowactions"] = true; 
		$grid["toolbar"] = "both"; 
		$grid["add_options"] = array("width"=>"460");
		$grid["edit_options"] = array("width"=>"460");
		$grid["view_options"] = array("width"=>"460");
		$grid["export"] = array("format"=>"xls", "filename"=>$this->file_name, "sheetname"=>"master");
		
		$g->set_actions(array(
				"add"=>true,
				"edit"=>true,
				"delete"=>true,
				"rowactions"=>false,
				"export"=>true,
				"autofilter" => true,
				"search" => false
			)
		);
		
		$g->select_command = "SELECT idpengadaan,kategori,created FROM ms_katpengadaan";
		$g->table = "ms_katpengadaan";
		
		$col = array();
		$col["title"] = "ID";
		$col["name"] = "idpengadaan";
		$col["search"] = true;
		$col["editable"] = true;
		$col["hidden"] = true;
		$col["isnull"] = true;	
		$col["autoid"] = false;	
		$col["align"] = "center";
		$col["width"] = "120";
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Kategori";
		$col["name"] = "kategori";
		$col["search"] = true;
		$col["editable"] = true;
		$col["editoptions"] = array("maxlength" => "50");
		$col["editrules"] = array("required"=>true); 
		$col["width"] = "250";
		$cols[] = $col; 
		
		$col = array();
		$col["title"] = "Tgl Input";
		$col["name"] = "created";
		$col["search"] = true;
		$col["editable"] = false;
		$col["align"] = "center";
		$col["formatter"] = "date"; 
		$col["formatoptions"] = array("srcformat"=>'Y-m-d',"newformat"=>'d-m-Y');
		$col["width"] = "120";
		$cols[] = $col;

		$g->set_columns($cols);
		$g->set_options($grid);

		$head['title'] = $caps;
		$data['breadcrumbs'] = $this->Global_model->create_breadcrumbs(["master","kategori pengadaan"]);
		$data['gridout'] = $g->render("list1");
		
		#helper_log();
		$this->load->view('layout/header',$head);
		$this->load->view('layout/sidebar');
		$this->load->view('grid_master',$data);
		$this->load->view('layout/footer');
	}
	
	public function kanal()
	{
		
		$this->sizeInput=75;
		$g = new jqgrid($this->db_conf);
		$caps = "Kanal Siaran Sesuai Peraturan Menteri";
		
		$col = array();
		$col["title"] = "ID Kanal";
		$col["name"] = "id_kanal";
		$col["width"] = "40";
		$col["editable"] = true;
		$col["hidden"] = true;
		$col["align"] = "center"; // this column is not editable
		$col["autoid"] = true;
		$col["isnull"] = true;
		$col["export"] = false;
		$cols[] = $col;

		$col = array();
		$col["title"] = "Channel";
		$col["name"] = "channel";
		$col["width"] = "150";
		$col["align"] = "left";
		$col["editable"] = true;
		$col["editrules"] = array("required"=>true); 
		$col["editoptions"] = array("maxlength"=>3, "size"=>"10");
		$col["search"] = true;
		$col["editable"] = true;
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Frequency";
		$col["name"] = "frequency";
		$col["width"] = "150";
		$col["align"] = "left";
		$col["editable"] = true;
		$col["editrules"] = array("required"=>true); 
		$col["editoptions"] = array("maxlength"=>4, "size"=>"20");
		$col["search"] = true;
		$col["editable"] = true;
		$cols[] = $col;

		$col = array();
		$col["title"] = "Aktif";
		$col["name"] = "aktif";
		$col["width"] = "50";
		$col["search"] = true;
		$col["editable"] = true;
		$col["align"] = "center";
		$col["editrules"] = array("required"=>false); 
		$col["edittype"] = "checkbox"; 
		$col["stype"] = "checkbox"; 
		$col["formatter"] = "checkbox";
		$col["editoptions"] = array("maxlength"=>1,"size"=>75,"value"=>"1:0","defaultValue"=>'1');
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "User Created";
		$col["name"] = "iduser_created";
		$col["search"] = false;
		$col["export"] = false;
		$col["editable"] = true;
		$col["hidden"] = true;
		$col["editoptions"] = array("defaultValue" => $this->session->userdata('user_id'));
		$cols[] = $col;

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
		$grid["add_options"] = array("width"=>"650");
		$grid["edit_options"] = array("width"=>"650");
		$grid["view_options"] = array("width"=>"650");
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
				
		
		 $g->set_columns($cols);
		$g->set_options($grid);

		
		$data['gridout'] = $g->render("list1");
		$this->load->model('Global_model');
		$head['collapse'] = false;
		$head['title'] = "Home";
		$data['breadcrumbs'] = $this->Global_model->create_breadcrumbs(["Master","Kanal Siaran"]);
		$this->load->view('layout/header',$head);
		$this->load->view('layout/sidebar');
		$this->load->view('grid_master',$data);
		$this->load->view('layout/footer');
	}
	
	function arealayanan() {
		if (!$this->ion_auth->logged_in()) redirect('auth/login', 'refresh');
		if(in_array(32,$this->session->userdata('priv')) == FALSE) return redirect('404_override');
		$g = new jqgrid($this->db_conf);
		$caps = "Wilayah Layanan TVRI";
		
		
		$grid["caption"] = $caps;
		$grid["rowNum"] = 20; 
		$grid["rowList"] = array(20,40,100,'All');
		$grid["rownumbers"] = true;
		$grid["sortname"] = 'id'; 
		$grid["autowidth"] = true;
		$grid["shrinkToFit"] = true;
		$grid["forceFit"] = false; 
		$grid["resizable"] = true;
		$grid["autoresize"] = false;
		$grid["multiselect"] = false; 
		$grid["toolbar"] = "top";
		$grid["footerrow"] = true;		
		$grid["height"] = ""; 
		$grid["add_options"] = array("width"=>"850");
		$grid["edit_options"] = array("width"=>"850");
		$grid["view_options"] = array("width"=>"700");
		$grid["export"] = array("filename"=>"AreaLayanan", "heading"=>"Daftar Area Layanan TVRI", "orientation"=>"landscape", "paper"=>"A4");
		$grid["loadComplete"] = "function(){ do_loadmore(); }";
		
		$grid["subGrid"] = false; 
		#$grid["subgridurl"] = "srttugas_setkolektif";
		#$grid["subgridparams"] = "id, kepada, tanggal, nomor";
		$grid["delete_options"] = array('width'=>'', 'msg'=>'<div id="custom_msg">Delete selected record(s)?</div>');
		$grid["delete_options"]["afterShowForm"] = 'function(rid) {
							var selr = jQuery("#list1").jqGrid("getGridParam","selrow");
							var value = $("#list1").jqGrid("getCell", selr, "nomor");
							var str = "";
							if(value) str = "<b>Nomor</b> : "+value;
							$("#custom_msg").html( "Are you sure you want to delete the rowIdx#" + selr.toString() + "?<br>"+str.toString()); 
		}';
		$g->set_actions(array(
				"add"=>true,
				"edit"=>true,
				"delete"=>true,
				"rowactions"=>false,
				"autofilter" => true,
				"search" => "advance"
			)
		);
		
		
		
		$g->select_command = "SELECT id, wilayah_layanan, area_layanan, (SELECT GROUP_CONCAT(nama_kabupaten SEPARATOR ', ') FROM ms_kabupaten WHERE FIND_IN_SET(idkabupaten,ms_area_layanan.area_layanan) <> 0 ) as labellayanan
		FROM ms_area_layanan ";
		$g->table = "ms_area_layanan";
				
		$col = array();
		$col["title"] = "ID";
		$col["name"] = "id";
		$col["search"] = true;
		$col["align"] = "center";
		$col["editable"] = true;
		$col["hidden"] = true;
		$col["isnull"] = true;	
		$col["autoid"] = false;	
		$col["export"] = false;	
		$col["export"] = false;	
		$col["formoptions"] = array("rowpos"=>"1", "colpos"=>"1"); 
		array("list"=>false,"edit"=>true,"add"=>true,"view"=>false);
		$cols[] = $col;	
		
		$col = array();
		$col["title"] = "Nama Wilayah";
		$col["name"] = "wilayah_layanan";
		$col["search"] = true;
		$col["editable"] = true;
		$col["width"] = "70";
		$col["editoptions"] = array("maxlength" => "100","size"=>50, "placeholder"=>"Wilayah Layanan");
		$col["editrules"] = array("required"=>true);
		$cols[] = $col;
			
		$col = array();
		$col["title"] = "Wilayah Layanan (Kab/Kota)";
		$col["name"] = "area_layanan";
		$col["width"] = "290";
		$col["align"] = "left";
		$col["search"] = false;$col["export"] = false;
		$col["editable"] = true;
		$col["formatter"] = "select";
		$col["edittype"] = "select"; 
		$str = $g->get_dropdown_values("SELECT DISTINCT idkabupaten AS k, nama_kabupaten AS v 
																		FROM ms_kabupaten
																		WHERE aktif='1'
																		ORDER BY 2");
		$col["editoptions"] = array("value"=>$str);
		$col["editoptions"]["dataInit"] = "function(){ setTimeout(function(){ link_select2('{$col["name"]}'); },200); }";
		$col["editoptions"]["multiple"] = true;
		$col["editoptions"]["size"] = 20;
		$col["editoptions"]["rows"] = 5;
		$col["editrules"] = array("required"=>true); 
		$col["stype"] = "select"; 
		$col["searchoptions"] = array("value"=>$str,"sopt"=>array("cn")); 
		$col["searchoptions"]["dataInit"] = "function(){ setTimeout(function(){ link_select2('gs_{$col["name"]}'); },200); }";
		$col["show"] = array("list"=>false,"edit"=>true,"add"=>true,"view"=>false);
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Area Layanan (Kab/Kota)";
		$col["name"] = "labellayanan";
		$col["width"] = "200";
		$col["align"] = "left";
		$col["search"] = true;$col["export"] = true; 
		$col["editable"] = false;
		$col["show"] = array("list"=>true,"edit"=>false,"add"=>false,"view"=>true);
		$col["formatter"] = "function(cellval,options,rowdata){ return '<div class=\"readmore\">'+cellval+'</div>'; }";
		$col["unformat"] = "function(cellval,options,cell){ if(cellval == 'undefined') return ''; return jQuery(cell).children('div').html(); }";
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "User Created";
		$col["name"] = "iduser_created";
		$col["search"] = false;
		$col["export"] = false;
		$col["editable"] = true;
		$col["hidden"] = true;
		$col["editoptions"] = array("defaultValue" => $this->session->userdata('user_id'));
		$cols[] = $col;
		
		$g->set_columns($cols);
		$g->set_options($grid);
		
		

		$head['title'] = $caps;
		$head['collapse'] = true;
		$data['breadcrumbs'] = $this->Global_model->create_breadcrumbs(["Master","Area Layanan"]);
		
		$data['gridout'] = $g->render("list1");
		$data['page'] = "srttugas";
		$data['date_start'] = $date_start;
		$data['date_end'] = $date_end;
		#helper_log();
		$this->load->view('layout/header',$head);
		$this->load->view('layout/sidebar');
		$this->load->view('grid_master_tag',$data);
		$this->load->view('layout/footer');
	}
	
	public function unitkerja(){

		if (!$this->ion_auth->logged_in()) redirect('auth/login', 'refresh');
		if(in_array(32,$this->session->userdata('priv')) == FALSE) return redirect('404_override');
		$g = new jqgrid($this->db_conf);
		$caps = "Wilayah Layanan TVRI";
		
		$grid["caption"] = $this->caption;
		$grid["autowidth"] = true;
		$grid["height"] = 'auto';
		$grid["sortname"] = 'kd_unitkerja';
        $grid["add_options"] = array("width"=>"650");
		$grid["edit_options"] = array("width"=>"650");
		$grid["view_options"] = array("width"=>"650");

		$grid["treeGrid"]=true;
		$grid["treeConfig"] = array('id'=>'kd_unitkerja', 'parent'=>'parent', 'loaded'=>true, 'column'=>'nama_unitkerja');
		$g->set_options($grid);

		$g->select_command = "select * from m_unitkerja";
		$g->table = "m_unitkerja";
		
		$col = array();
		$col["title"] = "ID Unit Kerja";
		$col["name"] = "kd_unitkerja";
		$col["hidden"] = true;
		$col["editable"] = false;
		$col["align"] = "center";
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Nama Unit Kerja";
		$col["name"] = "nama_unitkerja";
		$col["width"] = "400";
		$col["align"] = "left";
		$col["editable"] = true;
		$col["editoptions"] = array("maxlength"=>240, "size"=>$this->sizeInput);
		$col["search"] = true;
		$col["editable"] = true;
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Aktif";
		$col["name"] = "status";
		$col["width"] = "90";
		$col["search"] = true;
		$col["editable"] = true;
		$col["align"] = "center";
		$col["editrules"] = array("required"=>false); 
		$col["edittype"] = "checkbox"; 
		$col["stype"] = "checkbox"; 
		$col["formatter"] = "checkbox";
		$col["editoptions"] = array("size"=>1,"value"=>"1:0","defaultValue"=>'1');
		$cols[] = $col;
		
		$g->set_columns($cols);
		$g->set_options($grid);
		
		

		$head['title'] = $caps;
		$head['collapse'] = true;
		$data['breadcrumbs'] = $this->Global_model->create_breadcrumbs(["Master","Area Layanan"]);
		
		$data['gridout'] = $g->render("list1");
		$data['page'] = "srttugas";
		$data['date_start'] = $date_start;
		$data['date_end'] = $date_end;
		#helper_log();
		$this->load->view('layout/header',$head);
		$this->load->view('layout/sidebar');
		$this->load->view('grid_master',$data);
		$this->load->view('layout/footer');
	}
	
	public function satker()
	{
		$this->sizeInput=75;
		$g = new jqgrid($this->db_conf);
		$caps = "Master Satuan Kerja";
		
		$col = array();
		$col["title"] = "ID";
		$col["name"] = "iddirektorat";
		//$col["editoptions"] = array("maxlength" => "2");
		$col["search"] = true;
		$col["editable"] = true;
		 $col["hidden"] = false;
		$col["isnull"] = false;	
		$col["autoid"] = true;	
		$col["align"] = "center";
		$col["width"] = "40";
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Nama Satuan Kerja";
		$col["name"] = "nama_direktorat";
		$col["editoptions"] = array("maxlength" => "160","size"=>50);
		$col["search"] = true;
		$col["editable"] = true;
		$col["editrules"] = array("required"=>true); 
		$col["width"] = "350";
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "User Created";
		$col["name"] = "iduser_created";
		$col["search"] = false;
		$col["export"] = false;
		$col["editable"] = true;
		$col["hidden"] = true;
		$col["editoptions"] = array("defaultValue" => $this->session->userdata('user_id'));
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Aktif";
		$col["name"] = "aktif";
		$col["width"] = "50";
		$col["search"] = true;
		$col["editable"] = true;
		$col["align"] = "center";
		$col["editrules"] = array("required"=>false); 
		$col["edittype"] = "checkbox"; 
		$col["stype"] = "checkbox"; 
		$col["formatter"] = "checkbox";
		$col["editoptions"] = array("maxlength"=>1,"size"=>75,"value"=>"1:0","defaultValue"=>'1');
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Parent ID";
		$col["name"] = "parent_id";
		$col["search"] = false;
		$col["export"] = false;
		$col["editable"] = true;
		$col["hidden"] = true;
		$col["editoptions"] = array("defaultValue" => '0');
		$cols[] = $col;
		
		

		$grid["caption"] = $caps;
		$grid["rowNum"] = 20; 
		$grid["rowList"] = array(20,40,100,'All');
		$grid["rownumbers"] = true;
		$grid["sortname"] = 'nama_direktorat'; 
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
		$grid["add_options"] = array("width"=>"470");
		$grid["edit_options"] = array("width"=>"470");
		$grid["view_options"] = array("width"=>"470");
		$grid["export"] = array("format"=>"xls", "filename"=>$this->file_name, "sheetname"=>"master");
		
		$grid["subGrid"] = true; 
		$grid["subgridurl"] = "bidang";
		$grid["subgridparams"] = "iddirektorat, nama_direktorat";
		
		
		$g->set_actions(array(
				"add"=>true,
				"edit"=>true,
				"delete"=>true,
				"rowactions"=>false,
				"export"=>true,
				"autofilter" => true,
				"search" => false
			)
		);
		
		$g->select_command = "SELECT iddirektorat, nama_direktorat, aktif  FROM ms_direktorat  ";
		$g->table = "ms_direktorat";
				
		
		 $g->set_columns($cols);
		$g->set_options($grid);

		
		$head['title'] = $caps;
		$data['breadcrumbs'] = $this->Global_model->create_breadcrumbs(["Master","Satker"]);
		$data['gridout'] = $g->render("list1");
		#helper_log();
		
		$this->load->view('layout/header',$head);
		$this->load->view('layout/sidebar');
		$this->load->view('grid_master',$data);
		$this->load->view('layout/footer');
	}
	
	public function bidang()
	{
		#if(in_array(177,$this->session->userdata('priv')) == FALSE) return redirect('403_override');
		$g = new jqgrid($this->db_conf);
		$caps = "Master Bidang";
		
		$direktorat= $_REQUEST['iddirektorat'];
		$nama_satker = $_REQUEST["nama_direktorat"];
		if(isset($direktorat)){
			$caps .= ", ".$nama_satker;			
			#$filter = "WHERE direktorat='$direktorat' ";	
			$grid["subGrid"] = true; 
			$grid["subgridurl"] = "seksi";
			$grid["subgridparams"] = "idbidang, nama_bidang";
		}
		
		
		$grid["caption"] = $caps;
		$grid["rowNum"] = 20; 
		$grid["rowList"] = array(20,40,100,'All');
		$grid["rownumbers"] = true;
		$grid["sortname"] = 'idbidang'; 
		$grid["autowidth"] = true;
		$grid["shrinkToFit"] = true;
		$grid["forceFit"] = false;
		$grid["resizable"] = true;
		$grid["autoresize"] = false;
		$grid["multiselect"] = false; 
		$grid["rowactions"] = true; 
		$grid["toolbar"] = "both"; 
		$grid["height"] = ""; 
		$grid["add_options"] = array("width"=>"650");
		$grid["edit_options"] = array("width"=>"650");
		$grid["view_options"] = array("width"=>"650");
		$grid["export"] = array("format"=>"xls", "filename"=>$this->file_name, "sheetname"=>"master");
		
		$g->set_actions(array(
				"add"=>true,
				"edit"=>true,
				"delete"=>true,
				"rowactions"=>false,
				"export"=>true,
				"autofilter" => true,
				"search" => false
			)
		);
		
		#$g->select_command = "SELECT iddirektorat, nama_direktorat,aktif, parent_id  FROM ms_direktorat where   parent_id='$direktorat' ";
		#$g->table = "ms_direktorat";
		
			$g->select_command = "SELECT idbidang, iddirektorat, nama_bidang, aktif  FROM ms_bidang where   iddirektorat='$direktorat' ";
		$g->table = "ms_bidang";
		
		$col = array();
		$col["title"] = "ID";
		$col["name"] = "idbidang";
		$col["search"] = true;
		$col["editable"] = true;
		$col["hidden"] = false;
		$col["autoid"] = false;	
		$col["align"] = "center";
		$col["width"] = "50";
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Nama Bidang";
		$col["name"] = "nama_bidang";
		$col["search"] = true;
		$col["editable"] = true;
		$col["width"] = "180";
		$col["editoptions"] = array("maxlength" => "150","size"=>75);
		$col["editrules"] = array("required"=>true); 
		$cols[] = $col; 
		
		$col = array();
		$col["title"] = "Parent ID";
		$col["name"] = "iddirektorat";
		$col["search"] = false;
		$col["export"] = false;
		$col["editable"] = true;
		$col["hidden"] = true;
		$col["editoptions"] = array("defaultValue" => $direktorat);
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "User Created";
		$col["name"] = "iduser_created";
		$col["search"] = false;
		$col["export"] = false;
		$col["editable"] = true;
		$col["hidden"] = true;
		$col["editoptions"] = array("defaultValue" => $this->session->userdata('user_id'));
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Aktif";
		$col["name"] = "aktif";
		$col["width"] = "50";
		$col["search"] = true;
		$col["editable"] = true;
		$col["align"] = "center";
		$col["editrules"] = array("required"=>false); 
		$col["edittype"] = "checkbox"; 
		$col["stype"] = "checkbox"; 
		$col["formatter"] = "checkbox";
		$col["editoptions"] = array("maxlength"=>1,"size"=>75,"value"=>"1:0","defaultValue"=>'1');
		$cols[] = $col;
		
		

		$g->set_columns($cols);
		$g->set_options($grid);

		$head['title'] = $caps;
		
		$data['gridout'] = $g->render("list1");
		if($idprovinsi){
			echo $data['gridout']; exit;
		}
		
		$this->load->view('layout/header',$head);
		$this->load->view('grid_master',$data);
	}
	
	public function seksi()
	{
		if(in_array(177,$this->session->userdata('priv')) == FALSE) return redirect('403_override');
		$g = new jqgrid($this->db_conf);
		$caps = "Master SATKER Seksi";
		
		$idbidang= $_REQUEST['idbidang'];
		$nama_bidang = $_REQUEST["nama_bidang"];
		if($idbidang){
			$caps .= ", Bidang ".$nama_bidang;			
			$filter = "WHERE idbidang = '$idbidang' ";	
			$grid["subGrid"] = false; 
		}
		
		
		$grid["caption"] = $caps;
		$grid["rowNum"] = 50; 
		$grid["rowList"] = array(50,100,200,'All');
		$grid["rownumbers"] = true;
		$grid["sortname"] = 'idseksi'; 
		$grid["autowidth"] = true;
		$grid["shrinkToFit"] = true;
		$grid["forceFit"] = false;
		$grid["resizable"] = true;
		$grid["autoresize"] = false;
		$grid["multiselect"] = false; 
		$grid["rowactions"] = true; 
		$grid["toolbar"] = "both"; 
		$grid["height"] = ""; 
		$grid["add_options"] = array("width"=>"650");
		$grid["edit_options"] = array("width"=>"650");
		$grid["view_options"] = array("width"=>"650");
		$grid["export"] = array("format"=>"xls", "filename"=>$this->file_name, "sheetname"=>"master");
		
		$g->set_actions(array(
				"add"=>true,
				"edit"=>true,
				"delete"=>true,
				"rowactions"=>false,
				"export"=>true,
				"autofilter" => true,
				"search" => false
			)
		);
		$g->select_command = "SELECT idseksi, idbidang, nama_seksi, aktif  FROM ms_seksi $filter  ";
		$g->table = "ms_seksi";
		
		$col = array();
		$col["title"] = "ID";
		$col["name"] = "idseksi";
		$col["search"] = true;
		$col["editable"] = true;
		$col["hidden"] = false;
		$col["autoid"] = false;	
		$col["align"] = "center";
		$col["width"] = "50";
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Bidang";
		$col["name"] = "idbidang";
		$col["search"] = false;
		$col["export"] = false;
		$col["editable"] = true;
		$col["hidden"] = true;
		$col["editoptions"] = array("defaultValue" => $idbidang);
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Nama Seksi/Subbagian";
		$col["name"] = "nama_seksi";
		$col["search"] = true;
		$col["editable"] = true;
		$col["width"] = "180";
		$col["editoptions"] = array("maxlength" => "150","size"=>75);
		$col["editrules"] = array("required"=>true); 
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "User Created";
		$col["name"] = "iduser_created";
		$col["search"] = false;
		$col["export"] = false;
		$col["editable"] = true;
		$col["hidden"] = true;
		$col["editoptions"] = array("defaultValue" => $this->session->userdata('user_id'));
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Aktif";
		$col["name"] = "aktif";
		$col["width"] = "50";
		$col["search"] = true;
		$col["editable"] = true;
		$col["align"] = "center";
		$col["editrules"] = array("required"=>false); 
		$col["edittype"] = "checkbox"; 
		$col["stype"] = "checkbox"; 
		$col["formatter"] = "checkbox";
		$col["editoptions"] = array("maxlength"=>1,"size"=>75,"value"=>"1:0","defaultValue"=>'1');
		$cols[] = $col;
		
		$g->set_columns($cols);
		$g->set_options($grid);

		$head['title'] = $caps;
		
		$data['gridout'] = $g->render("list1");
		if($idkabupaten){
			echo $data['gridout']; exit;
		}
		$this->load->view('layout/header',$head);
		$this->load->view('grid_master',$data);
	}

	public function polarisasi()
	{
		$this->load->library('gridlibrary');
		$g = new jqgrid($this->db_conf);
		$caps = "Master Polarisasi";
		
		$grid["caption"] = $caps;
		$grid["height"] = "300"; 
		$grid["rowNum"] = 10; 
		$grid["rowList"] = array();$grid["viewrecords"] = true;
		$grid["rownumbers"] = true;
		$grid["sortname"] = 'id_polarisasi'; 
		$grid["autowidth"] = true;
		$grid["shrinkToFit"] = false;
		$grid["forceFit"] = false;
		$grid["resizable"] = false;
		$grid["autoresize"] = true;
		$grid["responsive"] = true;
		$grid["multiselect"] = false; 
		$grid["rowactions"] = true; 
		$grid["toolbar"] = "both"; 
		$grid["add_options"] = array("width"=>"550");
		$grid["edit_options"] = array("width"=>"550");
		$grid["view_options"] = array("width"=>"550");
		$grid["export"] = array("format"=>"xls", "filename"=>$this->file_name, "sheetname"=>"master_polarisasi");
		
		$g->set_actions(array(
				"add"=>true,
				"edit"=>true,
				"delete"=>true,
				"rowactions"=>false,
				"export"=>true,
				"showhidecolumns"=>false,
				"autofilter" => true,
				"search" => false
			)
		);
		
		$g->select_command = "SELECT id_polarisasi,nama_polarisasi,aktif,created,iduser_created FROM ms_polarisasi";	
		$g->table = "ms_polarisasi";
		
		$col = array();
		$col["title"] = "ID";
		$col["name"] = "id_polarisasi";
		$col["editable"] = true;
		$col["hidden"] = true;
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Nama Polarisasi";
		$col["name"] = "nama_polarisasi";
		$col["editoptions"] = array("maxlength" => "24", "size" =>"25");
		$col["search"] = true;
		$col["editable"] = true;
		$col["editrules"] = array("required"=>true); 
		$col["hidden"] = false;
		$col["isnull"] = true;	
		$col["autoid"] = false;	
		$col["align"] = "left";
		$col["width"] = "300";
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Aktif";
		$col["name"] = "aktif";
		$col["width"] = "150";
		$col["search"] = true;
		$col["editable"] = true;
		$col["align"] = "center";
		$col["editrules"] = array("required"=>false); 
		$col["edittype"] = "checkbox"; 
		$col["stype"] = "checkbox"; 
		$col["formatter"] = "checkbox";
		$col["editoptions"] = array("maxlength"=>1,"size"=>75,"value"=>"1:0","defaultValue"=>'1');
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Created";
		$col["name"] = "created"; 
		$col["align"] = "center";
		$col["width"] = "300";
		$col["editable"] = true; 
		$col["formatoptions"] = array("srcformat"=>'Y-m-d H:i:s',"newformat"=>'d-m-Y H:i:s',"opts" => array());
		$col["show"] = array("list"=>false,"edit"=>false,"add"=>false,"view"=>true);
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "User Created";
		$col["name"] = "iduser_created";
		$col["search"] = false;
		$col["export"] = false;
		$col["editable"] = true;
		$col["hidden"] = true;
		$col["editoptions"] = array("defaultValue" => $this->session->userdata('user_id'));
		$cols[] = $col;
		
 
		$g->set_columns($cols);
		$g->set_options($grid);

		$head['title'] = $caps;
		$data['breadcrumbs'] = $this->Global_model->create_breadcrumbs(["master","polarisasi"]);
		$data['fluid'] = true;
		$data['gridout'] = $g->render("list1");
		
		$this->load->view('layout/header',$head);
		$this->load->view('layout/sidebar');
		$this->load->view('grid_master',$data);
		$this->load->view('layout/footer');
	}
	
	public function plot_pattern()
	{
		$this->load->library('gridlibrary');
		$g = new jqgrid($this->db_conf);
		$caps = "Master Plot Pettern";
		
		$grid["caption"] = $caps;
		$grid["height"] = "300"; 
		$grid["rowNum"] = 10; 
		$grid["rowList"] = array();$grid["viewrecords"] = true;
		$grid["rownumbers"] = true;
		$grid["sortname"] = 'id_pp'; 
		$grid["autowidth"] = true;
		$grid["shrinkToFit"] = false;
		$grid["forceFit"] = false;
		$grid["resizable"] = false;
		$grid["autoresize"] = true;
		$grid["responsive"] = true;
		$grid["multiselect"] = false; 
		$grid["rowactions"] = true; 
		$grid["toolbar"] = "both"; 
		$grid["add_options"] = array("width"=>"550");
		$grid["edit_options"] = array("width"=>"550");
		$grid["view_options"] = array("width"=>"550");
		$grid["export"] = array("format"=>"xls", "filename"=>$this->file_name, "sheetname"=>"master_plot_pattern");
		
		$g->set_actions(array(
				"add"=>true,
				"edit"=>true,
				"delete"=>true,
				"rowactions"=>true,
				"export"=>true,
				"showhidecolumns"=>false,
				"autofilter" => true,
				"search" => false
			)
		);
		
		$g->select_command = "SELECT * FROM  ms_plot_pattern";	
		$g->table = "ms_plot_pattern";
		
		$col = array();
		$col["title"] = "ID";
		$col["name"] = "id_pp";
		$col["editable"] = true;
		$col["hidden"] = true;
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Kode PP";
		$col["name"] = "kode_pp";
		$col["editoptions"] = array("maxlength" => "8", "size" => "9");
		$col["search"] = true;
		$col["editable"] = true;
		$col["hidden"] = false;
		$col["isnull"] = true;	
		$col["autoid"] = false;	
		$col["align"] = "center";
		$col["width"] = "300";
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Aktif";
		$col["name"] = "aktif";
		$col["width"] = "150";
		$col["search"] = true;
		$col["editable"] = true;
		$col["align"] = "center";
		$col["editrules"] = array("required"=>false); 
		$col["edittype"] = "checkbox"; 
		$col["stype"] = "checkbox"; 
		$col["formatter"] = "checkbox";
		$col["editoptions"] = array("maxlength"=>1,"size"=>75,"value"=>"1:0","defaultValue"=>'1');
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "User Created";
		$col["name"] = "iduser_created";
		$col["search"] = false;
		$col["export"] = false;
		$col["editable"] = true;
		$col["hidden"] = true;
		$col["editoptions"] = array("defaultValue" => $this->session->userdata('user_id'));
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Created";
		$col["name"] = "created"; 
		$col["align"] = "center";
		$col["width"] = "300";
		$col["hidden"] = true;
		$col["editable"] = true; 
		$col["formatoptions"] = array("srcformat"=>'Y-m-d H:i:s',"newformat"=>'d-m-Y H:i:s',"opts" => array());
		$cols[] = $col;
 
		$g->set_columns($cols);
		$g->set_options($grid);

		$head['title'] = $caps;
		$data['breadcrumbs'] = $this->Global_model->create_breadcrumbs(["master","plot pattern"]);
		$data['fluid'] = true;
		$data['gridout'] = $g->render("list1");
		
		$this->load->view('layout/header',$head);
		$this->load->view('layout/sidebar');
		$this->load->view('grid_master',$data);
		$this->load->view('layout/footer');
	}

	public function fft_size()
	{
		$this->load->library('gridlibrary');
		$g = new jqgrid($this->db_conf);
		$caps = "Master FFT Size";
		
		$grid["caption"] = $caps;
		$grid["height"] = "300"; 
		$grid["rowNum"] = 10; 
		$grid["rowList"] = array();
		$grid["viewrecords"] = true;
		$grid["rownumbers"] = true;
		$grid["sortname"] = 'id_fft'; 
		$grid["autowidth"] = true;
		$grid["shrinkToFit"] = false;
		$grid["forceFit"] = false;
		$grid["resizable"] = false;
		$grid["autoresize"] = true;
		$grid["responsive"] = true;
		$grid["multiselect"] = false; 
		$grid["rowactions"] = true; 
		$grid["toolbar"] = "both"; 
		$grid["add_options"] = array("width"=>"550");
		$grid["edit_options"] = array("width"=>"550");
		$grid["view_options"] = array("width"=>"550");
		$grid["export"] = array("format"=>"xls", "filename"=>$this->file_name, "sheetname"=>"master_fft_size");
		
		$g->set_actions(array(
				"add"=>true,
				"edit"=>true,
				"delete"=>true,
				"rowactions"=>false, 
				"export"=>true,
				"showhidecolumns"=>false,
				"autofilter" => true,
				"search" => false
			)
		);
		
		$g->select_command = "SELECT * FROM ms_fft";		
		$g->table = "ms_fft";
		
		$col = array();
		$col["title"] = "ID";
		$col["name"] = "id_fft";
		$col["editable"] = true;
		$col["hidden"] = true;
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Kode FFT";
		$col["name"] = "kode_fft";
		$col["editoptions"] = array("maxlength" => "8", "size" =>"9");
		$col["search"] = true;
		$col["editable"] = true;
		$col["editrules"] = array("required"=>true);
		$col["hidden"] = false;
		$col["isnull"] = true;	
		$col["autoid"] = false;	
		$col["align"] = "left";
		$col["width"] = "150";
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Size FFT";
		$col["name"] = "size_fft";
		$col["editoptions"] = array("maxlength" => "16", "size" =>"17");
		$col["search"] = true;
		$col["editable"] = true;	
		$col["edit rules"] = array("required"=>true);
		$col["hidden"] = false;
		$col["isnull"] = true;	
		$col["autoid"] = false;	
		$col["align"] = "left";
		$col["width"] = "200";
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Aktif";
		$col["name"] = "aktif";
		$col["width"] = "100";
		$col["search"] = true;
		$col["editable"] = true;
		$col["align"] = "center";
		$col["editrules"] = array("required"=>false); 
		$col["edittype"] = "checkbox"; 
		$col["stype"] = "checkbox"; 
		$col["formatter"] = "checkbox";
		$col["editoptions"] = array("maxlength"=>1,"size"=>75,"value"=>"1:0","defaultValue"=>'1');
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "User Created";
		$col["name"] = "iduser_created";
		$col["search"] = false;
		$col["export"] = false;
		$col["editable"] = true;
		$col["hidden"] = true;
		$col["editoptions"] = array("defaultValue" => $this->session->userdata('user_id'));
		$cols[] = $col;
		
		$g->set_columns($cols);
		$g->set_options($grid);
		
		$head['title'] = $caps;
		$data['breadcrumbs'] = $this->Global_model->create_breadcrumbs(["master","FFT Size"]);
		$data['fluid'] = true;
		$data['gridout'] = $g->render("list1");
		
		$this->load->view('layout/header',$head);
		$this->load->view('layout/sidebar');
		$this->load->view('grid_master',$data);
		$this->load->view('layout/footer');
	}
	
	public function modulation()
	{
		$this->load->model('Global_model');
		if(in_array(1,$this->session->userdata('priv')) == FALSE) return redirect('404_override');
		$this->load->library('gridlibrary');
		$g = new jqgrid($this->db_conf);
		$caps = "Modulation";
		
		$grid["caption"] = $caps;
		$grid["rowNum"] = 20; 
		$grid["rowList"] = array(20,40,100,'All');
		$grid["rownumbers"] = true;
		//$grid["sortname"] = 'kantor'; 
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
		
		// $grid["subGrid"] = true; 
		// $grid["subgridurl"] = "Daerah";
		// $grid["subgridparams"] = "kode, nama";
		
		
		$g->set_actions(array(
				"add"=>true,
				"edit"=>true,
				"delete"=>true,
				"rowactions"=>false,
				"export"=>true,
				"autofilter" => true,
				"search" => false
			)
		);
		$g->select_command = "SELECT * FROM ms_modulation";
		$g->table = "ms_modulation";
			
			
		$col = array();
		$col["title"] = "ID";
		$col["name"] = "id_modulation";
		$col["editoptions"] = array("onfocus"=>"set_mask_nik(this)", "style"=>"text-align:left"); 
		$col["search"] = true;
		$col["editable"] = true;
		$col["autoid"] = true;	
		$col["align"] = "center";
		$col["width"] = "80";
		$col["hidden"] = true;
		$cols[] = $col;
		

		$col = array();
		$col["title"] = "Size Modulation";
		$col["name"] = "size_modulation";
		$col["search"] = true;
		$col["align"] = "center";
		$col["editable"] = true;
		$col["width"] = "200";
		//$col["editrules"] = array("required"=>true, "custom"=>true,"custom_func"=>"function(val,label){return my_validation(val,label);}");
		$col["editrules"] = array("required"=>true);
		$col["editoptions"] = array("onfocus"=>"set_size(this)", "size"=>"15");
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Satuan Modulation";
		$col["name"] = "satuan_modulation";
		$col["search"] = true;
		$col["align"] = "center";
		$col["editable"] = true;
		$col["width"] = "200";
		$col["editrules"] = array("required"=>true);
		$col["editoptions"] = array("maxlength" => "8", "size"=>"25"
							  ,"onkeyup"=>"set_upper(this)");
		//$col["editoptions"] = array("maxlength" => "8", "style"=>"text-align:left", "size"=>"20");
		//$col["editoptions"] = array("value" => $str);
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Status";
		$col["name"] = "aktif";
		$col["width"] = "50";
		$col["search"] = true;
		$col["editable"] = true;
		$col["align"] = "center";
		$col["editrules"] = array("required"=>false); 
		$col["edittype"] = "checkbox"; 
		$col["stype"] = "checkbox"; 
		$col["formatter"] = "checkbox";
		$col["editoptions"] = array("maxlength"=>1,"size"=>"20","value"=>"1:0","defaultValue"=>'1');
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "User Created";
		$col["name"] = "iduser_created";
		$col["search"] = false;
		$col["export"] = false;
		$col["editable"] = true;
		$col["hidden"] = true;
		$col["editoptions"] = array("defaultValue" => $this->session->userdata('user_id'));
		$cols[] = $col;
		
		
		
		$g->set_columns($cols);
		$g->set_options($grid);
		
		$data['gridout'] = $g->render("list1");
		$this->load->model('Global_model');
		$head['collapse'] = false;
		$head['title'] = "Home";
		$data['breadcrumbs'] = $this->Global_model->create_breadcrumbs(["Master","Modulation"]);
		$this->load->view('layout/header',$head);
		$this->load->view('layout/sidebar');
		$this->load->view('grid_master',$data);
		$this->load->view('layout/footer');
	
	}
	
	public function pegawai()
	{
		$this->load->library('gridlibrary');
		$g = new jqgrid($this->db_conf);
		$caps = "Master Pegawai";
		
		$grid["caption"] = $caps;				
		$grid["rowNum"] = 20; 
		$grid["rowList"] = array(20,40,100,'All');
		$grid["rownumbers"] = true;
		$grid["rowList"] = array();$grid["viewrecords"] = true;
		$grid["rownumbers"] = true;
		$grid["sortname"] = 'idpeg'; 
		$grid["autowidth"] = true;
		$grid["shrinkToFit"] = false;
		$grid["forceFit"] = false;
		$grid["resizable"] = false;
		$grid["autoresize"] = true;
		$grid["responsive"] = true;
		$grid["multiselect"] = false; 
		$grid["rowactions"] = true; 
		$grid["toolbar"] = "both"; 
		$grid["add_options"] = array("width"=>"550");
		$grid["edit_options"] = array("width"=>"550");
		$grid["view_options"] = array("width"=>"550");
		$grid["export"] = array("format"=>"xls", "filename"=>$this->file_name, "sheetname"=>"master_pegawai");
		
		$g->set_actions(array(
				"add"=>true,
				"edit"=>true,
				"delete"=>true,
				"rowactions"=>false,
				"export"=>true,
				"showhidecolumns"=>false,
				"autofilter" => true,
				"search" => false
			)
		);
		
		$g->select_command = "SELECT idpeg, nip, pangkat_gol, jabatan ,email, no_telp, paraf, idlokasi, tmt_pensiun, 
							nama_lengkap, aktif 								
							FROM ms_pegawai ";						
		$g->table = "ms_pegawai";
		
		$col = array();
		$col["title"] = "ID";
		$col["name"] = "idpeg";
		$col["editable"] = true;
		$col["hidden"] = true;
		$cols[] = $col;
				
		$col = array();
		$col["title"] = "Nama Lengkap";
		$col["name"] = "nama_lengkap";
		$col["editoptions"] = array("maxlength" => "40", "size"=>'40',"onkeyup"=>"set_upper(this)");
		$col["search"] = true;
		$col["editable"] = true;
		$col ["editrules"] = array ("required" => true);
		$col["hidden"] = false;
		$col["isnull"] = true;	
		$col["autoid"] = false;	
		$col["align"] = "left";
		$col["width"] = "200";
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "NIP";
		$col["name"] = "nip";
		$col["search"] = true;
		$col["editable"] = true;
		//$col["editoptions"] = array("maxlength" => "20", "size" =>"25");
		$col["width"] = "180";
		$col["align"] = "center";
		$col["align"] = "center";
		//$col["editrules"] = array("required"=>true);  
  		$col["editoptions"] = array("onfocus"=>"set_mask_nip(this)", "style"=>"text-align:left");  
		//$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
		$cols[] = $col; 
					
		$col = array();
		$col["title"] = "Pangkat Golongan";
		$col["name"] = "pangkat_gol";
		$col["editoptions"] = array("maxlength" => "25", "size"=>'25');
		$col["search"] = true;
		$col["editable"] = true;
		$col["hidden"] = false;
		$col["isnull"] = true;	
		$col["autoid"] = false;	
		$col["align"] = "left";
		$col["width"] = "150";
		$cols[] = $col;

		
		$col = array();
		$col["title"] = "Jabatan";
		$col["name"] = "jabatan";
		$col["editoptions"] = array("maxlength" => "30", "size"=>'35');
		$col["search"] = true;
		$col["editable"] = true;
		$col["hidden"] = false;
		$col["isnull"] = true;	
		$col["autoid"] = false;	
		$col["align"] = "left";
		$col["width"] = "180";
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Email";
		$col["name"] = "email";
		$col["search"] = true;
		$col["editable"] = true;
		$col["isnull"] = true;
		$col["width"] = "200";
		$col["align"] = "left";
		$col["editoptions"] = array("maxlength" => "30","size"=>40, "placeholder"=>"...@email.com");
		$col["editrules"] = array("email" => true,"required" => false);
		$cols[] = $col; 
		
		
		$col = array();
		$col["title"] = "Telepon";
		$col["name"] = "no_telp";
		$col["search"] = true;
		$col["editable"] = true;
		$col["width"] = "150";
		$col["align"] = "center";
		$col["editrules"] = array("required"=>true);  
  		$col["editoptions"] = array("onfocus"=>"set_mask_telp(this)", "style"=>"text-align:left", "maxlength" => "13");  
		$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
		$cols[] = $col; 
			
		$col = array();
		$col["title"] = "Paraf";
		$col["name"] = "paraf"; 
		$col["width"] = "150";
		$col["editable"] = true; // this column is editable
		$col["isnull"] = true;
		$col["edittype"] = "file"; // render as file
		$col["upload_dir"] = "files"; // upload here
		// $col["add_options"]["bottominfo"] = "Only pdf"; 
		$col["editrules"] = array("ifexist"=>"rename"); // "rename", "override" can also be set
		$col["show"] = array("list"=>true,"edit"=>true,"add"=>true); // only show in add/edit dialog
		$cols[] = $col;
		
		
		$col = array();
		$col["title"] = "Lokasi";
		$col["name"] = "idlokasi";
		$col["width"] = "150";
		$col["search"] = true;
		$col["editable"] = true;
		$col["align"] = "left";
		$col["edittype"] = "select";
		$col["isnull"] = true;
		$col["formatter"] = "select"; 
		$str = $g->get_dropdown_values("SELECT DISTINCT idlokasi AS k, nama_lokasi AS v  FROM ms_lokasi_tvri WHERE idlokasi<>0 ORDER BY idlokasi");
		$col["searchoptions"] = array("value" =>":NA;".$str, "separator" => ":", "delimiter" => ";");
		$col["editoptions"] = array("value" => ":NA;".$str, 
										"separator" => ":", 
										"delimiter" => ";",
										"onChange" => array( "sql"=>"SELECT DISTINCT idlokasi AS k, nama_lokasi AS v  
																		FROM ms_lokasi_tvri WHERE idlokasi <>0 
																		AND idpeg={idpeg}
																		ORDER BY nama_lokasi",
																		"update_field" => "idlokasi" )
										);
		$cols[] = $col;		

		$col = array();
		$col["title"] = "Status";
		$col["name"] = "aktif";
		$col["width"] = "50";
		$col["search"] = true;
		$col["editable"] = true;
		$col["align"] = "center";
		$col["editrules"] = array("required"=>false); 
		$col["edittype"] = "checkbox"; 
		$col["stype"] = "checkbox"; 
		$col["formatter"] = "checkbox";
		$col["editoptions"] = array("maxlength"=>1,"size"=>"20","value"=>"1:0","defaultValue"=>'1');
		$cols[] = $col;
		
	/*	$col = array();
		$col["title"] = "Pensiun";
		$col["name"] = "tmt_pensiun"; 
		$col["align"] = "center";
		$col["width"] = "150";
		$col["editable"] = true; 
		$col["editrules"] = array("required"=>false); 
		$col["formatter"] = "date";
		$col["formatoptions"] = array("srcformat"=>'Y-m-d', "newformat" =>'d-m-Y');
		$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
		$cols[] = $col;
		*/
 
		$g->set_columns($cols);
		$g->set_options($grid);
		
		
		$head['title'] = $caps;
		$data['breadcrumbs'] = $this->Global_model->create_breadcrumbs(["master","pegawai"]);
		$data['fluid'] = true;
		$data['gridout'] = $g->render("list1");
		
		$this->load->view('layout/header',$head);
		$this->load->view('layout/sidebar');
		$this->load->view('grid_master',$data);
		$this->load->view('layout/footer');
	}
	
	public function lokasi()
	{
		$this->load->library('gridlibrary');
		$g = new jqgrid($this->db_conf);
		$caps = "Lokasi";
		
		$idkec= $_REQUEST['rowid'];
		$nama_kec = $_REQUEST["nama_kec"];
		if($idkec){
			$caps .= ", Kecamatan ".$nama_kec;			
			$filter = "WHERE idkec='$idkec' ";	
		}
		
		$grid["caption"] = $caps;
		$grid["rowNum"] = 20; 
		$grid["rowList"] = array(40,40,100,'All');
		$grid["rownumbers"] = true; 
		$grid["autowidth"] = true;
		$grid["shrinkToFit"] = false;// agar panjang row bisa sesuai
		$grid["forceFit"] = false;
		$grid["resizable"] = true;
		$grid["autoresize"] = true;
		$grid["multiselect"] = false; 
		$grid["toolbar"] = "buttom"; 
		$grid["add_options"] = array("width"=>"500");
		$grid["edit_options"] = array("width"=>"500");
		$grid["view_options"] = array("width"=>"400");
		$grid["export"] = array("format"=>"xls", "filename"=>$this->file_name, "sheetname"=>"master_lokasi");
		
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
		
		
		$g->select_command = "SELECT ms_lokasi_tvri.idlokasi, idprovinsi, idkabupaten, idkec, iddesa, nama_lokasi, longitude, latitude, alamat, status_kantor,pic, wilayah_layanan, telp_pic, ms_lokasi_tvri.kanal, token, nama_lengkap, path_gedung, path_struktur, (SELECT GROUP_CONCAT(wilayah_layanan SEPARATOR ', ') FROM ms_area_layanan 
		WHERE FIND_IN_SET(id, ms_lokasi_tvri.wilayah_layanan) <> 0 ) as labellayanan,(SELECT GROUP_CONCAT(concat('Channel: ',channel, ' Freq: ', frequency) SEPARATOR ', ') FROM ms_kanal 	
		WHERE FIND_IN_SET(id_kanal, ms_lokasi_tvri.kanal) <> 0 ) as labelkanal from ms_lokasi_tvri
		LEFT JOIN ms_pegawai on ms_pegawai.idpeg = ms_lokasi_tvri.pic";
		$g->table = "ms_lokasi_tvri";
		
		
			
		$col = array();
		$col["title"] = "ID Lokasi";
		$col["name"] = "idlokasi";
		$col["editoptions"] = array("onfocus"=>"set_mask_nik(this)");
		$col["search"] = true;
		//$col["editable"] = false;
		$col["hidden"] = true;
		//$col["isnull"] = true;	
		//$col["autoid"] = true;	
		$col["align"] = "center";
		$col["width"] = "80";
		//$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Nama Lokasi";
		$col["name"] = "nama_lokasi";
		$col["search"] = true;
		$col["align"] = "left";
		$col["editable"] = true;
		$col["width"] = "200";
		$col["editrules"] = array("required"=>true);
		$col["editoptions"] = array("maxlength" => "30", "size"=>30);
		$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Provinsi";
		$col["name"] = "idprovinsi";
		$col["dbname"] = "ms_provinsi";
		$col["width"] = "150";
		$col["align"] = "left";
		$col["search"] = true;
		$col["editable"] = true;
		$col["editrules"] = array("required"=>true);
		$col["edittype"] = "select"; // render as select
		# fetch data from database, with alias k for key, v for value

		# on change, update other dropdown
		$str = $g->get_dropdown_values("select distinct idprovinsi as k, nama_provinsi as v from ms_provinsi");
		$col["editoptions"] = array(
					"value"=>":;".$str, 
					"onchange" => array(    "sql"=>"select distinct idkabupaten as k, nama_kabupaten as v from ms_kabupaten WHERE idprovinsi = '{idprovinsi}'",
											"update_field" => "idkabupaten" )
									);

		$col["formatter"] = "select"; // display label, not value
		//$col["stype"] = "select-multiple"; // enable dropdown search
		$col["searchoptions"] = array("value" => ":;".$str);
		$cols[] = $col;        
		
		$col = array();
		$col["title"] = "Kabupaten";
		$col["name"] = "idkabupaten";
		$col["dbname"] = "ms_kabupaten";
		$col["width"] = "150";
		$col["search"] = true;
		$col["editable"] = true;
		$col["edittype"] = "select"; // render as select
		$str = $g->get_dropdown_values("select idkabupaten as k, nama_kabupaten as v from ms_kabupaten");
		$col["editoptions"] = array(
					"value"=>$str, 
					"onchange" => array(    "sql"=>"select distinct idkec as k, nama_kec as v from ms_kecamatan WHERE idkabupaten = '{idkabupaten}'",
											"update_field" => "idkec" )
									);
									
		$col["formatter"] = "select"; // display label, not value
		//$col["stype"] = "select-multiple"; // enable dropdown search
		$col["searchoptions"] = array("value" => ":;".$str);
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Kecamatan";
		$col["name"] = "idkec";
		$col["dbname"] = "ms_kecamatan";
		$col["width"] = "150";
		$col["search"] = true;
		$col["editable"] = true;
		$col["edittype"] = "select"; // render as select
		$str = $g->get_dropdown_values("select idkec as k, nama_kec as v from ms_kecamatan");
		$col["editoptions"] = array(
					"value"=>$str, 
					"onchange" => array(    "sql"=>"select distinct iddesa as k, nama_desa as v from ms_desa WHERE idkec = '{idkec}'",
											"update_field" => "iddesa" )
									);
									
		$col["formatter"] = "select"; // display label, not value
		//$col["stype"] = "select-multiple"; // enable dropdown search
		$col["searchoptions"] = array("value" => ":;".$str);
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Desa";
		$col["name"] = "iddesa";
		$col["dbname"] = "ms_desa";
		$col["width"] = "150";
		$col["search"] = true;
		$col["editable"] = true;
		$col["edittype"] = "select"; // render as select
		$str = $g->get_dropdown_values("SELECT DISTINCT idkec AS k, nama_kec AS v  FROM ms_kecamatan WHERE idkec<>0 and idkec like '$idkec%' ORDER BY 2"); 
		$col["searchoptions"] = array("value" =>"0:NA;".$str, "separator" => ":", "delimiter" => ";");
		$col["editoptions"] = array("value" =>"0:NA;".$str, "separator" => ":", "delimiter" => ";" );
		$col["show"] = array("list"=>!($idkec),"edit"=>true,"add"=>true,"view"=>true);
		$cols[] = $col;
		
		// $str = $g->get_dropdown_values("select iddesa as k, nama_desa as v from ms_desa");
		// $col["editoptions"] = array(
									// "value"=>$str
									// );
				
		// // required for manual refresh link                    
		// $col["editoptions"]["onload"]["sql"] = "select iddesa as k, nama_desa as v from ms_desa where idkec = {idkec}";
		// $col["formatter"] = "select"; // display label, not value
		// //$col["stype"] = "select-multiple"; // enable dropdown search
		// $col["searchoptions"] = array("value" => ":;".$str);
		// $cols[] = $col;
		
		
		$col = array();
		$col["title"] = "Longitude";
		$col["name"] = "longitude";
		$col["search"] = true;
		$col["align"] = "center";
		$col["editable"] = true;
		$col["width"] = "130";
		$col["editrules"] = array("required"=>true);
		$col["editoptions"] = array("maxlength" => "20", "size"=>"30"
							  ,"onfocus"=>"set_field_number0(this)");
		$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Latitude";
		$col["name"] = "latitude";
		$col["search"] = true;
		$col["align"] = "center";
		$col["editable"] = true;
		$col["width"] = "130";
		$col["editrules"] = array("required"=>true);
		$col["editoptions"] = array("maxlength" => "20", "size"=>"30"
							  ,"onfocus"=>"set_field_number2(this)");
		$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
		$cols[] = $col;
		 
		 
		
		$col = array();
		$col["title"] = "Alamat";
		$col["name"] = "alamat";
		$col["search"] = true;
		$col["align"] = "left";
		$col["editable"] = true;
		$col["width"] = "350";
		$col["edittype"] = "textarea";
		$col["editrules"] = array("required"=>false);
		$col["editoptions"] = array("maxlength" => "250", "cols"=>"30", "rows"=>"3",);
		$cols[] = $col;
		
		/*$col = array();
		$col["title"] = "Kanal";
		$col["name"] = "kanal";
		$col["search"] = true;
		$col["align"] = "left";
		$col["editable"] = true;
		$col["width"] = "80";
		$col["editrules"] = array("required"=>true);
		$col["editoptions"] = array("maxlength" => "50", "size"=>30);
		$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
		$cols[] = $col;*/
		
		$col = array();
		$col["title"] = "Kanal";
		$col["name"] = "kanal";
		$col["width"] = "290";
		$col["align"] = "left";
		$col["search"] = false;
		$col["export"] = false;
		$col["editable"] = true;
		$col["formatter"] = "select";
		$col["edittype"] = "select"; 
		$str = $g->get_dropdown_values("SELECT DISTINCT id_kanal AS k, concat('Channel:', channel,' Freq: ', frequency) AS v FROM ms_kanal WHERE aktif='1' ORDER BY 2");
		$col["editoptions"] = array("value"=>$str);
		$col["editoptions"]["dataInit"] = "function(){ setTimeout(function(){ link_select2('{$col["name"]}'); },200); }";
		$col["editoptions"]["multiple"] = true;
		$col["editoptions"]["size"] = 20;
		$col["editoptions"]["rows"] = 5;
		$col["editrules"] = array("required"=>true); 
		$col["stype"] = "select"; 
		$col["searchoptions"] = array("value"=>$str,"sopt"=>array("cn")); 
		$col["searchoptions"]["dataInit"] = "function(){ setTimeout(function(){ link_select2('gs_{$col["name"]}'); },200); }";
		$col["show"] = array("list"=>false,"edit"=>true,"add"=>true,"view"=>false);
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Kanal Layanan";
		$col["name"] = "labelkanal";
		$col["width"] = "200";
		$col["align"] = "left";
		$col["search"] = true;$col["export"] = true; 
		$col["editable"] = false;
		$col["show"] = array("list"=>true,"edit"=>false,"add"=>false,"view"=>true);
		$col["formatter"] = "function(cellval,options,rowdata){ return '<div class=\"readmore\">'+cellval+'</div>'; }";
		$col["unformat"] = "function(cellval,options,cell){ if(cellval == 'undefined') return ''; return jQuery(cell).children('div').html(); }";
		$cols[] = $col;
			
		$col = array();
		$col["title"] = "Wilayah Layanan (Kab/Kota)";
		$col["name"] = "wilayah_layanan";
		$col["width"] = "290";
		$col["align"] = "left";
		$col["search"] = false;
		$col["export"] = false;
		$col["editable"] = true;
		$col["formatter"] = "select";
		$col["edittype"] = "select"; 
		$str = $g->get_dropdown_values("SELECT DISTINCT id AS k, wilayah_layanan AS v FROM ms_area_layanan WHERE aktif='1' ORDER BY 2");
		$col["editoptions"] = array("value"=>$str);
		$col["editoptions"]["dataInit"] = "function(){ setTimeout(function(){ link_select2('{$col["name"]}'); },200); }";
		$col["editoptions"]["multiple"] = true;
		$col["editoptions"]["size"] = 20;
		$col["editoptions"]["rows"] = 5;
		$col["editrules"] = array("required"=>true); 
		$col["stype"] = "select"; 
		$col["searchoptions"] = array("value"=>$str,"sopt"=>array("cn")); 
		$col["searchoptions"]["dataInit"] = "function(){ setTimeout(function(){ link_select2('gs_{$col["name"]}'); },200); }";
		$col["show"] = array("list"=>false,"edit"=>true,"add"=>true,"view"=>false);
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Wilayah Layanan";
		$col["name"] = "labellayanan";
		$col["width"] = "200";
		$col["align"] = "left";
		$col["search"] = true;$col["export"] = true; 
		$col["editable"] = false;
		$col["show"] = array("list"=>true,"edit"=>false,"add"=>false,"view"=>true);
		$col["formatter"] = "function(cellval,options,rowdata){ return '<div class=\"readmore\">'+cellval+'</div>'; }";
		$col["unformat"] = "function(cellval,options,cell){ if(cellval == 'undefined') return ''; return jQuery(cell).children('div').html(); }";
		$cols[] = $col;
		
		
		$col = array();
		$col["title"] = "Telepon";
		$col["name"] = "telp_pic";
		$col["search"] = true;
		$col["editable"] = true;
		$col["width"] = "150";
		$col["editoptions"] = array("maxlength" => "25", "size"=>30);
		//$col["formoptions"] = array("rowpos"=>"9", "colpos"=>"1");
		// $col["editrules"] = array("required" => true);
		$col["editrules"] = array("required"=>false);  
  		$col["editoptions"] = array("onfocus"=>"set_mask_telp(this)", "style"=>"text-align:left"); 
		//$col["visible"] = "md";
		$cols[] = $col; 
		
		$col = array();
		$col["title"] = "PIC Site";
		$col["name"] = "pic";
		$col["dbname"] = "ms_pegawai.idpeg"; // this is required as we need to search in name field, not id
		$col["width"] = "100";
		$col["align"] = "left";
		$col["search"] = true;
		$col["editable"] = true;
		$col["export"] = false; // not for export
		$col["edittype"] = "select"; // render as select
		# fetch data from database, with alias k for key, v for value
		$str = $g->get_dropdown_values("select idpeg as k, nama_lengkap as v from ms_pegawai  where aktif='1' order by nama_lengkap");
		$col["editoptions"] = array("value"=>":;".$str); 
		$col["editrules"] = array("required"=>true);
		$col["formatter"] = "select"; // display label, not value
		$cols[] = $col;
				
		// only for export
		$col = array();
		$col["title"] = "PIC Site";
		$col["name"] = "nama_lengkap";
		$col["hidden"] = true;
		$col["export"] = true;
		$col["width"] = "100";
		$cols[] = $col;
		
		/*$col = array();
		$col["title"] = "PIC Site";
		$col["name"] = "pic"; 
		$col["dbname"] = "nama_lengkap"; 
		$col["editable"] = true;
		$col["width"] = "120";
		$col["formatter"] = "autocomplete"; // autocomplete
		$col["formatoptions"] = array("sql"=>"SELECT idpeg as k, nama_lengkap as v FROM ms_pegawai where aktif='1' order by nama_lengkap", "force_select"=>true);
		$col["editoptions"] = array("size"=>40);
		$cols[] = $col;	*/

		
		
		
		/*$col = array();
		$col["title"] = "Email";
		$col["name"] = "email";
		$col["search"] = true;
		$col["editable"] = true;
		$col["isnull"] = true;
		$col["width"] = "100";
		$col["editoptions"] = array("maxlength" => "30","size"=>30);
		$col["editrules"] = array("email" => true,"required" => false);
		// $col["formoptions"] = array("rowpos"=>"11", "colpos"=>"1");
		$col["visible"] = "md";
		$cols[] = $col; */
		
		/*$col = array();
		$col["title"] = "Token";
		$col["name"] = "token";
		$col["search"] = true;
		$col["align"] = "left";
		$col["editable"] = true;
		$col["width"] = "120";
		$col["editrules"] = array("required"=>true);
		$col["editoptions"] = array("onfocus"=>"set_mask_tokenlistrik(this)", "style"=>"text-align:left");
		$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
		$cols[] = $col;*/
		
		$col = array();
		$col["title"] = "Status Lahan";
		$col["name"] = "status_kantor";
		$col["width"] = "100";
		$col["align"] = "left";
		$col["search"] = true;
		$col["editable"] = true;
		$col["edittype"] = "select"; // render as select
		$str = $g->get_dropdown_values("SELECT idstatuslahan AS k, nama_status_lahan AS v FROM ms_status_lahan where aktif='1' ORDER BY 2");
		$col["editoptions"] = array("value"=>":;".$str); 
		$col["formatter"] = "select"; // display label, not value
		$col["stype"] = "select"; // enable dropdown search
		$col["searchoptions"] = array("value" => ":;".$str);
		$col["editrules"] = array("required"=>true);
		$col["export"] = false;
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Status Lahan";
		$col["name"] = "nama_status";
		$col["width"] = "150";
		$col["align"] = "left";
		$col["hidden"] = true;
		$col["search"] = true;
		$col["editable"] = false;
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Path Gedung";
		$col["name"] = "path_gedung";
		$col["width"] = "150";
		$col["editable"] = true;
		$col["edittype"] = "file"; // render as file
		$col["upload_dir"] = "temp"; // upload here
		//$col["editrules"] = array("required"=>true);
		$col["show"] = array("list"=>false,"edit"=>true,"add"=>true); // only show in add/edit dialog
		// prompt error
		$col["editrules"] = array("ifexist"=>"error");

		// rename file e.g. file_1,file_2,file_3 etc (default)
		$col["editrules"] = array("ifexist"=>"rename");

		// override file
		$col["editrules"] = array("ifexist"=>"override");
		
		$col["editrules"]["allowedext"] = "jpeg,jpg,png,bmp,gif"; // comma separated list of extensions
		$col["editoptions"]["multiple"] = "multiple";
		$cols[] = $col;
		
		/*$col = array();
		$col["title"] = "Path Gedung";
		$col["name"] = "path_gedung"; 
		$col["width"] = "150";
		$col["editable"] = true; // this column is editable
		$col["isnull"] = true;
		$col["edittype"] = "file"; // render as file
		$col["upload_dir"] = "files"; // upload here
		// $col["add_options"]["bottominfo"] = "Only pdf"; 
		$col["editrules"] = array("ifexist"=>"rename"); // "rename", "override" can also be set
		$col["show"] = array("list"=>true,"edit"=>true,"add"=>true); // only show in add/edit dialog
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Path Struktur";
		$col["name"] = "path_struktur";
		$col["width"] = "150";
		$col["editable"] = true; // this column is editable
		$col["editoptions"]["multiple"] = "multiple"; // to enable multiple file upload
		$col["edittype"] = "file"; // render as file
		$col["upload_dir"] = "temp"; // upload here
		$col["editrules"] = array("ifexist"=>"rename"); // "rename", "override" can also be set
		$col["show"] = array("list"=>false,"view"=>false,"edit"=>true,"add"=>true); // only show in add/edit dialog
		$cols[] = $col;*/
		
		$col = array();
		$col["title"] = "Path Struktur";
		$col["name"] = "path_struktur";
		$col["width"] = "150";
		$col["editable"] = true;
		$col["edittype"] = "file"; // render as file
		$col["upload_dir"] = "temp"; // upload here
		//$col["editrules"] = array("required"=>true);
		$col["show"] = array("list"=>false,"edit"=>true,"add"=>true); // only show in add/edit dialog
		$cols[] = $col;
		
		// prompt error
		$col["editrules"] = array("ifexist"=>"error");

		// rename file e.g. file_1,file_2,file_3 etc (default)
		$col["editrules"] = array("ifexist"=>"rename");

		// override file
		$col["editrules"] = array("ifexist"=>"override");
		
		$col["editrules"]["allowedext"] = "jpeg,jpg,png,bmp,gif"; // comma separated list of extensions
		$col["editoptions"]["multiple"] = "multiple";
		
		$col = array();
		$col["title"] = "User Created";
		$col["name"] = "iduser_created";
		$col["search"] = false;
		$col["export"] = false;
		$col["editable"] = true;
		$col["hidden"] = true;
		$col["editoptions"] = array("defaultValue" => $this->session->userdata('user_id'));
		$cols[] = $col;
		
		$g->set_columns($cols);
		$g->set_options($grid);
		
		//mulai
		$head['title'] = $caps;
		
		$data['gridout'] = $g->render("list1");
		
		
		$data['gridout'] = $g->render("list1");
		$this->load->model('Global_model');
		$head['collapse'] = false;
		$head['title'] = "Home";
		$data['breadcrumbs'] = $this->Global_model->create_breadcrumbs(["master","lokasi"]);
		$this->load->view('layout/header',$head);
		$this->load->view('layout/sidebar');
		$this->load->view('grid_master_tag',$data);
		//$this->load->view('grid_master',$data);
		$this->load->view('layout/footer');
	}

}
