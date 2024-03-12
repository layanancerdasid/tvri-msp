<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	include_once(APPPATH."third_party/PhpWord/Autoloader.php");

	use PhpOffice\PhpWord\Autoloader;
	use PhpOffice\PhpWord\Settings;
	use PhpOffice\PhpWord\Element\Field;
	use PhpOffice\PhpWord\Element\Table;
	use PhpOffice\PhpWord\Element\TextRun;
	use PhpOffice\PhpWord\SimpleType\TblWidth;
	Autoloader::register();
	Settings::loadConfig();
class Kak extends CI_Controller {
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
		$this->load->library('gridlibrary');
		Global $iduser; 
		$iduser = $this->session->userdata('user_id'); 
					
		//Grid 1
		{
			$g = new jqgrid($this->db_conf);
			$caps = "Rencana Kegiatan (KAK/TOR)";
			
			$grid["caption"] = $caps;
			$grid["rowNum"] = 20; 
			$grid["rowList"] = array(40,40,100,'All');
			$grid["rownumbers"] = true;
			$grid["autowidth"] = true;
			$grid["shrinkToFit"] = false;// agar panjang row bisa sesuai
			$grid["forceFit"] = false;
			$grid["resizable"] = true;
			$grid["sortname"] = 'idkak';
			$grid["autoresize"] = true;
			$grid["multiselect"] = false; 
			$grid["toolbar"] = "buttom"; 
			$grid["add_options"] = array("width"=>"750");
			$grid["edit_options"] = array("width"=>"750");
			$grid["view_options"] = array("width"=>"750");
			$grid["export"] = array("format"=>"xls", "filename"=>$this->file_name, "sheetname"=>"master-kategoriuji");
			
			
					
			$grid["detail_grid_id"] = "list2,list3";
			$grid["onSelectRow"] = "function(id){ 
			var idlokasi = $('#list1').jqGrid('getCell', id, 'nama_kegiatani');
			$('#list1').jqGrid('setCaption','KAK : '+idrencana); 
			$('#list2').jqGrid('setCaption','Tower : '+idrencana); 
			$('#list3').jqGrid('setCaption','SistemAntena : '+idrencana); 
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
			
			$g->select_command = "SELECT idkak, unit_kerja, nama_kegiatan, program, sasaran_program, indikator_kinerja, thn_anggaran, sasaran_kegiatan, 
								  indikator_kegiatan, keluaran, indikator_keluaran, volume_keluaran, satuan_ukur, dasar_hukum, gambaran_kegiatan, penerima_manfaat, strategi_pencapaian, sumber_dana, perkiraan_biaya, ms_satker_tvri.nama_satker, iduser_created FROM trx_kak  
								  LEFT JOIN ms_satker_tvri on ms_satker_tvri.idsatker=trx_kak.unit_kerja";
			$g->table = "trx_kak";
			
				
			$col = array();
			$col["title"] = "ID Rencana";
			$col["name"] = "idkak";
			$col["search"] = true;
			$col["hidden"] = true;
			$col["align"] = "center";
			$col["width"] = "80";
			$cols[] = $col;
			
			$col = array();
		$col["title"] = "Draft";
		$col["name"] = "view_more";
		$col["width"] = "80";
		$col["align"] = "center";
		$col["search"] = false;
		$col["sortable"] = false;
		$col["on_data_display"] = array("encodeurl_exportnodin",""); 
		function encodeurl_exportnodin($data) { 
			$vencode = urlencode(base64_encode(date('dmY').$data["idkak"]));
			
			if($data["docs"]){
				$str .=  "<a href='.././".$data["docs"]."' target='_blank'><i class='fa fa-file-pdf-o text-danger' aria-hidden='true'></i> Final</a>";
			}else{
				if(!(empty($vencode))){
					$str = "<a href='".base_url()."kak/cetak_konsep?id=$vencode' target='_blank'><i class='icon-xl fas fa-file-word'></i></a>"; 
				}else
					$str = "";
			}
			return $str;
			
		}
		$cols[] = $col;
			
			$col = array();
			$col["title"] = "Nama Kegiatan";
			$col["name"] = "nama_kegiatan";
			$col["search"] = true;
			$col["align"] = "left";
			$col["editable"] = true;
			$col["width"] = "200";
			$col["editrules"] = array("required"=>true);
			$col["editoptions"] = array("maxlength" => "250", "size"=>80);
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "Thn Anggaran";
			$col["name"] = "thn_anggaran";
			$col["search"] = true;
			$col["align"] = "left";
			$col["editable"] = true;
			$col["width"] = "50";
			$col["editrules"] = array("required"=>true);
			$col["editoptions"] = array("maxlength" => "4", "size"=>20);
			$col["editoptions"] = array("onfocus"=>"set_mask_years(this)", "maxlength" => "4", "size"=>10);
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "Perkiraan Biaya";
			$col["name"] = "perkiraan_biaya";
			$col["search"] = true;
			$col["align"] = "left";
			$col["editable"] = true;
			$col["formatter"] = "currency";
			$col["formatoptions"] = array("prefix" => "Rp. ",
                                "suffix" =>"",
                                "thousandsSeparator" => ".",
                                "decimalSeparator" => ",",
                                "decimalPlaces" => 0);
			$col["width"] = "150";
			$col["editrules"] = array("required"=>true);
			$col["editoptions"] = array("onfocus"=>"set_field_number0(this)", "maxlength" => "18", "size"=>40);
			$cols[] = $col;
			
			
						
			$col = array();
			$col["title"] = "Unit Kerja";
			$col["name"] = "unit_kerja"; 
			$col["editable"] = true;
			$col["hidden"] = true;
			$col["export"] = false;
			$cols[] = $col;	
			
			$col = array();
			$col["title"] = "Unit Kerja";
			$col["name"] = "nama_satker";
			$col["dbname"] = "nama_satker";
			$col["editable"] = true;
			$col["width"] = "380";
			$col["formatter"] = "autocomplete"; // autocomplete
			$col["editoptions"] = array("placeholder"=>"Masukan nama satuan kerja...", "size"=>80);
			$col["formatoptions"] = array("sql"=>"SELECT idsatker as k, nama_satker as v FROM ms_satker_tvri", "update_field"=>"unit_kerja");
			$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "Program";
			$col["name"] = "program";
			$col["search"] = true;
			$col["align"] = "left";
			$col["editable"] = true;
			$col["width"] = "300";
			$col["editrules"] = array("required"=>true);
			$col["editoptions"] = array("maxlength" => "250", "size"=>80);
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "Sasaran Program";
			$col["name"] = "sasaran_program";
			$col["search"] = true;
			$col["align"] = "left";
			$col["editable"] = true;
			$col["width"] = "300";
			$col["editrules"] = array("required"=>true);
			$col["edittype"] = "textarea";
			$col["editoptions"] = array("rows"=>3,"cols"=>90, "placeholder"=>"Isikan Sasaran Program....");
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "Indikator Kinerja Program";
			$col["name"] = "indikator_kinerja";
			$col["search"] = true;
			$col["align"] = "left";
			$col["editable"] = true;
			$col["width"] = "300";
			$col["editrules"] = array("required"=>true);
			$col["edittype"] = "textarea";
			$col["editoptions"] = array("rows"=>3,"cols"=>90, "placeholder"=>"Isikan Indikator Kinerja Program....");
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "Sasaran Kegiatan";
			$col["name"] = "sasaran_kegiatan";
			$col["search"] = true;
			$col["align"] = "left";
			$col["editable"] = true;
			$col["width"] = "200";
			$col["editrules"] = array("required"=>true);
			$col["edittype"] = "textarea";
			$col["editoptions"] = array("rows"=>3,"cols"=>90, "placeholder"=>"Isikan Sasaran Kegiatan....");
			$col["show"] = array("list"=>false,"edit"=>true,"add"=>true,"view"=>true);
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "Indikator Kegiatan";
			$col["name"] = "indikator_kegiatan";
			$col["search"] = true;
			$col["align"] = "left";
			$col["editable"] = true;
			$col["width"] = "200";
			$col["editrules"] = array("required"=>true);
			$col["edittype"] = "textarea";
			$col["editoptions"] = array("rows"=>3,"cols"=>90, "placeholder"=>"Isikan Indikator Kinerja Kegiatan....");
			$col["show"] = array("list"=>false,"edit"=>true,"add"=>true,"view"=>true);
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "Keluaran (Output)";
			$col["name"] = "keluaran";
			$col["search"] = true;
			$col["align"] = "left";
			$col["editable"] = true;
			$col["width"] = "200";
			$col["editrules"] = array("required"=>true);
			$col["edittype"] = "textarea";
			$col["editoptions"] = array("rows"=>3,"cols"=>90, "placeholder"=>"Isikan Keluaran (Output) Kegiatan....");
			$col["show"] = array("list"=>false,"edit"=>true,"add"=>true,"view"=>true);
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "Indikator Keluaran";
			$col["name"] = "indikator_keluaran";
			$col["search"] = true;
			$col["align"] = "left";
			$col["editable"] = true;
			$col["width"] = "200";
			$col["editrules"] = array("required"=>true);
			$col["edittype"] = "textarea";
			$col["editoptions"] = array("rows"=>3,"cols"=>90, "placeholder"=>"Isikan Indikator Keluaran....");
			$col["show"] = array("list"=>false,"edit"=>true,"add"=>true,"view"=>true);
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "Volume Keluaran";
			$col["name"] = "volume_keluaran";
			$col["search"] = true;
			$col["align"] = "left";
			$col["editable"] = true;
			$col["width"] = "200";
			$col["editrules"] = array("required"=>true);
			$col["editoptions"] = array("maxlength" => "250", "size"=>80, "placeholder"=>"Isikan Sumber Dana....");
			$col["show"] = array("list"=>false,"edit"=>true,"add"=>true,"view"=>true);
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "Satuan Ukur";
			$col["name"] = "satuan_ukur";
			$col["search"] = true;
			$col["align"] = "left";
			$col["editable"] = true;
			$col["width"] = "200";
			$col["editrules"] = array("required"=>true);
			$col["editoptions"] = array("maxlength" => "250", "size"=>80, "placeholder"=>"Isikan Sumber Dana....");
			$col["show"] = array("list"=>false,"edit"=>true,"add"=>true,"view"=>true);
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "Dasar Hukum";
			$col["name"] = "dasar_hukum";
			$col["search"] = true;
			$col["align"] = "left";
			$col["editable"] = true;
			$col["width"] = "200";
			$col["editrules"] = array("required"=>true);
			$col["edittype"] = "textarea";
			$col["editoptions"] = array("rows"=>3,"cols"=>90, "placeholder"=>"Isikan Dasar Hukum ....");
			$col["show"] = array("list"=>false,"edit"=>true,"add"=>true,"view"=>true);
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "Gambaran Kegiatan";
			$col["name"] = "gambaran_kegiatan";
			$col["search"] = true;
			$col["align"] = "left";
			$col["editable"] = true;
			$col["width"] = "200";
			$col["editrules"] = array("required"=>true);
			$col["edittype"] = "textarea";
			$col["editoptions"] = array("rows"=>3,"cols"=>90, "placeholder"=>"Isikan Gambaran Kegiatan....");
			$col["show"] = array("list"=>false,"edit"=>true,"add"=>true,"view"=>true);
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "Penerima Manfaat";
			$col["name"] = "penerima_manfaat";
			$col["search"] = true;
			$col["align"] = "left";
			$col["editable"] = true;
			$col["width"] = "200";
			$col["editrules"] = array("required"=>true);
			$col["edittype"] = "textarea";
			$col["editoptions"] = array("rows"=>3,"cols"=>90, "placeholder"=>"Isikan Penerima Manfaat....");
			$col["show"] = array("list"=>false,"edit"=>true,"add"=>true,"view"=>true);
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "Strategi Pencapaian";
			$col["name"] = "strategi_pencapaian";
			$col["search"] = true;
			$col["align"] = "left";
			$col["editable"] = true;
			$col["width"] = "200";
			$col["editrules"] = array("required"=>true);
			$col["edittype"] = "textarea";
			$col["editoptions"] = array("rows"=>3,"cols"=>90, "placeholder"=>"Isikan Strategi Pencapaian ....");
			$col["show"] = array("list"=>false,"edit"=>true,"add"=>true,"view"=>true);
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "Sumber Dana";
			$col["name"] = "sumber_dana";
			$col["search"] = true;
			$col["align"] = "left";
			$col["editable"] = true;
			$col["width"] = "200";
			$col["editrules"] = array("required"=>true);
			$col["edittype"] = "textarea";
			$col["editoptions"] = array("rows"=>3,"cols"=>90, "placeholder"=>"Isikan SUmber Dana ....");
			$col["show"] = array("list"=>false,"edit"=>true,"add"=>true,"view"=>true);
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

			
		}
		/*end Grid utama*/
		
