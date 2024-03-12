<?php defined('BASEPATH') OR exit('No direct script access allowed');

		use PhpOffice\PhpWord\PhpWord;
		use PhpOffice\PhpWord\TemplateProcessor;
		use PhpOffice\PhpWord\Writer\Word2007;

/**
 * Class Auth
 * @property Ion_auth|Ion_auth_model $ion_auth        The ION Auth spark
 * @property CI_Form_validation      $form_validation The form validation library
 */
class Surattugas extends CI_Controller
{
	var $file_name;
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->model('Global_model');
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
		$this->load->library('gridlibrary');
		$g = new jqgrid($this->db_conf);
		$caps = "Surat Tugas";
		
		$grid["caption"] = $caps;
		$grid["rowNum"] = 20; 
		$grid["rowList"] = array(20,40,100,'All');
		$grid["rownumbers"] = true;
		//$grid["sortname"] = 'id'; 
		$grid["autowidth"] = true;
		$grid["shrinkToFit"] = false;
		$grid["forceFit"] = false;
		$grid["resizable"] = true;
		$grid["autoresize"] = false;
		$grid["multiselect"] = false; 
		$grid["rowactions"] = true; 
		$grid["toolbar"] = "top"; 
		$grid["add_options"] = array("width"=>"850");
		$grid["edit_options"] = array("width"=>"850");
		$grid["view_options"] = array("width"=>"700");
		$grid["export"] = array("format"=>"doc", "filename"=>$this->file_name, "sheetname"=>"surattugas");
		$grid2["add_options"]["afterShowForm"] = 'function (form) 
				{

					// insert new form section before specified field
					insert_form_section(form, "no_surat_izin", "Surat Izin");
					insert_form_section(form, "nomor", "Surat Tugas");
		
				}';
		
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
		
		$g->select_command = "SELECT *
								FROM (
									SELECT st.id, no_surat_izin, tgl_surat_izin, kepada_izin, isi_izin
									,perihal, pengaju_izin, tgl_pelaksanaan, tgl_berakhir
									,nomor, menimbang, dasar, kepada, untuk, st.idkabupaten
									, nama_lokasi, tanggal, st.idpegawai, tembusan, lap_tugas
									, st.iduser_created, st.timestamp
									, substr(st.idkabupaten,1,2) idprovinsi
									, pg2.jabatan
									,(SELECT GROUP_CONCAT(nama_lengkap SEPARATOR ', ') 
									FROM ms_pegawai WHERE FIND_IN_SET(idpeg,st.kepada) <> 0 ) AS labelkepada
									FROM trx_surattugas st
									LEFT JOIN ms_pegawai pg ON pg.idpeg=st.idpegawai
									LEFT JOIN ms_pegawai pg2 ON pg2.idpeg=st.idpegawai
									LEFT JOIN ms_kabupaten kb ON kb.idkabupaten=st.idkabupaten 
									) tablegab";
		$g->table = "trx_surattugas";
				
		$col = array();
		$col["title"] = "ID";
		$col["name"] = "id";
		$col["editable"] = true;
		$col["hidden"] = true;
		$col["isnull"] = true;	
		$col["autoid"] = true;	
		$col["export"] = false;	
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Action";
		$col["name"] = "view_more";
		$col["width"] = "80";
		$col["align"] = "center";
		$col["search"] = false;
		$col["sortable"] = false;
		$col["on_data_display"] = array("encodeurl_exportnodin",""); 
		function encodeurl_exportnodin($data) { 
			$vencode = urlencode(base64_encode(date('dmY').$data["id"]));
			
			if($data["docs"]){
				$str .=  "<a href='.././".$data["docs"]."' target='_blank'><i class='fa fa-file-pdf-o text-danger' aria-hidden='true'></i> Final</a>";
			}else{
				if(!(empty($vencode))){
					$str = "<a href='".base_url()."surattugas/tugas_export?id=$vencode' target='_blank'><i class='fa fa-file-word-o text-info' aria-hidden='true'> draft</i></a>"; 
				}else
					$str = "";
			}
			return $str;
			
		}
		$cols[] = $col;
		
		

