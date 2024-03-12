<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transmisi extends CI_Controller {
	var $db_conf; 
	public function __construct()
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
		// error_reporting(E_ALL);
		// ini_set ("log_errors",1);
		// ini_set("display_errors",1);
		
	}
	
	public function index()
	{
		$this->load->model('Global_model');
		$this->load->library('gridlibrary');
		Global $iduser; 
		$iduser = $this->session->userdata('user_id'); 
					
		//Grid 1
		{
			$g = new jqgrid($this->db_conf);
			$caps = "Lokasi Transmisi";
			
			$grid["caption"] = $caps;
			$grid["rowNum"] = 20; 
			$grid["rowList"] = array(40,40,100,'All');
			$grid["rownumbers"] = true;
			$grid["autowidth"] = true;
			$grid["shrinkToFit"] = false;// agar panjang row bisa sesuai
			$grid["forceFit"] = false;
			$grid["resizable"] = true;
			$grid["sortname"] = 'idlokasi';
			$grid["autoresize"] = true;
			$grid["multiselect"] = false; 
			$grid["toolbar"] = "buttom"; 
			$grid["add_options"] = array("width"=>"500");
			$grid["edit_options"] = array("width"=>"500");
			$grid["view_options"] = array("width"=>"400");
			$grid["export"] = array("format"=>"xls", "filename"=>$this->file_name, "sheetname"=>"master-kategoriuji");
			
			
					
			$grid["detail_grid_id"] = "list2,list3,list4,list5,list6,list7";
			$grid["onSelectRow"] = "function(id){ 
			var idlokasi = $('#list1').jqGrid('getCell', id, 'nama_lokasi');
			$('#list2').jqGrid('setCaption','Pemancar : '+idlokasi); 
			$('#list3').jqGrid('setCaption','Tower : '+idlokasi); 
			$('#list4').jqGrid('setCaption','SistemAntena : '+idlokasi); 
			$('#list5').jqGrid('setCaption','CatuDaya : '+idlokasi); 
			$('#list6').jqGrid('setCaption','UPS : '+idlokasi); 
			$('#list7').jqGrid('setCaption','Parabola : '+idlokasi); 
			}";
			
			// select row after addition
			$grid["add_options"]["afterComplete"] = "function (response, postdata) { r = JSON.parse(response.responseText); $('#list1').setSelection(r.id); }";
			
			
			
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
			
			$g->select_command = "SELECT * FROM (
				SELECT idlokasi
				, idprovinsi
				, idkabupaten
				, idkec
				, iddesa
				, nama_lokasi
				, iduser_created, created
				, CONCAT(us.first_name,' ',IFNULL(us.last_name,''))nama_lengkap		FROM ms_lokasi_tvri ms 
				INNER JOIN auth_users us ON us.id=ms.iduser_created
			) tablegab";
			$g->table = "ms_lokasi_tvri";
			
				
			$col = array();
			$col["title"] = "ID Lokasi";
			$col["name"] = "idlokasi";
			$col["editoptions"] = array("onfocus"=>"set_mask_nik(this)");
			$col["search"] = true;
			$col["hidden"] = true;
			$col["align"] = "center";
			$col["width"] = "80";
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "Provinsi";
			$col["name"] = "idprovinsi";
			$col["dbname"] = "ms_provinsi";
			$col["width"] = "150";
			$col["align"] = "left";
			$col["search"] = true;
			$col["editable"] = true;
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
			$str = $g->get_dropdown_values("select iddesa as k, nama_desa as v from ms_desa");
			$col["editoptions"] = array(
										"value"=>$str
										);
					
			// required for manual refresh link                    
			$col["editoptions"]["onload"]["sql"] = "select distinct iddesa as k, nama_desa as v from ms_desa where idkec		= '{idkec}'";
			$col["formatter"] = "select"; // display label, not value
			$col["searchoptions"] = array("value" => ":;".$str);
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
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "User Created";
			$col["name"] = "nama_lengkap";
			$col["width"] = "150";
			$col["search"] = true;
			$col["editable"] = false;
			$col["align"] = "left";
			$cols[] = $col;
			
			
			$col = array();
			$col["title"] = "Created";
			$col["name"] = "created"; 
			$col["width"] = "160";
			$col["editable"] = false; // this column is editable
			$col["editoptions"] = array("size"=>20, "defaultValue" => date("d.m.Y")); // with default display of textbox with size 20
			$col["editrules"] = array("required"=>false, "edithidden"=>true); // and is required
			$cols[] = $col;

			$g->set_columns($cols);
			$g->set_options($grid);

			$e = null;
			$e["on_insert"] = array("setFieldMetatime", null, true);		
			$g->set_events($e); 

				function setFieldMetatime(&$data) 
				{ 
					Global $iduser; 
					$data["params"]["iduser_create"] = $iduser;
				} 
				
		}
		/*end Grid utama*/
		
		//Grid 2 : Pemancar
		{
			$g2 = new jqgrid($this->db_conf);
			Global $idlokasi;
			$idlokasi = intval($_GET["rowid"]);
			// $idlokasi = intval ($_GET["idlokasi"]);
			
			// inisialisasi
			$grid = array();
			$grid["caption"] = "pemancar";
			$grid["rowNum"] = 20; 
			$grid["rowList"] = array(20,40,100,'All');
			$grid["rownumbers"] = true;
			$grid["sortname"] = 'idlokasi'; 
			$grid["autowidth"] = true;
			$grid["shrinkToFit"] = false;
			$grid["forceFit"] = false;
			$grid["resizable"] = true;
			$grid["multiselect"] = false; 
			$grid["rowactions"] = true; 
			$grid["toolbar"] = "both"; 
			$grid["height"] = ""; 
			$grid["autoresize"] = true;
			$grid["add_options"] = array("width"=>"400");
			$grid["edit_options"] = array("width"=>"400");
			$grid["view_options"] = array("width"=>"360");
			$grid["export"] = array("format"=>"xls", "filename"=>"data-pemancar", "sheetname"=>"data-pemancar");
			$grid["detail_grid_id"] = "list8";
					
			// select row after addition
			$grid["add_options"]["afterComplete"] = "function (response, postdata) { r = JSON.parse(response.responseText); $('#list2').setSelection(r.id); }";

			//$g->set_options($grid);
			$g2->set_actions(array(
					"add"=>true,
					"edit"=>true,
					"delete"=>true,
					"rowactions"=>false,
					"export"=>true,
					"autofilter" => true,
					"search" => false
				)
			);
			$g2->select_command = "SELECT * FROM (
				SELECT id_pemancar
				, jenis_transmisi
				,idlokasi
				, frekuensi
				, coverage_populasi
				, coverage_area
				,channel_1
				, channel_2
				, channel_3
				, tipe
				, koordinat
				, power_nominal
				, power_real, created, iduser_created
				, CONCAT(us.first_name,' ',IFNULL(us.last_name,'')) nama_lengkap 
				FROM trx_pemancar ms 
				INNER JOIN auth_users us ON us.id=ms.iduser_created WHERE ms.idlokasi='$idlokasi') tablegab";
			$g2->table = "trx_pemancar";

			// inisialisasi kolom
			$cols = array();
				
			$col = array();
			$col["title"] = "ID";
			$col["name"] = "id_pemancar";
			$col["search"] = true;
			$col["editable"] = false;
			$col["hidden"] = true;
			$col["width"] = "20";
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "Jenis";
			$col["name"] = "jenis_transmisi";
			$col["search"] = true;
			$col["editable"] = true;
			$col["align"] = "left";
			$col["width"] = "120";
			$col["editrules"] = array("required"=>true);
			$col["edittype"] = "select";
			$col["editoptions"] = array("value"=>"Analog:Analog;Digital:Digital");
			$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
			$cols[] = $col;

			$col = array();
			$col["title"] = "Frequency";
			$col["name"] = "frekuensi";
			$col["search"] = true;
			$col["align"] = "left";
			$col["editable"] = true;
			$col["width"] = "150";
			$col["editrules"] = array("required"=>true, "number"=>true);
			$col["isnull"] = true;
			$col["editoptions"] = array("maxlength" => "10", "size"=>20, "placeholder"=>"Satuan Hz...");
			$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
			$cols[] = $col;

			$col = array();
			$col["title"] = "Coverage Populasi";
			$col["name"] = "coverage_populasi";
			$col["search"] = true;
			$col["align"] = "left";
			$col["editable"] = true;
			$col["width"] = "200";
			$col["editrules"] = array("required"=>true);
			$col["isnull"] = true;
			$col["editoptions"] = array("style"=>"text-align:left", "maxlength" => "11", "size"=>8 ,"placeholder"=>"Orang...");
			//$col["editoptions"] = array("value" => $str);
			$cols[] = $col;

			$col = array();
			$col["title"] = "Coverage Area";
			$col["name"] = "coverage_area";
			$col["search"] = true;
			$col["align"] = "left";
			$col["editable"] = true;
			$col["width"] = "200";
			$col["editrules"] = array("required"=>true,"number"=>true);
			$col["isnull"] = true;
			$col["editoptions"] = array("style"=>"text-align:left", "maxlength" => "20", "size"=>20);
			//$col["editoptions"] = array("value" => $str);
			$cols[] = $col;

			$col = array();
			$col["title"] = "Channel 1";
			$col["name"] = "channel_1";
			$col["search"] = true;
			$col["align"] = "left";
			$col["editable"] = true;
			$col["width"] = "200";
			$col["editrules"] = array("required"=>true,"number"=>true);
			$col["isnull"] = true;
			$col["editoptions"] = array("style"=>"text-align:left", "maxlength" => "11", "size"=>20,  "placeholder"=>"Channel Ke 1...");
			$cols[] = $col;

			$col = array();
			$col["title"] = "Channel 2";
			$col["name"] = "channel_2";
			$col["search"] = true;
			$col["align"] = "left";
			$col["editable"] = true;
			$col["width"] = "200";
			$col["editrules"] = array("required"=>false,"number"=>true);
			$col["isnull"] = false;
			$col["editoptions"] = array("style"=>"text-align:left", "maxlength" => "11", "size"=>20, "placeholder"=>"Channel Ke 2...");
			$cols[] = $col;

			$col = array();
			$col["title"] = "Channel 3";
			$col["name"] = "channel_3";
			$col["search"] = true;
			$col["align"] = "left";
			$col["editable"] = true;
			$col["width"] = "200";
			$col["editrules"] = array("required"=>false,"number"=>true);
			$col["isnull"] = false;
			$col["editoptions"] = array("style"=>"text-align:left", "maxlength" => "11", "size"=>20, "placeholder"=>"Channel Ke 3...");
			$cols[] = $col;

			$col = array();
			$col["title"] = "Tipe";
			$col["name"] = "tipe";
			$col["search"] = true;
			$col["align"] = "left";
			$col["editable"] = true;
			$col["width"] = "200";
			$col["editrules"] = array("required"=>true);
			$col["isnull"] = true;
			$col["editoptions"] = array("style"=>"text-align:left", "maxlength" => "20", "size"=>20);
			$cols[] = $col;

			$col = array();
			$col["title"] = "Koordinat";
			$col["name"] = "koordinat";
			$col["search"] = true;
			$col["align"] = "left";
			$col["editable"] = true;
			$col["width"] = "200";
			$col["editrules"] = array("required"=>true);
			$col["isnull"] = true;
			$col["editoptions"] = array("style"=>"text-align:left", "maxlength" => "20", "size"=>20);
			$cols[] = $col;

			$col = array();
			$col["title"] = "Power Nominal";
			$col["name"] = "power_nominal";
			$col["search"] = true;
			$col["align"] = "left";
			$col["editable"] = true;
			$col["width"] = "200";
			$col["editrules"] = array("required"=>true,"number"=>true);
			$col["isnull"] = true;
			$col["editoptions"] = array("style"=>"text-align:left", "maxlength" => "10", "size"=>20);
			$cols[] = $col;

			$col = array();
			$col["title"] = "Power Real";
			$col["name"] = "power_real";
			$col["search"] = true;
			$col["align"] = "left";
			$col["editable"] = true;
			$col["width"] = "200";
			$col["editrules"] = array("required"=>true, "number"=>true);
			$col["isnull"] = true;
			$col["editoptions"] = array("style"=>"text-align:left", "maxlength" => "10", "size"=>20);
			$cols[] = $col;

			$col = array();
			$col["title"] = "User Created";
			$col["name"] = "nama_lengkap";
			$col["width"] = "250";
			$col["search"] = true;
			$col["editable"] = false;
			$col["align"] = "left";
			$cols[] = $col;

			$col = array();
			$col["title"] = "Created";
			$col["name"] = "created"; 
			$col["width"] = "150";
			$col["editable"] = false; // this column is editable
			$col["editoptions"] = array("size"=>"20", "defaultValue" => date("d.m.Y")); // with default display of textbox with size 20
			$col["editrules"] = array("required"=>true, "edithidden"=>true); // and is required
			$cols[] = $col;

			$g2->set_columns($cols);
			$g2->set_options($grid);

			$e = array();
			$e["on_insert"] = array("setPemancar", null, true); 
			$g2->set_events($e); 
			

			function setPemancar(&$data) 
			{ 
				Global $iduser; 
				Global $idlokasi; 
				$data["params"]["iduser_created"] = $iduser;
				$data["params"]["idlokasi"] = $idlokasi;
			}
			
		}
		
		/*end grid 2*/
		
		//Grid 3 : Tower
		{
			$g3 = new jqgrid($this->db_conf);
			$idlokasi = intval($_GET["rowid"]);
			Global $idlokasi;
			
			$grid = array();
			$grid["caption"] = "Tower";
			$grid["rowNum"] = 20; 
			$grid["rowList"] = array(20,40,100,'All');
			$grid["rownumbers"] = true;
			$grid["sortname"] = 'idlokasi'; 
			$grid["autowidth"] = true;
			$grid["shrinkToFit"] = false;
			$grid["forceFit"] = false;
			$grid["resizable"] = true;
			$grid["multiselect"] = false; 
			$grid["rowactions"] = true; 
			$grid["toolbar"] = "both"; 
			$grid["height"] = ""; 
			$grid["autoresize"] = true;
			$grid["add_options"] = array("width"=>"400");
			$grid["edit_options"] = array("width"=>"400");
			$grid["view_options"] = array("width"=>"360");
			$grid["export"] = array("format"=>"xls", "filename"=>"tower", "sheetname"=>"data-tower");
							
			// select row after addition
			$grid["add_options"]["afterComplete"] = "function (response, postdata) { r = JSON.parse(response.responseText); $('#list3').setSelection(r.id); }";

				
			$g3->set_actions(array(
						"add"=>true,
						"edit"=>true,
						"delete"=>true,
						"rowactions"=>false,
						"export"=>true,
						"autofilter" => true,
						"search" => false
				)
			);
			$g3->select_command = "SELECT * FROM (
					SELECT idtower, 
					idlokasi,
					tipe, 
					koordinat,
					tinggi, 
					kondisi, 
					tahun_dibangun, 
					kondisi_grounding, 
					iduser_created,created
					, CONCAT(us.first_name,' ',IFNULL(us.last_name,'')) nama_lengkap 
					FROM trx_tower ms 
					INNER JOIN auth_users us ON us.id=ms.iduser_created 
					WHERE ms.idlokasi='$idlokasi'
				) tablegab";
			$g3->table = "trx_tower";
					
			$cols = array();
			
			$col = array();
			$col["title"] = "ID";
			$col["name"] = "idtower";
			$col["search"] = true;
			$col["editable"] = false;
			$col["hidden"] = true;
			$col["width"] = "20";
			$cols[] = $col;

				
			$col = array();
			$col["title"] = "Tipe";
			$col["name"] = "tipe";
			$col["search"] = true;
			$col["align"] = "left";
			$col["editable"] = true;
			$col["width"] = "120";
			$col["edittype"] = "select";
			$col["stype"] = "select";
			$col["formatter"] = "select";
			$col["editrules"] = array("required"=>false);
			$col["searchoptions"] = array("value" =>"'';SELF SUPPORT:SELF SUPPORT;GUY WIRE:GUY WIRE");
			$col["editoptions"] = array("value" =>"'';SELF SUPPORT:SELF SUPPORT;GUY WIRE:GUY WIRE");
			$col["export"] = false;
			$cols[] = $col;
				
			$col = array();
			$col["title"] = "Koordinat";
			$col["name"] = "koordinat";
			$col["search"] = true;
			$col["align"] = "left";
			$col["editable"] = true;
			$col["width"] = "200";
			$col["align"] = "left";
			$col["editrules"] = array("required"=>true);
			$col["isnull"] = true;
			$col["editoptions"] = array( "style"=>"text-align:left","maxlength" => "25", "size"=>"25");
			$cols[] = $col;
				
			$col = array();
			$col["title"] = "Tinggi";
			$col["name"] = "tinggi";
			$col["search"] = true;
			$col["align"] = "left";
			$col["editable"] = true;
			$col["width"] = "200";
			$col["align"] = "left";
			$col["editrules"] = array("required"=>true,"number"=>true);
			$col["isnull"] = true;
			$col["editoptions"] = array( "style"=>"text-align:left","maxlength" => "25", "size"=>"25");
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "Kondisi";
			$col["name"] = "kondisi";
			$col["search"] = true;
			$col["align"] = "left";
			$col["editable"] = true;
			$col["width"] = "200";
			$col["align"] = "left";
			$col["editrules"] = array("required"=>true);
			$col["isnull"] = true;
			$col["editoptions"] = array( "style"=>"text-align:left","maxlength" => "25", "size"=>"25");
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "Tahun Dibangun";
			$col["name"] = "tahun_dibangun";
			$col["search"] = true;
			$col["align"] = "center";
			$col["editable"] = true;
			$col["width"] = "130";
			$col["editrules"] = array("required"=>true);
			$col["isnull"] = true;
			$col["editoptions"] = array("onfocus"=>"set_mask_years(this)", "size"=>"5");
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "Kondisi Grounding";
			$col["name"] = "kondisi_grounding";
			$col["search"] = true;
			$col["align"] = "left";
			$col["editable"] = true;
			$col["width"] = "200";
			$col["align"] = "left";
			$col["editrules"] = array("required"=>true);
			$col["isnull"] = true;
			$col["editoptions"] = array( "style"=>"text-align:left","maxlength" => "25", "size"=>"25");
			//$col["editoptions"] = array("value" => $str);
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "User Created";
			$col["name"] = "nama_lengkap";
			$col["width"] = "150";
			$col["search"] = true;
			$col["editable"] = false;
			$col["edit_options"]= array ("maxlength"=>"11");
			$col["align"] = "left";
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "Created";
			$col["name"] = "created"; 
			$col["width"] = "150";
			$col["editable"] = false; // this column is editable
			$col["editoptions"] = array("size"=>"20", "defaultValue" => date("d.m.Y")); // with default display of textbox with size 20
			$col["editrules"] = array("required"=>true, "edithidden"=>true); // and is required
			$cols[] = $col;
			
			$g3->set_columns($cols);
			$g3->set_options($grid);
			
			$e = array();
			$e["on_insert"] = array("setTower", null, true); 
			$g3->set_events($e); 

			function setTower(&$data) 
			{ 
				Global $iduser; 
				Global $idlokasi;
				$data["params"]["iduser_created"] = $iduser;
				$data["params"]["idlokasi"] = $idlokasi;
			} 
			
		}		
		/*end grid 3*/
		
		//Grid 4 : Antena
		{
			$g4 = new jqgrid($this->db_conf);
			$idlokasi = intval($_GET["rowid"]);
			Global $idlokasi;
				
			$grid =array();
			$grid["caption"] = "Antena";
			$grid["rowNum"] = 20; 
			$grid["rowList"] = array(20,40,100,'All');
			$grid["rownumbers"] = true;
			$grid["sortname"] = 'idlokasi'; 
			$grid["autowidth"] = true;
			$grid["shrinkToFit"] = false;
			$grid["forceFit"] = false;
			$grid["resizable"] = true;
			$grid["multiselect"] = false; 
			$grid["rowactions"] = true; 
			$grid["toolbar"] = "both"; 
			$grid["height"] = ""; 
			$grid["autoresize"] = true;
			$grid["add_options"] = array("width"=>"360");
			$grid["edit_options"] = array("width"=>"360");
			$grid["view_options"] = array("width"=>"360");
			$grid["export"] = array("format"=>"xls", "filename"=>"sistemantena", "sheetname"=>"data-sistemantena");
			
				// select row after addition
			$grid["add_options"]["afterComplete"] = "function (response, postdata) { r = JSON.parse(response.responseText); $('#list4').setSelection(r.id); }";
			
			$g4->set_actions(array(
					"add"=>true,
					"edit"=>true,
					"delete"=>true,
					"rowactions"=>false,
					"export"=>true,
					"autofilter" => true,
					"search" => false
				)
			);
			$g4->select_command = "SELECT * FROM (
				SELECT idantena,idlokasi,tipe,polarisasi,merk,thn_perolehan,panel_arah,gain,iduser_created,created
				, CONCAT(us.first_name,' ',IFNULL(us.last_name,'')) nama_lengkap 
				FROM trx_antena ms 
				INNER JOIN auth_users us ON us.id=ms.iduser_created WHERE ms.idlokasi='$idlokasi'
			) tablegab";
			$g4->table = "trx_antena";
				
			$cols =array();	
			$col = array();
			$col["title"] = "ID";
			$col["name"] = "idantena";
			$col["search"] = true;
			$col["editable"] = false;
			$col["hidden"] = true;
			$col["width"] = "20";
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "Tipe";
			$col["name"] = "tipe";
			$col["search"] = true;
			$col["align"] = "left";
			$col["editable"] = true;
			$col["width"] = "150";
			$col["edittype"] = "select";
			$col["stype"] = "select";
			$col["formatter"] = "select";
			$col["searchoptions"] = array("value" =>"'';DIPOLE:DIPOLE;GROUND PLANE:GROUND PLANE;SECTORIAL/DIRECTIVE:SECTORIAL/DIRECTIVE");
			$col["editoptions"] = array("value" =>"'';DIPOLE:DIPOLE;GROUND PLANE:GROUND PLANE;SECTORIAL/DIRECTIVE:SECTORIAL/DIRECTIVE");
			$col["export"] = false;
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "Polarisasi";
			$col["name"] = "polarisasi";
			$col["search"] = true;
			$col["align"] = "left";
			$col["editable"] = true;
			$col["width"] = "150";
			$col["edittype"] = "select";
			$col["stype"] = "select";
			$col["formatter"] = "select";
			$col["searchoptions"] = array("value" =>"'';Horizontal:Horizontal;Vertical:Vertical");
			$col["editoptions"] = array("value" =>"'';Horizontal:Horizontal;Vertical:Vertical");
			$col["export"] = false;
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "Merk";
			$col["name"] = "merk";
			$col["search"] = true;
			$col["editable"] = true;
			$col["isnull"] = true;	
			$col["autoid"] = false;	
			$col["align"] = "left";
			$col["width"] = "150";
			$col["editrules"] = array("required"=>true);
			$col["isnull"] = true;
			$col["editoptions"] = array( "style"=>"text-align:left","maxlength" => "20", "size"=>"20");
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "Tahun Perolehan";
			$col["name"] = "thn_perolehan";
			$col["search"] = true;
			$col["align"] = "center";
			$col["editable"] = true;
			$col["width"] = "110";
			$col["editrules"] = array("required"=>true);
			$col["isnull"] = true;
			$col["editoptions"] = array("onfocus"=>"set_mask_years(this)", "size"=>"5");
			$cols[] = $col;
			
			
			$col = array();
			$col["title"] = "Panel Arah";
			$col["name"] = "panel_arah";
			$col["search"] = true;
			$col["editable"] = true;
			$col["isnull"] = true;	
			$col["autoid"] = false;	
			$col["align"] = "left";
			$col["width"] = "150";
			$col["editrules"] = array("required"=>true);
			$col["isnull"] = true;
			$col["editoptions"] = array( "style"=>"text-align:left","maxlength" => "20", "size"=>"20");
			$cols[] = $col;
			
			
			$col = array();
			$col["title"] = "Gain";
			$col["name"] = "gain";
			$col["search"] = true;
			$col["editable"] = true;
			$col["isnull"] = true;	
			$col["autoid"] = false;	
			$col["align"] = "left";
			$col["width"] = "150";
			$col["editrules"] = array("required"=>true,"number"=>true);
			$col["isnull"] = true;
			$col["editoptions"] = array( "style"=>"text-align:left","maxlength" => "20", "size"=>"20");
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "User Created";
			$col["name"] = "nama_lengkap";
			$col["width"] = "150";
			$col["search"] = true;
			$col["editable"] = false;
			$col["edit_options"]= array ("maxlength"=>"11");
			$col["align"] = "left";
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "Created";
			$col["name"] = "created"; 
			$col["width"] = "150";
			$col["editable"] = false; // this column is editable
			$col["editoptions"] = array("size"=>"20", "defaultValue" => date("d.m.Y")); // with default display of textbox with size 20
			$col["editrules"] = array("required"=>true, "edithidden"=>true); // and is required
			$cols[] = $col;
			
			$g4->set_columns($cols);
			$g4->set_options($grid);
			
			
			$e = array();
			$e["on_insert"] = array("setAntena", null, true); 
			$g4->set_events($e); 

			function setAntena(&$data) 
			{ 
				Global $iduser; 
				$data["params"]["iduser_created"] = $iduser;
				Global $idlokasi; 
				$data["params"]["idlokasi"] = $idlokasi;
			} 
		}
		/*end grid 4*/
		
		//Grid 5 : Catu Daya
		{
				$g5 = new jqgrid($this->db_conf);
				Global $idlokasi;
				$idlokasi = intval($_GET["rowid"]);
				//$id = intval ($_GET["idlokasi"]);
				
				$grid = array();
				$grid["caption"] = "Catu Daya";
				$grid["rowNum"] = 20; 
				$grid["rowList"] = array(20,40,100,'All');
				$grid["rownumbers"] = true;
				$grid["sortname"] = 'idlokasi'; 
				$grid["autowidth"] = true;
				$grid["shrinkToFit"] = false;
				$grid["forceFit"] = false;
				$grid["resizable"] = true;
				$grid["multiselect"] = false; 
				$grid["rowactions"] = true; 
				$grid["toolbar"] = "both"; 
				$grid["height"] = ""; 
				$grid["autoresize"] = true;
				$grid["add_options"] = array("width"=>"360");
				$grid["edit_options"] = array("width"=>"360");
				$grid["view_options"] = array("width"=>"360");
				$grid["export"] = array("format"=>"xls", "filename"=>"catudaya", "sheetname"=>"data-catudaya");
				
				// select row after addition
				$grid["add_options"]["afterComplete"] = "function (response, postdata) { r = JSON.parse(response.responseText); $('#list5').setSelection(r.id); }";
				
				$g5->set_actions(array(
						"add"=>true,
						"edit"=>true,
						"delete"=>true,
						"rowactions"=>false,
						"export"=>true,
						"autofilter" => true,
						"search" => false
					)
				);
				$g5->select_command = "SELECT * FROM (
					SELECT idcatudaya,idlokasi,sumber_daya,besar_daya,merk,phase,kondisi,thn_perolehan, iduser_created,created
					, CONCAT(us.first_name,' ',IFNULL(us.last_name,'')) nama_lengkap 
					FROM trx_catu_daya ms 
					INNER JOIN auth_users us ON us.id=ms.iduser_created WHERE ms.idlokasi='$idlokasi'
				) tablegab";
				$g5->table = "trx_catu_daya";
				
				
				$cols = array();
				$col = array();
				$col["title"] = "ID";
				$col["name"] = "idcatudaya";
				$col["search"] = true;
				$col["hidden"] = true;
				$col["width"] = "20";
				$cols[] = $col;
				
				
				$col = array();
				$col["title"] = "Sumber Daya";
				$col["name"] = "sumber_daya";
				$col["search"] = true;
				$col["align"] = "left";
				$col["editable"] = true;
				$col["width"] = "150";
				$col["edittype"] = "select";
				$col["stype"] = "select";
				$col["formatter"] = "select";
				$col["searchoptions"] = array("value" =>"'';PLN:PLN;GENSET:GENSET");
				$col["editoptions"] = array("value" =>"'';PLN:PLN;GENSET:GENSET");
				$col["export"] = false;
				$cols[] = $col;
				
				$col = array();
				$col["title"] = "Besar Daya";
				$col["name"] = "besar_daya";
				$col["search"] = true;
				$col["editable"] = true;
				$col["isnull"] = true;	
				$col["align"] = "left";
				$col["width"] = "120";
				$col["editrules"] = array("required"=>true, "number"=>true);
				$col["editoptions"] = array( "style"=>"text-align:left","maxlength" => "11", "size"=>"10");
				$cols[] = $col;
				
				$col = array();
				$col["title"] = "Merk";
				$col["name"] = "merk";
				$col["search"] = true;
				$col["editable"] = true;
				$col["isnull"] = true;	
				$col["align"] = "left";
				$col["width"] = "150";
				$col["editrules"] = array("required"=>true);
				$col["editoptions"] = array( "style"=>"text-align:left","maxlength" => "20", "size"=>"20");
				$cols[] = $col;
				
				$col = array();
				$col["title"] = "Phase";
				$col["name"] = "phase";
				$col["search"] = true;
				$col["editable"] = true;
				$col["isnull"] = true;		
				$col["align"] = "left";
				$col["width"] = "150";
				$col["editrules"] = array("required"=>true);
				$col["editoptions"] = array( "style"=>"text-align:left","maxlength" => "20", "size"=>"20");
				$cols[] = $col;
				
				$col = array();
				$col["title"] = "Kondisi";
				$col["name"] = "kondisi";
				$col["search"] = true;
				$col["editable"] = true;
				$col["isnull"] = true;	
				$col["align"] = "left";
				$col["width"] = "150";
				$col["editrules"] = array("required"=>true);
				$col["editoptions"] = array( "style"=>"text-align:left","maxlength" => "25", "size"=>"20");
				$cols[] = $col;
				
				$col = array();
				$col["title"] = "Tahun Perolehan";
				$col["name"] = "thn_perolehan";
				$col["search"] = true;
				$col["align"] = "center";
				$col["editable"] = true;
				$col["width"] = "130";
				$col["editrules"] = array("required"=>true);
				$col["isnull"] = true;
				$col["editoptions"] = array("onfocus"=>"set_mask_years(this)", "size"=>"5");
				$cols[] = $col;
				
				
				$col = array();
				$col["title"] = "User Created";
				$col["name"] = "nama_lengkap";
				$col["width"] = "200";
				$col["search"] = true;
				$col["edit_options"]= array ("maxlength"=>"11");
				$col["align"] = "left";
				$cols[] = $col;
				
				$col = array();
				$col["title"] = "Created";
				$col["name"] = "created"; 
				$col["width"] = "200";
				$col["editable"] = false; // this column is editable
				$col["editoptions"] = array("size"=>"20", "defaultValue" => date("d.m.Y")); // with default display of textbox with size 20
				$col["editrules"] = array("required"=>true, "edithidden"=>true); // and is required
				$cols[] = $col;
				
				$g5->set_columns($cols);
				$g5->set_options($grid);
			
				$e = array();
				$e["on_insert"] = array("setCatuDaya", null, true); 
				$g5->set_events($e); 

				function setCatuDaya(&$data) 
				{ 
					Global $iduser; 
					$data["params"]["iduser_created"] = $iduser;
					Global $idlokasi; 
					$data["params"]["idlokasi"] = $idlokasi;
			} 
		}
		/*end grid 5*/
		
		//Grid 6 : UPS
		{
			$g6 = new jqgrid($this->db_conf);
			Global $idlokasi;
			$idlokasi = intval($_GET["rowid"]);
			//$id = intval ($_GET["idlokasi"]);
			
			$grid = array ();
			$grid["caption"] = "UPS";
			$grid["rowNum"] = 20; 
			$grid["rowList"] = array(20,40,100,'All');
			$grid["rownumbers"] = true;
			$grid["sortname"] = 'idlokasi'; 
			$grid["autowidth"] = true;
			$grid["shrinkToFit"] = false;
			$grid["forceFit"] = false;
			$grid["resizable"] = true;
			$grid["multiselect"] = false; 
			$grid["rowactions"] = true; 
			$grid["toolbar"] = "both"; 
			$grid["height"] = ""; 
			$grid["autoresize"] = true;
			$grid["add_options"] = array("width"=>"360");
			$grid["edit_options"] = array("width"=>"360");
			$grid["view_options"] = array("width"=>"360");
			$grid["export"] = array("format"=>"xls", "filename"=>"ups", "sheetname"=>"data-ups");
			
			// select row after addition
			//$grid["add_options"]["afterComplete"] = "function (response, postdata) { r = JSON.parse(response.responseText); $('#list6').setSelection(r.id); }";
			
			
			$g6->set_actions(array(
					"add"=>true,
					"edit"=>true,
					"delete"=>true,
					"rowactions"=>false,
					"export"=>true,
					"autofilter" => true,
					"search" => false
				)
			);
			$g6->select_command = "SELECT * FROM (
				SELECT idups
				,idlokasi
				,merk
				,kapasitas
				,kondisi
				,thn_perolehan
				,nomer_seri
				,iduser_created,created
				, CONCAT(us.first_name,' ',IFNULL(us.last_name,'')) nama_lengkap 
				FROM trx_ups ms 
				INNER JOIN auth_users us ON us.id=ms.iduser_created WHERE ms.idlokasi='$idlokasi'
			) tablegab";
			$g6->table = "trx_ups";
				
			$cols = array ();
			$col = array();
			$col["title"] = "ID";
			$col["name"] = "idups";
			$col["search"] = true;
			$col["editable"] = false;
			$col["hidden"] = true;
			$col["width"] = "20";
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "Merk";
			$col["name"] = "merk";
			$col["search"] = true;
			$col["editable"] = true;
			$col["isnull"] = true;	
			$col["autoid"] = false;	
			$col["align"] = "left";
			$col["width"] = "150";
			$col["editrules"] = array("required"=>true);
			$col["editoptions"] = array( "style"=>"text-align:left","maxlength" => "20", "size"=>"20");
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "Kapasitas";
			$col["name"] = "kapasitas";
			$col["search"] = true;
			$col["editable"] = true;
			$col["isnull"] = true;	
			$col["autoid"] = false;	
			$col["align"] = "left";
			$col["width"] = "150";
			$col["editrules"] = array("required"=>true, "number"=>true);
			$col["editoptions"] = array( "style"=>"text-align:left","maxlength" => "20", "size"=>"20");
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "Kondisi";
			$col["name"] = "kondisi";
			$col["search"] = true;
			$col["editable"] = true;
			$col["isnull"] = true;	
			$col["autoid"] = false;	
			$col["align"] = "left";
			$col["width"] = "150";
			$col["editrules"] = array("required"=>true);
			$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
			$col["editoptions"] = array( "style"=>"text-align:left","maxlength" => "20", "size"=>"20");
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "Tahun Perolehan";
			$col["name"] = "thn_perolehan";
			$col["search"] = true;
			$col["align"] = "center";
			$col["editable"] = true;
			$col["width"] = "130";
			$col["editrules"] = array("required"=>true);
			$col["editoptions"] = array("onfocus"=>"set_mask_years(this)", "size"=>"5");
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "Nomor Seri";
			$col["name"] = "nomer_seri";
			$col["search"] = true;
			$col["editable"] = true;
			$col["isnull"] = true;	
			$col["autoid"] = false;	
			$col["align"] = "left";
			$col["width"] = "150";
			$col["editrules"] = array("required"=>true);
			$col["editoptions"] = array( "style"=>"text-align:left","maxlength" => "25", "size"=>"20");
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "User Created";
			$col["name"] = "nama_lengkap";
			$col["width"] = "200";
			$col["search"] = true;
			$col["editable"] = false;
			$col["edit_options"]= array ("maxlength"=>"11");
			$col["align"] = "left";
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "Created";
			$col["name"] = "created"; 
			$col["width"] = "200";
			$col["editable"] = false; // this column is editable
			$col["editoptions"] = array("size"=>"20", "defaultValue" => date("d.m.Y")); // with default display of textbox with size 20
			$col["editrules"] = array("required"=>true, "edithidden"=>true); // and is required
			$cols[] = $col;
			
			$g6->set_columns($cols);
			$g6->set_options($grid);
			
			$e = array();
			$e["on_insert"] = array("setUPS", null, true); 
			$g6->set_events($e); 

			function setUPS(&$data) 
			{ 
				Global $iduser; 
				$data["params"]["iduser_created"] = $iduser;
				Global $idlokasi; 
				$data["params"]["idlokasi"] = $idlokasi;
			} 
	
		}
		
		/*end grid 6*/
		
		//Grid 7 : Parabola
			{
			$g7 = new jqgrid($this->db_conf);
			Global $idlokasi;
			$id = intval($_GET["rowid"]);
			//$id = intval ($_GET["idlokasi"]);
			
			$grid =array();
			$grid["caption"] = "Parabola";
			$grid["rowNum"] = 20; 
			$grid["rowList"] = array(20,40,100,'All');
			$grid["rownumbers"] = true;
			$grid["sortname"] = 'idlokasi'; 
			$grid["autowidth"] = true;
			$grid["shrinkToFit"] = false;
			$grid["forceFit"] = false;
			$grid["resizable"] = true;
			$grid["multiselect"] = false; 
			$grid["rowactions"] = true; 
			$grid["toolbar"] = "both"; 
			$grid["height"] = ""; 
			$grid["autoresize"] = true;
			$grid["add_options"] = array("width"=>"360");
			$grid["edit_options"] = array("width"=>"360");
			$grid["view_options"] = array("width"=>"360");
			$grid["export"] = array("format"=>"xls", "filename"=>"parabola", "sheetname"=>"data-parabola");
			
			// select row after addition
			$grid["add_options"]["afterComplete"] = "function (response, postdata) { r = JSON.parse(response.responseText); $('#list7').setSelection(r.id); }";
			
			$g7->set_actions(array(
					"add"=>true,
					"edit"=>true,
					"delete"=>true,
					"rowactions"=>false,
					"export"=>true,
					"autofilter" => true,
					"search" => false
				)
			);
			$g7->select_command = "SELECT * FROM (
				SELECT idparabola
				,idlokasi
				,merk
				,diameter
				,tipe
				,kondisi
				,thn_perolehan
				, iduser_created,created
				, CONCAT(us.first_name,' ',IFNULL(us.last_name,'')) nama_lengkap 
				FROM trx_parabola ms 
				INNER JOIN auth_users us ON us.id=ms.iduser_created WHERE ms.idlokasi='$idlokasi'
			) tablegab";
			$g7->table = "trx_parabola";
				
			$cols =array();
			$col = array();
			$col["title"] = "ID";
			$col["name"] = "idparabola";
			$col["search"] = true;
			$col["editable"] = false;
			$col["hidden"] = true;
			$col["width"] = "20";
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "Merk";
			$col["name"] = "merk";
			$col["search"] = true;
			$col["editable"] = true;
			$col["isnull"] = true;	
			$col["autoid"] = false;	
			$col["align"] = "left";
			$col["width"] = "150";
			$col["editrules"] = array("required"=>true);
			$col["editoptions"] = array( "style"=>"text-align:left","maxlength" => "25", "size"=>"20");
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "Diameter";
			$col["name"] = "diameter";
			$col["search"] = true;
			$col["editable"] = true;
			$col["isnull"] = true;	
			$col["autoid"] = false;	
			$col["align"] = "left";
			$col["width"] = "150";
			$col["editrules"] = array("required"=>true,"number"=>true);
			$col["editoptions"] = array( "style"=>"text-align:left","maxlength"=>"10", "size"=>"10");
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "Tipe";
			$col["name"] = "tipe";
			$col["search"] = true;
			$col["align"] = "left";
			$col["editable"] = true;
			$col["width"] = "150";
			$col["edittype"] = "select";
			$col["stype"] = "select";
			$col["formatter"] = "select";
			$col["searchoptions"] = array("value" =>"'';Parabola Jaring (Mesh):Parabola Jaring (Mesh);Parabola Solid:Parabola Solid;Parabola Mini:Parabola Mini");
			$col["editoptions"] = array("value" =>"'';Parabola Jaring (Mesh):Parabola Jaring (Mesh);Parabola Solid:Parabola Solid;Parabola Mini:Parabola Mini");
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "Kondisi";
			$col["name"] = "kondisi";
			$col["search"] = true;
			$col["align"] = "left";
			$col["editable"] = true;
			$col["width"] = "150";
			$col["edittype"] = "select";
			$col["stype"] = "select";
			$col["formatter"] = "select";
			$col["searchoptions"] = array("value" =>"'';Baik:Baik;Rusak:Rusak;Sedang Diperbaiki:Sedang Diperbaiki");
			$col["editoptions"] = array("value" =>"'';Baik:Baik;Rusak:Rusak;Sedang Diperbaiki:Sedang Diperbaiki");
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "Tahun Perolehan";
			$col["name"] = "thn_perolehan";
			$col["search"] = true;
			$col["align"] = "center";
			$col["editable"] = true;
			$col["width"] = "120";
			$col["editrules"] = array("required"=>true);
			$col["editoptions"] = array("onfocus"=>"set_mask_years(this)", "size"=>"5");
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "User Created";
			$col["name"] = "nama_lengkap";
			$col["width"] = "200";
			$col["search"] = true;
			$col["editable"] = false;
			$col["edit_options"]= array ("maxlength"=>"11");
			$col["align"] = "left";
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "Created";
			$col["name"] = "created"; 
			$col["width"] = "200";
			$col["editable"] = false; // this column is editable
			$col["editoptions"] = array("size"=>"20", "defaultValue" => date("d.m.Y")); // with default display of textbox with size 20
			$col["editrules"] = array("required"=>true, "edithidden"=>true); // and is required
			$cols[] = $col;
			
			$g7->set_columns($cols);
			$g7->set_options($grid);

			$e = array();
			$e["on_insert"] = array("setParabola", null, true); 
			$g7->set_events($e); 

			function setParabola(&$data) 
			{ 
				Global $iduser; 
				$data["params"]["iduser_created"] = $iduser;
				Global $idlokasi; 
				$data["params"]["idlokasi"] = $idlokasi;
			} 
		}
		/*end grid 7*/
			
		//Grid 8 : Detail Pemancar
		{
			$g8 = new jqgrid($this->db_conf);
			Global $id_pemancar;
			$id_pemancar = intval($_GET["rowid"]);
			
			$grid = array();
			$grid["caption"] = "Detail Pemancar";
			$grid["rowNum"] = 20; 
			$grid["rowList"] = array(20,40,100,'All');
			$grid["rownumbers"] = true;
			$grid["sortname"] = 'iddetpemancar'; 
			$grid["autowidth"] = true;
			$grid["shrinkToFit"] = false;
			$grid["forceFit"] = false;
			$grid["resizable"] = true;
			$grid["multiselect"] = false; 
			$grid["rowactions"] = true; 
			$grid["toolbar"] = "both"; 
			$grid["height"] = ""; 
			$grid["autoresize"] = true;
			$grid["add_options"] = array("width"=>"360");
			$grid["edit_options"] = array("width"=>"360");
			$grid["view_options"] = array("width"=>"360");
			$grid["export"] = array("format"=>"xls", "filename"=>"detailpemancar", "sheetname"=>"data-detailpemancar");
			
			
			
			$g8->set_actions(array(
					"add"=>true,
					"edit"=>true,
					"delete"=>true,
					"rowactions"=>false,
					"export"=>true,
					"autofilter" => true,
					"search" => false
				)
			);
			$g8->select_command = "SELECT * FROM (
				SELECT iddetpemancar
						,id_pemancar
						,project
						,merk
						,tahun
						,daya
						,kondisi
						,iduser_created
						,created
						, CONCAT(us.first_name,' ',IFNULL(us.last_name,'')) nama_lengkap 
					FROM detail_pemancar ms 
					INNER JOIN auth_users us ON us.id=ms.iduser_created 
					WHERE ms.id_pemancar='$id_pemancar'
					) tablegab";
			$g8->table = "detail_pemancar";
			
			
			$cols = array();
			$col = array();
			$col["title"] = "ID";
			$col["name"] = "iddetpemancar";
			$col["search"] = true;
			$col["editable"] = false;
			$col["isnull"] = true;
			$col["hidden"] = true;
			$col["width"] = "20";
			$cols[] = $col;
			
			
			
			$col = array();
			$col["title"] = "Project";
			$col["name"] = "project";
			$col["search"] = true;
			$col["editable"] = true;
			$col["isnull"] = true;	
			$col["autoid"] = false;	
			$col["align"] = "left";
			$col["width"] = "120";
			$col["editrules"] = array("required"=>true);
			$col["isnull"] = true;
			$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
			$col["editoptions"] = array( "style"=>"text-align:left","maxlength" => "20", "size"=>"15");
			$cols[] = $col;
			
			
			
			$col = array();
			$col["title"] = "Merk";
			$col["name"] = "merk";
			$col["search"] = true;
			$col["editable"] = true;
			$col["isnull"] = true;	
			$col["autoid"] = false;	
			$col["align"] = "left";
			$col["width"] = "150";
			$col["editrules"] = array("required"=>true);
			$col["isnull"] = true;
			$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
			$col["editoptions"] = array( "style"=>"text-align:left","maxlength" => "20", "size"=>"20");
			$cols[] = $col;
			
			
			$col = array();
			$col["title"] = "Daya";
			$col["name"] = "daya";
			$col["search"] = true;
			$col["editable"] = true;
			$col["isnull"] = true;	
			$col["autoid"] = false;	
			$col["align"] = "left";
			$col["width"] = "150";
			$col["editrules"] = array("required"=>true);
			$col["isnull"] = true;
			$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
			$col["editoptions"] = array( "style"=>"text-align:left","maxlength" => "20", "size"=>"20");
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "Tahun Perolehan";
			$col["name"] = "tahun";
			$col["search"] = true;
			$col["align"] = "center";
			$col["editable"] = true;
			$col["width"] = "130";
			$col["editrules"] = array("required"=>true);
			$col["isnull"] = true;
			$col["editoptions"] = array("onfocus"=>"set_mask_years(this)", "size"=>"5");
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "Kondisi";
			$col["name"] = "kondisi";
			$col["search"] = true;
			$col["editable"] = true;
			$col["isnull"] = true;	
			$col["autoid"] = false;	
			$col["align"] = "left";
			$col["width"] = "150";
			$col["editrules"] = array("required"=>true);
			$col["isnull"] = true;
			$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
			$col["editoptions"] = array( "style"=>"text-align:left","maxlength" => "20", "size"=>"20");
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "User Created";
			$col["name"] = "nama_lengkap";
			$col["width"] = "200";
			$col["search"] = true;
			$col["editable"] = false;
			$col["edit_options"]= array ("maxlength"=>"11");
			$col["align"] = "left";
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "Created";
			$col["name"] = "created"; 
			$col["width"] = "200";
			$col["editable"] = false; // this column is editable
			$col["editoptions"] = array("size"=>"20", "defaultValue" => date("d.m.Y")); // with default display of textbox with size 20
			$col["editrules"] = array("required"=>true, "edithidden"=>true); // and is required
			$cols[] = $col;
			
			$g8->set_columns($cols);
			$g8->set_options($grid);
		
			$e = array();
			$e["on_insert"] = array("setDetailPemancar", null, true); 
			$g8->set_events($e); 

			function setDetailPemancar(&$data) 
			{ 
				Global $iduser; 
				Global $id_pemancar; 
				$data["params"]["iduser_created"] = $iduser;
				$data["params"]["id_pemancar"] = $id_pemancar;
			} 
		}
		/*end grid 8*/
		
		
		/*set grid*/
		$data["gridlokasi"] = $g->render('list1');
		$data["gridpemancar"] = $g2->render('list2');
		$data["gridtower"] =  $g3->render('list3');
		$data["gridsistemantena"] = $g4->render('list4');
		// $data["gridcatudaya"] = $g5->render('list5');
		// $data["gridups"] = $g6->render('list6');
		// $data["gridparabola"] = $g7->render('list7');
		$data["griddetailpemancar"] = $g8->render('list8');
		
		//$data["gridlokasi"] = '';
		//$data["gridpemancar"] = '';
		//$data["gridtower"] = '';
		//$data["gridsistemantena"] = '';
		$data["gridcatudaya"] = '';
		$data["gridups"] = '';
		$data["gridparabola"] = '';
		//$data["griddetailpemancar"] = '';
		$data['breadcrumbs'] = $this->Global_model->create_breadcrumbs(["Transmisi"]);
		$this->load->view('layout/header',$head);
		$this->load->view('layout/sidebar');
		$this->load->view('v_transmisi',$data);
		$this->load->view('layout/footer');

		}

	}