		//Grid 2 : Pemancar
		{
			$g2 = new jqgrid($this->db_conf);
			Global $idkak;
			$idkak = intval($_GET["rowid"]);
			// $idlokasi = intval ($_GET["idlokasi"]);
			
			// inisialisasi
			$grid = array();
			$grid["caption"] = "Rencana Anggaran Biaya (RAB)";
			$grid["rowNum"] = 20; 
			$grid["rowList"] = array(20,40,100,'All');
			$grid["rownumbers"] = true;
			$grid["sortname"] = 'idrab'; 
			$grid["autowidth"] = true;
			$grid["shrinkToFit"] = true;
			$grid["forceFit"] = false;
			$grid["resizable"] = true;
			$grid["multiselect"] = false; 
			$grid["rowactions"] = true; 
			$grid["toolbar"] = "both"; 
			$grid["height"] = ""; 
			$grid["autoresize"] = true;
			$grid["add_options"] = array("width"=>"650");
			$grid["edit_options"] = array("width"=>"650");
			$grid["view_options"] = array("width"=>"650");
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
			$g2->select_command = "SELECT idrab, idkak, nama_rab, jumlah, satuan, biaya_satuan, iduser_created from trx_rab WHERE idkak='$idkak' ";
			$g2->table = "trx_rab";

			// inisialisasi kolom
			$cols = array();
				
			$col = array();
			$col["title"] = "ID";
			$col["name"] = "idrab";
			$col["search"] = true;
			$col["editable"] = false;
			$col["hidden"] = true;
			$col["width"] = "20";
			$cols[] = $col;
			
			

			$col = array();
			$col["title"] = "Nama Komponen RAB";
			$col["name"] = "nama_rab";
			$col["search"] = true;
			$col["align"] = "left";
			$col["editable"] = true;
			$col["width"] = "350";
			$col["editrules"] = array("required"=>true);
			$col["isnull"] = true;
			$col["editoptions"] = array("maxlength" => "250", "size"=>70, "placeholder"=>"Isikan Nama Kompone/Kegiatan/Barang ...");
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "Jumlah";
			$col["name"] = "jumlah";
			$col["search"] = true;
			$col["align"] = "left";
			$col["editable"] = true;
			$col["width"] = "200";
			$col["editrules"] = array("required"=>true);
			$col["isnull"] = true;
			$col["editoptions"] = array("style"=>"text-align:left", "maxlength" => "11", "size"=>20, "placeholder"=>"Isikan Jumlah Komponen/Kegiatan/Barang ...", "onfocus"=>"set_field_number0(this)");
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "Satuan";
			$col["name"] = "satuan";
			$col["search"] = true;
			$col["align"] = "left";
			$col["editable"] = true;
			$col["width"] = "200";
			$col["editrules"] = array("required"=>true);
			$col["isnull"] = true;
			$col["editoptions"] = array("style"=>"text-align:left", "maxlength" => "80", "size"=>40, "placeholder"=>"Isikan Satuan Kompone/Kegiatan/Barang ...");
			$cols[] = $col;

			$col = array();
			$col["title"] = "Biaya Satuan";
			$col["name"] = "biaya_satuan";
			$col["search"] = true;
			$col["align"] = "left";
			$col["editable"] = true;
			$col["formatter"] = "currency";
			$col["formatoptions"] = array("prefix" => "Rp. ",
                                "suffix" =>"",
                                "thousandsSeparator" => ".",
                                "decimalSeparator" => ",",
                                "decimalPlaces" => 0);
			$col["width"] = "150";
			$col["editrules"] = array("required"=>true);
			$col["editoptions"] = array("onfocus"=>"set_field_number0(this)", "maxlength" => "18", "size"=>40, "placeholder"=>"Isikan Biaya Satuan ...");
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

			$g2->set_columns($cols);
			$g2->set_options($grid);

			$e = array();
			$e["on_insert"] = array("setRAB", null, true); 
			$g2->set_events($e); 
			

			function setRAB(&$data) 
			{ 
				Global $idkak; 
				$data["params"]["idkak"] = $idkak;
			}
			
		}
		