		$col = array();
		$col["title"] = "Nomor Surat Izin";
		$col["name"] = "no_surat_izin";
		$col["search"] = true;
		$col["editable"] = true;
		$col["width"] = "180";
		$col["editoptions"] = array("maxlength" => "100","size"=>50, "placeholder"=>"Nomor Surat Izin.....");
		$col["editrules"] = array("required"=>false);
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Tgl Surat Izin";
		$col["name"] = "tgl_surat_izin";
		$col["editable"] = true;
		$col["formatter"] = "date"; 
		$col["formatoptions"] = array("srcformat"=>'Y-m-d',"newformat"=>'d-m-Y');
		$col["editoptions"] = array("defaultValue" => Date('d-m-Y'));
		$col["width"] = "100";
		$col["align"] = "center";
		$col["editrules"] = array("required"=>false); 
		$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
		$cols[] = $col;	
		
		$col = array();
		$col["title"] = "Perihal";
		$col["name"] = "perihal";
		$col["search"] = true;
		$col["align"] = "left";
		$col["editable"] = true;
		$col["width"] = "250";
		$col["editoptions"] = array("maxlength" => "250", "size"=>90, "placeholder"=>"Masukan perihal pengajuan izin ...");
		$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
		$cols[] = $col;
		
		$col = array();
		$col = array();
		$col["title"] = "Kepada";
		$col["name"] = "kepada_izin";
		$col["editable"] = true;
		$col["hidden"] = true;
		$col["export"] = false;
		$cols[] = $col;	
		