		/*end grid 2*/
		
		//Grid 3 : Lampiran
		{
			$g3 = new jqgrid($this->db_conf);
			$idkak = intval($_GET["rowid"]);
			Global $idkak;
			
			$grid = array();
			$grid["caption"] = "Lampiran KAK";
			$grid["rowNum"] = 20; 
			$grid["rowList"] = array(20,40,100,'All');
			$grid["rownumbers"] = true;
			$grid["sortname"] = 'idlampiran'; 
			$grid["autowidth"] = true;
			$grid["shrinkToFit"] = true;
			$grid["forceFit"] = false;
			$grid["resizable"] = true;
			$grid["multiselect"] = false; 
			$grid["rowactions"] = true; 
			$grid["toolbar"] = "both"; 
			$grid["height"] = ""; 
			$grid["autoresize"] = true;
			$grid["add_options"] = array("width"=>"650");
			$grid["edit_options"] = array("width"=>"650");
			$grid["view_options"] = array("width"=>"650");
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
			$g3->select_command = "SELECT idlampiran, idkak, nama_lampiran, isi_lampiran FROM trx_lampiran  WHERE idkak='$idkak'";
			$g3->table = "trx_lampiran";
					
			$cols = array();
			
			$col = array();
			$col["title"] = "ID Lampiran";
			$col["name"] = "idlampiran";
			$col["search"] = true;
			$col["editable"] = false;
			$col["hidden"] = true;
			$col["width"] = "20";
			$cols[] = $col;
				
			$col = array();
			$col["title"] = "Nama Lampiran";
			$col["name"] = "nama_lampiran";
			$col["search"] = true;
			$col["align"] = "left";
			$col["editable"] = true;
			$col["width"] = "200";
			$col["align"] = "left";
			$col["editrules"] = array("required"=>true);
			$col["isnull"] = true;
			$col["editoptions"] = array( "style"=>"text-align:left","maxlength" => "250", "size"=>"70");
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "Isi Lampiran";
			$col["name"] = "isi_lampiran";
			$col["search"] = true;
			$col["align"] = "left";
			$col["editable"] = true;
			$col["width"] = "600";
			$col["editrules"] = array("required"=>true);
			$col["edittype"] = "textarea";
			$col["editoptions"] = array("rows"=>4,"cols"=>80, "placeholder"=>"Isikan Isi/Penjelasan dari Lampiran ....");
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
			
			$g3->set_columns($cols);
			$g3->set_options($grid);
			
			$e = array();
			$e["on_insert"] = array("setTower", null, true); 
			$g3->set_events($e); 

			function setTower(&$data) 
			{ 
				Global $idkak;
				$data["params"]["idkak"] = $idkak;
			} 
			
		}		
		/*end grid 3*/
		
		
		/*set grid*/
		$data["gridkak"] = $g->render('list1');
		$data["gridrab"] = $g2->render('list2');
		$data["gridspek"] =  $g3->render('list3');