		$col = array();
		$col["title"] = "Izin Kepada";
		$col["name"] = "jabatan";
		$col["dbname"] = "jabatan";
		$col["editable"] = true;
		$col["width"] = "380";
		$col["formatter"] = "autocomplete"; // autocomplete
		$col["editoptions"] = array("placeholder"=>"Masukan nama jabatan izin diajukan ...", "size"=>80);
		$col["formatoptions"] = array("sql"=>"SELECT DISTINCT idpeg AS k, CONCAT(nama_lengkap, ', ',jabatan) AS v 
																		FROM ms_pegawai where aktif='1'
																		ORDER BY 2", "update_field"=>"kepada_izin");
		$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
		$cols[] = $col;
		
		/*$col = array();
		$col["title"] = "Kepada";
		$col["name"] = "kepada_izin";
		$col["search"] = true;
		$col["align"] = "left";
		$col["editable"] = true;
		$col["width"] = "200";
		$col["editoptions"] = array("maxlength" => "50", "size"=>70, "placeholder"=>"Masukan Kepada Izin...");
		$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
		$cols[] = $col;*/
		
		$col = array();
		$col["title"] = "Isi Surat Izin";
		$col["name"] = "isi_izin";
		$col["width"] = "230";
		$col["editable"] = true;
		$col["edittype"] = "textarea";
		$col["editrules"] = array("required"=>true); 
		$col["editoptions"] = array("rows"=>2, "maxlength"=>1000, "cols"=>80, "placeholder"=>"berisikan isi surat......"); 
		$col["show"] = array("list"=>false, "add"=>true, "edit"=>true, "view"=>true); 
		$cols[] = $col;	

		$col = array();
		$col["title"] = "Yang Ditugaskan";
		$col["name"] = "kepada";
		$col["width"] = "200";
		$col["align"] = "left";
		$col["search"] = false;
		$col["export"] = false;
		$col["editable"] = true;
		$col["formatter"] = "select";
		$col["edittype"] = "select"; 
		$str = $g->get_dropdown_values("SELECT DISTINCT pg.idpeg AS k, CONCAT(replace(pg.nama_lengkap,',','') ,' (',pg.nip,')') AS v 
																		FROM ms_pegawai pg 
																		ORDER BY 2");
		$col["editoptions"]["value"] = $str;
		$col["editoptions"]["dataInit"] = "function(){ setTimeout(function(){ link_select2('{$col["name"]}'); },200); }";
		$col["editoptions"]["multiple"] = true;
		$col["editoptions"]["size"] = 185;
		$col["editoptions"]["rows"] = 5;
		$col["editoptions"]["style"] = "width:70%";
		$col["editrules"] = array("required"=>true); 
		$col["stype"] = "select"; 
		$col["searchoptions"] = array("value"=>$str,"sopt"=>array("cn")); 
		$col["searchoptions"]["dataInit"] = "function(){ setTimeout(function(){ link_select2('gs_{$col["name"]}'); },200); }";
		$col["show"] = array("list"=>false,"edit"=>true,"add"=>true,"view"=>false);
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Yang Ditugaskan";
		$col["name"] = "labelkepada";
		$col["width"] = "200";
		$col["align"] = "left";
		$col["search"] = true;
		$col["export"] = true; 
		$col["editable"] = false;
		$col["show"] = array("list"=>true,"edit"=>false,"add"=>false,"view"=>true);
		$col["formatter"] = "function(cellval,options,rowdata){ return '<div class=\"readmore\">'+cellval+'</div>'; }";
		$col["unformat"] = "function(cellval,options,cell){ if(cellval == 'undefined') return ''; return jQuery(cell).children('div').html(); }";
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Yang Mengajukan";
		$col["name"] = "pengaju_izin";
		$col["width"] = "200";
		$col["editable"] = true; 
		$col["edittype"] = "select";
		$col["stype"] = "select";
		$col["formatter"] = "select";
		$str = $g->get_dropdown_values("SELECT DISTINCT idpeg AS k, nama_lengkap AS v
																		FROM ms_pegawai
																		ORDER BY 2");
		$col["editoptions"] = array("value" =>"0:NA;".$str, "separator" => ":", "delimiter" => ";");
		$col["export"] = false;
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Nomor Surat Tugas";
		$col["name"] = "nomor";
		$col["search"] = true;
		$col["editable"] = true;
		$col["width"] = "180";
		$col["editoptions"] = array("maxlength" => "100","size"=>50, "placeholder"=>"Nomor Surat Tugas.....");
		$col["editrules"] = array("required"=>false);
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Menimbang";
		$col["name"] = "menimbang";
		$col["search"] = true;
		$col["align"] = "left";
		$col["editable"] = true;
		$col["width"] = "250";
		$col["edittype"] = "textarea";
		$col["editoptions"] = array("rows"=>2, "cols"=>90);
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Dasar";
		$col["name"] = "dasar";
		$col["search"] = true;
		$col["align"] = "left";
		$col["editable"] = true;
		$col["width"] = "300";
		$col["edittype"] = "textarea";
		$col["editoptions"] = array("rows"=>2, "cols"=>90, "placeholder"=>"berisikan tujuan dasar kegiatan......(Max 1000 karakter)");
		$cols[] = $col;
		
		
		$col = array();
		$col["title"] = "Untuk";
		$col["name"] = "untuk";
		$col["width"] = "230";
		$col["editable"] = true;
		$col["edittype"] = "textarea";
		$col["editrules"] = array("required"=>false); 
		$col["editoptions"] = array("rows"=>2, "maxlength"=>1000, "cols"=>90, "placeholder"=>"berisikan tujuan atau nama kegiatan......(Max 1000 karakter)"); 
		$col["show"] = array("list"=>false, "add"=>true, "edit"=>true, "view"=>true); 
		$cols[] = $col;
		
		/*
		$col = array();
		$col["title"] = "Provinsi";
		$col["name"] = "idprovinsi";
		$col["dbname"] = "ms_provinsi.idprovinsi";
		$col["width"] = "100";
		$col["search"] = true;
		$col["editable"] = true;
		$col["edittype"] = "select"; // render as select
		$str = $g->get_dropdown_values("SELECT DISTINCT idprovinsi AS k, nama_provinsi AS v FROM ms_provinsi ORDER BY 2");
		$col["editoptions"] = array(
					"value"=>":;".$str,
					"onchange" => array(	"update_field"=>"idkabupaten",
											"sql"=>"select distinct idkabupaten as k, nama_kabupaten as v from ms_kabupaten WHERE idprovinsi = '{idprovinsi}'"
										)
					);

		// $col["editoptions"]["onload"]["sql"] = "select id as k, name as v from state WHERE country_id IN ({country_id})";
		$col["formatter"] = "select"; // display label, not value
		$col["stype"] = "select"; // enable dropdown search
		$col["searchoptions"] = array("value" => ":;".$str);
		$col["show"] = array("list"=>false, "add"=>true, "edit"=>true, "view"=>false); 
		$cols[] = $col;

		$col = array();
		$col["title"] = "Kabupaten/Kota";
		$col["name"] = "idkabupaten";
		$col["dbname"] = "ms_kabupaten.idkabupaten";
		$col["width"] = "100";
		$col["search"] = true;
		$col["editable"] = true;
		$col["edittype"] = "select"; // render as select
		$str = $g->get_dropdown_values("SELECT DISTINCT idkabupaten AS k, nama_kabupaten AS v  FROM ms_kabupaten order by nama_kabupaten");
		$col["editoptions"] = array(
									"value"=>":;".$str
									);

		$col["formatter"] = "select"; // display label, not value
		$col["stype"] = "select"; // enable dropdown search
		$col["searchoptions"] = array("value" => ":;".$str);
		$col["show"] = array("list"=>false, "add"=>true, "edit"=>true, "view"=>false); 
		$cols[] = $col;
		
		
		
		$col = array();
		$col["title"] = "Lokasi Tujuan";
		$col["name"] = "nama_lokasi";
		$col["width"] = "200";
		$col["editable"] = true; 
		$col["edittype"] = "select";
		$col["stype"] = "select";
		$col["formatter"] = "select";
		$str = $g->get_dropdown_values("SELECT DISTINCT idlokasi AS k, nama_lokasi AS v FROM ms_lokasi_tvri WHERE idlokasi <> 0 ORDER BY 2");
		$col["editoptions"] = array("value" =>":;".$str, "separator" => ":", "delimiter" => ";" );
		$col["show"] = array("list"=>true, "add"=>true, "edit"=>true, "view"=>true); 
		$cols[] = $col;*/
		
		$col = array();
		$col["title"] = "Tanggal Surat Tugas";
		$col["name"] = "tanggal";
		$col["search"] = true;
		$col["align"] = "left";
		$col["editable"] = true;
		$col["width"] = "200";
		//$col["editrules"] = array("required"=>true);
		$col["formatter"] 		= "date";
		$col["formatoptions"] = array("srcformat"=>'Y-m-d',"newformat"=>'d-m-Y', "opts" => array("changeYear" => true, "changeMonth" => true));
		$col["editoptions"] = array("maxlength" => "", "size"=>20, "placeholder"=>" Tanggal Surat Tugas!");
		$cols[] = $col;
		
/*
		$col = array();
		 $col["title"] = "Awal Tugas";
		 $col["name"] = "tgl_pelaksanaan"; 
		$col["search"] = true;
		$col["align"] = "left";
		$col["editable"] = true;
		$col["width"] = "200";
		//$col["editrules"] = array("required"=>true);
		$col["formatter"] 		= "date";
		$col["formatoptions"] = array("srcformat"=>'Y-m-d',"newformat"=>'d-m-Y', "opts" => array("changeYear" => true, "changeMonth" => true));
		$col["editoptions"] = array("maxlength" => "", "size"=>30, "placeholder"=>"Masukan Tanggal Awal Tugas...");
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Akhir Tugas";
		$col["name"] = "tgl_berakhir"; 
		$col["search"] = true;
		$col["align"] = "left";
		$col["editable"] = true;
		$col["width"] = "200";
		//$col["editrules"] = array("required"=>true);
		$col["formatter"] 		= "date";
		$col["formatoptions"] = array("srcformat"=>'Y-m-d',"newformat"=>'d-m-Y', "opts" => array("changeYear" => true, "changeMonth" => true));
		$col["editoptions"] = array("maxlength" => "", "size"=>30, "placeholder"=>"Masukan Tanggal Selesai Tugas...");
		$cols[] = $col;
		*/
				
		/*$col = array();
		$col["title"] = "Mengesahkan";
		$col["name"] = "idpegawai";
		$col["width"] = "280";
		$col["search"] = true;
		$col["editable"] = true;
		$col["align"] = "left";
		$col["edittype"] = "select";
		$col["stype"] = "select";
		$col["formatter"] = "select";
		$col["editrules"] = array("required"=>true); 
		$str = $g->get_dropdown_values("SELECT DISTINCT idpeg AS k, CONCAT('[',nama_lengkap,'] ',nip) AS v  
																		FROM ms_pegawai
																		WHERE nip IN (SELECT nip FROM ms_pegawai)
																		ORDER BY 2");
		$col["editoptions"] = array("value" =>"0:NA;".$str, "separator" => ":", "delimiter" => ";");
		$col["export"] = false;
		$cols[] = $col;*/
		
		// $col = array();
		// $col["title"] = "Paraf Jabatan";
		// $col["name"] = "paraf_jabatan"; 
		// $col["width"] = "250";
		// $col["align"] = "left";
		// $col["search"] = true;
		// $col["editable"] = true;
		// $col["formatter"] = "select";
		// $col["edittype"] = "select"; 
		// $str = $g->get_dropdown_values("SELECT DISTINCT idpeg AS k, CONCAT('[',nama_lengkap,'] ',paraf) AS v  
																		// FROM ms_pegawai
																		// WHERE nip IN (SELECT nip FROM ms_pegawai)
																		// ORDER BY 2");
		// $col["searchoptions"] = array("value" =>$str, "separator" => ":", "delimiter" => ";");
		// $col["editoptions"] = array("value" =>"0:NA;".$str, "separator" => ":", "delimiter" => ";");
		// $cols[] = $col;
		
		$col = array();
		$col["title"] = "Tembusan";
		$col["name"] = "tembusan";
		$col["editable"] = true;
		$col["edittype"] = "textarea";
		$col["editoptions"] = array("maxlength" => "255","rows"=>2,"cols"=>80, "placeholder"=>"1.\n2.\n....");
		$col["show"] = array("list"=>false,"edit"=>true,"add"=>true,"view"=>true);
		$cols[] = $col;
		
		$// file upload column
		$col = array();
		$col["title"] = "Laporan Tugas";
		$col["name"] = "lap_tugas"; 
		$col["width"] = "50";
		$col["align"] = "center";
		$col["export"] = false;
		$col["editable"] = true; // this column is editable
		$col["edittype"] = "file"; // render as file
		$col["upload_dir"] = "uploads/laporan_tugas"; // upload here
		$col["editrules"] = array("ifexist"=>"rename"); 
		$col["editrules"]["allowedext"] = "pdf";
		$col["show"] = array("list"=>false,"edit"=>true,"add"=>false,"view"=>false); // only show in add/edit dialog
		$cols[] = $col;

		// virtual column to display uploaded file in grid
		$col = array();
		$col["title"] = "Laporan Tugas";
		$col["name"] = "dok_surat2";
		$col["width"] = "100";
		$col["align"] = "center";
		$col["editable"] = true;
		$col["export"] = false;
		$col["search"] = false;
		// display none if nothing is uploaded, otherwise make link.
		$col["on_data_display"] = array("display_icon","");
		function display_icon($data)
		{
			// get upload folder url for display in grid -- change it as per your upload path
			$upload_url = explode("/",$_SERVER["REQUEST_URI"]);
			array_pop($upload_url);
			$upload_url = implode("/",$upload_url)."/";
			$tampil = base_url().$data["lap_tugas"];
			$hasil_enkripsi = base64_encode($data["lap_tugas"]);
			$tampilpdf = base_url()."view/lihat/".$hasil_enkripsi;
			$file = $data["lap_tugas"];

			$arr = explode(".",$file);
			$ext = $arr[count($arr)-1];

			if (empty($file))
				return "-";
			else if (strtolower($ext) == "doc" || strtolower($ext) == "xls" || strtolower($ext) == "docx" || strtolower($ext) == "xlsx")
				return "<a href='$tampil' target='_blank'>Download File</a>";
			else if (strtolower($ext) == "pdf" )
					return "<a href='$tampil' target='_blank'><i class='fa fa-book' aria-hidden='true'></i> File - <a href='$tampil' target='_blank'>".strtolower($ext)."</a>";
			else if (strtolower($ext) == "png" || strtolower($ext) == "jpg" || strtolower($ext) == "jpeg")
				return "<a href='$tampil' target='_blank'><img height=30 src='$tampil'></a>";
			else
				return $file;
		}

		// only show in listing & image in edit
		$col["show"] = array("list"=>true,"edit"=>false,"add"=>false,"view"=>true); 

		// display image in edit dialog
		$col["editoptions"]["dataInit"] = "function(o){jQuery(o).parent().html(o.value);}";

		$cols[] = $col;
		
		$col = array();
		$col["title"] = "User Created";
		$col["name"] = "iduser_created";
		$col["search"] = false;
		$col["export"] = false;
		$col["editable"] = true;
		$col["hidden"] = true;
		$col["isnull"] = false;
		$col["autoid"] = false;	
		$col["formatter"] = "select";
		$col["editoptions"] = array("defaultValue" => $this->session->userdata('user_id'), "separator" => ":", "delimiter" => ";", "value"=>$this->session->userdata('user_id'));
		$cols[] = $col;
		
		/*$col = array();
		$col["title"] = "User Created";
		$col["name"] = "nama_lengkap";
		$col["width"] = "150";
		$col["search"] = true;
		$col["editable"] = false;
		$col["edit_options"]= array ("maxlenght"=>"11");
		$col["align"] = "left";
		$col["hidden"] = true;
		$cols[] = $col;*/
		
		$col = array();
		$col["title"] = "Created";
		$col["name"] = "timestamp"; 
		$col["align"] = "center";
		$col["width"] = "160";
		$col["editable"] = true; 
		$col["formatoptions"] = array("srcformat"=>'Y-m-d H:i:s',"newformat"=>'d-m-Y H:i:s',"opts" => array());
		$col["show"] = array("list"=>true,"edit"=>false,"add"=>false,"view"=>true);
		$cols[] = $col;
		
		$g->set_columns($cols);
		$f = array();
		$f["column"] = "lap_tugas";
		$f["op"] = "cn";
		$f["value"] = "uploads";
		$f["class"] = "focus-row";
		$f_conditions[] = $f;
		
$g->set_conditional_css($f_conditions);
		$g->set_options($grid); 
		
		Global $iduser_created; 
		$iduser_created = $this->session->userdata('user_id'); 
		
		$e = null;		
		$e["on_insert"] = array("setkolomprovinsi", null, true);
		$e["on_update"] = array("setkolomprovinsi", null, true);
		$g->set_events($e); Global $iduser_created; 
		$g->set_events($e); Global $idprovinsi; 
		$iduser_created = $this->session->userdata('user_id'); 
		$g->set_events($e); 
		
		function setkolomprovinsi(&$data)
		{
			Global $iduser_created; 
			$data["params"]["iduser_created"] = $iduser_created;
			unset($data["params"]["idprovinsi"]);
		}

		$data['gridout'] = $g->render("list1");
		$this->load->model('Global_model');
		$head['collapse'] = false;
		$head['title'] = "Home";
		$data['breadcrumbs'] = $this->Global_model->create_breadcrumbs(["Surat Tugas"]);
		
		$this->load->view('layout/header',$head);
		$this->load->view('layout/sidebar');
		$this->load->view('v_surattugas',$data);
		$this->load->view('layout/footer');
	}
	
	function tugas_export()
	{
		$temp = str_replace(date('dmY'),'',base64_decode(urldecode($this->input->get('id', TRUE))));
		$params = explode('###',$temp);
		$id = $params[0];
		
		$qry = $this->db->query('SELECT s.id,s.nomor,s.no_surat_izin,s.tgl_surat_izin, s.isi_izin
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
		$rsl = $qry->row();
		
		
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
	//end surat tugas;
}