		$data['breadcrumbs'] = $this->Global_model->create_breadcrumbs(["Kerangka Acuan Kerja (KAK)"]);
		$this->load->view('layout/header',$head);
		$this->load->view('layout/sidebar');
		$this->load->view('v_kak',$data);
		$this->load->view('layout/footer');

		}

	
	
	function cetak_konsep(){
		$this->load->model('M_konsep', 'm_konsep');
		$temp = str_replace(date('dmY'),'',base64_decode(urldecode($this->input->get('id', TRUE))));
		$params = explode('###',$temp);
		$id = $params[0];
		$dt = $this->m_konsep->data_konsep($id);
		$dt_rab = $this->m_konsep->data_rab('trx_rab','idkak', $id, 'idrab');//$table, $key, $key_value, $order
		#$dt_lampiran = $this->m_konsep->data_rab('trx_lampiran','idkak', $id, 'idlampiran');
		$dt_lembaga = $this->m_konsep->data_lembaga(substr($dt->unit_kerja,0,2));
		$PHPWord = new \PhpOffice\PhpWord\PhpWord();
		\PhpOffice\PhpWord\Settings::setPdfRendererPath('libraries/dompdf/dompdf');
		\PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');
		
		
		$template = $PHPWord->loadTemplate('./assets/uploads/Template/KAK.docx');
			
		$pathsave = './assets/uploads/Template/';
	   $nama_kegiatan = preg_replace('~\R~u', '</w:t><w:br/><w:t>', $dt->nama_kegiatan);
	   
	   $sasaran_program = preg_replace('~\R~u', '</w:t><w:br/><w:t>', $dt->sasaran_program);
	   $indikator_kinerja_progam = preg_replace('~\R~u', '</w:t><w:br/><w:t>', $dt->indikator_kinerja_progam);
	   $sasaran_kegiatan = preg_replace('~\R~u', '</w:t><w:br/><w:t>', $dt->sasaran_kegiatan);
	   $output = preg_replace('~\R~u', '</w:t><w:br/><w:t>', $dt->keluaran);
	    $indikator_output = preg_replace('~\R~u', '</w:t><w:br/><w:t>', $dt->indikator_keluaran);
		$gambaran_kegiatan = preg_replace('~\R~u', '</w:t><w:br/><w:t>', $dt->gambaran_kegiatan);
		$dasar_hukum = preg_replace('~\R~u', '</w:t><w:br/><w:t>', $dt->dasar_hukum);
		$strategi_pencapaian = preg_replace('~\R~u', '</w:t><w:br/><w:t>', $dt->strategi_pencapaian);
		$indikator_kinerja = preg_replace('~\R~u', '</w:t><w:br/><w:t>', $dt->indikator_kinerja);
		$indikator_kegiatan = preg_replace('~\R~u', '</w:t><w:br/><w:t>', $dt->indikator_kegiatan);
		$sumber_dana = preg_replace('~\R~u', '</w:t><w:br/><w:t>', $dt->sumber_dana);
		$keluaran = preg_replace('~\R~u', '</w:t><w:br/><w:t>', $dt->keluaran);
		$indikator_keluaran = preg_replace('~\R~u', '</w:t><w:br/><w:t>', $dt->indikator_keluaran);
   # var_dump($template); exit;
		#$template->setValue('isi',$dt->isi_perintah);
		#$template->setValue('isi', htmlspecialchars($dt->isi_perintah, ENT_COMPAT, 'UTF-8'));
		$template->setValue('kegiatan',$nama_kegiatan);
		$template->setValue('lembaga',$dt_lembaga->nama_satker);
		$template->setValue('unit_kerja',$dt->nama_satker);
		$template->setValue('program',$dt->program);
		$template->setValue('sasaran_program',$sasaran_program);
		$template->setValue('indikator_kinerja_progam',$indikator_kinerja);
		$template->setValue('sasaran_kegiatan',$sasaran_kegiatan);
		$template->setValue('gambaran_kegiatan',$gambaran_kegiatan);
		$template->setValue('penerima_manfaat',$dt->penerima_manfaat);
		$template->setValue('strategi_pencapaian',$dt->strategi_pencapaian);
		$template->setValue('dasar_hukum',$dasar_hukum);
		$template->setValue('indikator_kegiatan',$indikator_kegiatan);
		$template->setValue('sumber_dana',$sumber_dana);
		$template->setValue('output',$keluaran);
		$template->setValue('indikator_output',$indikator_keluaran);
		$template->setValue('volume',$dt->volume);
		$template->setValue('satuan_ukur',$dt->satuan_ukur);
		
		//RAB
		$num_rab = $this->m_konsep->data_rab_row('trx_rab','idkak', $id, 'idrab');
		$jumrow = $num_rab->count;
			$template->cloneRow('nama', $jumrow);
			$i = 0;
			$jumlah = 0;
		foreach ($dt_rab as $row)
		{
			$i++;
				$hasil_rupiah = "Rp " . number_format($row->biaya_satuan,0,',','.');
				$total = "Rp " . number_format($row->jumlah * $row->biaya_satuan,0,',','.');
				$template->setValue("no#$i", $i);
				$template->setValue("nama#$i", $row->nama_rab);
				$template->setValue("jml#$i", $row->jumlah);
				$template->setValue("satuan#$i", $row->satuan);
				$template->setValue("biaya_satuan#$i", $hasil_rupiah);
				$template->setValue("total#$i", $total);
				$jumlah = $row->jumlah * $row->biaya_satuan + $jumlah;
		}
			
		$template->setValue("jumlah", "Rp " . number_format($jumlah,0,',','.'));
		$pajak = "Rp " . number_format(0.1*$jumlah,0,',','.');
		$total_all = "Rp " . number_format(1.1*$jumlah,0,',','.');
		$template->setValue("pajak", $pajak);
		$template->setValue("total_all", $total_all);
		
		
		//filename
		$temp_filename = 'Konsep-KAK-'.date('dmY-H-i-s').'-'.'.docx';
        $template->saveAs($temp_filename);
		

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename='.$temp_filename);
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($temp_filename));
        flush();
        readfile($temp_filename);
        unlink($temp_filename);
        exit;      
	}
	
	public function kak_export()
	{
		$temp = str_replace(date('dmY'),'',base64_decode(urldecode($this->input->get('id', TRUE))));
		$params = explode('###',$temp);
		$id = $params[0];
		
		/*$qry = $this->db->query('SELECT s.id,s.nomor,s.no_surat_izin,s.tgl_surat_izin, s.isi_izin
										,s.perihal,s.pengaju_izin,s.tgl_pelaksanaan,s.tgl_berakhir
										,s.menimbang,s.dasar
										,s.kepada,untuk,s.idkabupaten,s.tanggal,s.idpegawai,s.paraf_jabatan,s.nama_lokasi
										,k.nama_kabupaten,pg.nama_lengkap,pg.pangkat_gol,s.tembusan, pg.jabatan
										,pg2.nama_lengkap AS nama_pengaju, pg2.jabatan AS jabatan_pengaju
										,pg3.nama_lengkap AS mama_pengizin, pg3.jabatan AS kepada_izin
										,DATE_FORMAT(s.tanggal, "%d-%m-%Y") AS tgl
									FROM trx_surattugas s
									LEFT JOIN ms_pegawai pg ON pg.idpeg=s.idpegawai
									LEFT JOIN ms_pegawai pg2 ON pg2.idpeg=s.pengaju_izin
									LEFT JOIN ms_pegawai pg3 ON pg3.idpeg=s.kepada_izin
									LEFT JOIN ms_kabupaten k ON k.idkabupaten=s.idkabupaten
									WHERE id='.$id);
		$rsl = $qry->row();*/
		
		
		$listkolektif = explode(",", $rsl->kepada);
		$jmlrows = count($listkolektif);
		
			$templateProcessor = new TemplateProcessor('assets/uploads/template/surat_tugas.doc');	
			$filename = 'Surat_tugas'.date('d-m-Y').'.doc';
			
			$pegawai = $this->Global_model->get_pegawai($rsl->kepada);
			$jmlparamkoma = explode(",", $rsl->kepada);
			// ECHO json_encode($pegawai); die;
			// $templateProcessor->cloneRow('k1', 2);
			// $templateProcessor->setValue('k0#1', '1');
			// $templateProcessor->setValue('k0#2', '2');
			if($pegawai){
				$templateProcessor->cloneRow('k1', count($jmlparamkoma));
				foreach($pegawai as $idxpeg => $vpeg){
					$n = $idxpeg+1;
					// echo json_encode($vpeg)."<br>";
					$templateProcessor->setValue('k0#'.$n, $n);
					$templateProcessor->setValue('k1#'.$n, trim($vpeg->nama_lengkap));
					$templateProcessor->setValue('k2#'.$n, trim($vpeg->nip));
					// $templateProcessor->setValue('k3#'.$n, trim($vpeg->jabatan));
				}
			}			
			
			if($rsl->kepada){
				$pegawai = $this->Global_model->get_pegawai($rsl->kepada);
				$jmlparamkoma = explode(",", $rsl->kepada);
				if($pegawai){
					$templateProcessor->cloneRow('l1', count($jmlparamkoma));
					foreach($pegawai as $idxpeg => $vpeg){
						$n = $idxpeg+1;
						// echo json_encode($vpeg)."<br>";
						$templateProcessor->setValue('l0#'.$n, $n);
						$templateProcessor->setValue('l1#'.$n, trim($vpeg->nama_lengkap));
						$templateProcessor->setValue('l2#'.$n, trim($vpeg->nip));
						$templateProcessor->setValue('l3#'.$n, trim($vpeg->jabatan));
					}
				}
			}
				
		
		//paraf
		// if($rsl->paraf_jabatan){
			// $pegawai = $this->Global_model->get_pegawai($rsl->paraf_jabatan);
			// if($pegawai){
				// $templateProcessor->cloneRow('tf_jbt', count($pegawai));
				// foreach($pegawai as $n=>$r){
					// $templateProcessor->setValue('tf_jbt#'.($n+1), trim($r->jabatan));
					// $templateProcessor->setValue('tf_nm#'.($n+1), trim($r->nama_lengkap));
				// }
			// }
		// }
		
		// Header
		$templateProcessor->setValue('nomor',$rsl->nomor);
		$templateProcessor->setValue('no_izin',$rsl->no_surat_izin);
		$templateProcessor->setValue('hal',replace_enter($rsl->perihal));
		$templateProcessor->setValue('menimbang',replace_enter($rsl->menimbang));
		$templateProcessor->setValue('dasar',replace_enter($rsl->dasar));
		$templateProcessor->setValue('untuk',replace_enter($rsl->untuk));
		list($d,$m,$y) = explode('-',$rsl->tgl);
		$templateProcessor->setValue('tgl',$d.' '.indonesian_month($m).' '.$y);
		list($d,$m,$y) = explode('-',$rsl->tgl_surat_izin);
		$templateProcessor->setValue('tgl_izin',$y.' '.indonesian_month($m).' '.$d);
		// list($d,$m,$y) = explode('-',$rsl->tgl_pelaksanaan);
		// $templateProcessor->setValue('tgl_mulai',$d.' '.indonesian_month($m).' '.$y);
		// list($d,$m,$y) = explode('-',$rsl->tgl_berakhir);
		// $templateProcessor->setValue('tgl_akhir',$d.' '.indonesian_month($m).' '.$y);
		$templateProcessor->setValue('jbt_pengaju',$rsl->jabatan_pengaju);
		$templateProcessor->setValue('jbt',$rsl->jabatan);
		$templateProcessor->setValue('kpd_izin',$rsl->kepada_izin);
		$templateProcessor->setValue('nm_pengizin',$rsl->mama_pengizin);
		$templateProcessor->setValue('pengaju',$rsl->nama_pengaju);
		$templateProcessor->setValue('jbtn_pengaju',$rsl->jabatan_pengaju);
		$templateProcessor->setValue('isi',replace_enter($rsl->isi_izin));
		$templateProcessor->setValue('ttd_nama',$rsl->nama_lengkap);
		$templateProcessor->setValue('lokasi',$rsl->nama_lokasi);
		$templateProcessor->setValue('tembusan',replace_enter($rsl->tembusan));
		$templateProcessor->saveAs($filename);

		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename='.$filename);
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		header('Content-Length: ' . filesize($filename));
		flush();
		readfile($filename);
		unlink($filename); 
	}
	//end export KAK
}
?>