<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//1. include library
require 'Base_Controller.php';

//2. extends REST_Controller
ini_set('memory_limit', '512M');
class Out extends Base_Controller{
    
    function __construct($config = 'rest') {
        parent::__construct($config);
    }

    function version_get(){
        $info = [
            'version' => '0.1-dev',
            'name' => 'API TVRI'
        ];
        $this->response($info);
    }

    public function login_post() {
        error_reporting(E_ERROR);
        $phone = $this->post('phone');
        $this->load->model('users_model', 'user');
        $user = $this->user->find_by_phone($phone);
        if (isset($user)) {
            $token = "";
            $token = $user['token'];
            if($token == "" or $token == NULL){
                $token = md5(rand(0, 10000000));
                $this->ion_auth->update($user['id'], [
                    'token' => $token,
                'device_id' => $device_id
                ]);
            }
            $this->ion_auth->update($user['id'], 
            ['device_id' => $device_id
            ]);
            $this->response($user);
        } else {
            $error_messages = $this->ion_auth->errors();
            $this->response($error_messages, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function lokasi_get(){
        $data = $this->db->query("SELECT idlokasi,IFNULL(nama_lokasi,'') as nama_lokasi,
        IFNULL(alamat,'') as alamat FROM ms_lokasi_tvri")->result_array();
        if(isset($data)){
            $this->response($data);
        }
        $this->response([], REST_Controller::HTTP_NOT_FOUND);
    }

    public function pegawai_get(){
        //$idlokasi = $this->get('idlokasi');
        //$data = $this->db->query("SELECT * FROM ms_pegawai WHERE idlokasi='$idlokasi'")->result_array();
        $data = $this->db->query("SELECT * FROM ms_pegawai ORDER BY nama_lengkap")->result_array();
        if(isset($data)){
            $this->response($data);
        }
        $this->response([], REST_Controller::HTTP_NOT_FOUND);
    }

    public function qc_get(){
        $rs = $this->db->query("SELECT *,
        (case 
         when tipe_form='text' then 1
         when tipe_form='foto' then 2
         when tipe_form='combobox' then 3
         when tipe_form='radio button' then 4
         when tipe_form='number' then 5
         else 6
         end) as viewType
        FROM qc_metering WHERE aktif=1 AND app=1 ORDER BY kategori,kode_urut ASC")->result_array();
        $data = [];
        if(isset($rs)){
            foreach($rs as $rows){
                $split = [];
                if($rows['tipe_form'] == 'radio button' or $rows['tipe_form'] == 'combobox'){
                    $split = explode("#",$rows['pilihan_jawaban']);
                }
                $rows['pilihan'] = $split;
                $data[] = $rows;
            }
        }
        $this->response($data, REST_Controller::HTTP_OK);
    }

    public function laporan_digital_post(){
        $laporan = $this->post("laporan");
        $post = json_decode($laporan, true);//tobe array
        $iduser = $post['iduserCreated'];
        $idqc = $post['idqc'];
        $tgl_laporan = $post['tglLaporan'];

        if (!empty($_FILES['image']['name'])) {
			$config['upload_path'] = FCPATH . 'assets/meterring/';
			$config['overwrite'] = TRUE;
			$config['allowed_types'] = "*";

			// Load and initialize upload library
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			if(!$this->upload->do_upload('image')){
				log_message("ERROR", "error upload file" . $this->upload->display_errors());
				//HTTP_INTERNAL_SERVER_ERROR 
				$this->response($idmetering, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
            }
            $post['jawaban'] = 'assets/meterring/'. $_FILES['image']['name'];
            $post['pathlocal'] = $post['pathlocal'];
        }

        $data = [
            'idlokasi' => $post['idlokasi'],
            'idqc' => $idqc,
            'jenistx' => $post['jenistx'],
            'jawaban' => $post['jawaban'],
            'latitude' => $post['latitude'],
            'longitude' => $post['longitude'],
            'tgl_laporan' =>  $tgl_laporan,
            'iduser_created' => $iduser,
            'idlocal' => $post['idlocal'],
            'pathlocal' => $post['pathlocal'],
        ];
        $idmetering = 0;
        $cek = $this->db->query("SELECT * FROM trx_metering_digital WHERE iduser_created='$iduser' AND 
        idqc='$idqc' AND tgl_laporan='$tgl_laporan' AND jenistx='{$post['jenistx']}'")->row_array();
        if(isset($cek)){
            $idmetering = $post['idmetering'];
            $this->db->where('idmetering',$idmetering);
            $this->db->update('trx_metering_digital',$data);
        }else{
            $this->db->insert('trx_metering_digital',$data);
            $idmetering =  $this->db->insert_id();
        }
        $this->response($idmetering, REST_Controller::HTTP_OK);
    }

    public function laporan_analog_post(){
        $laporan = $this->post("laporan");
        $post = json_decode($laporan, true);//tobe array
        $iduser = $post['iduserCreated'];
        $idqc = $post['idqc'];
        $tgl_laporan = $post['tglLaporan'];
        if (!empty($_FILES['image']['name'])) {
			$config['upload_path'] = FCPATH . 'assets/meterring/';
			$config['overwrite'] = TRUE;
			$config['allowed_types'] = "*";

			// Load and initialize upload library
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			if(!$this->upload->do_upload('image')){
				log_message("ERROR", "error upload file" . $this->upload->display_errors());
				$this->response($idmetering, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
            }
            $post['jawaban'] = 'assets/meterring/'. $_FILES['image']['name'];
            $post['pathlocal'] = $post['pathlocal'];
        }
        $data = [
            'idlokasi' => $post['idlokasi'],
            'idqc' => $idqc,
            'jenistx' => $post['jenistx'],
            'jawaban' => $post['jawaban'],
            'latitude' => $post['latitude'],
            'longitude' => $post['longitude'],
            'tgl_laporan' =>  $tgl_laporan,
            'iduser_created' => $iduser,
            'idlocal' => $post['idlocal'],
            'pathlocal' => $post['pathlocal']
        ];
        $idmetering = 0;
        if(isset($post['idmetering'])){
            $idmetering = $post['idmetering'];
        }
        $cek = $this->db->query("SELECT * FROM trx_metering_analog WHERE idmetering='$idmetering'")->row_array();
        log_message("DEBUG", $this->db->last_query());
        if(isset($cek)){
            $this->db->where('idmetering',$idmetering);
            $this->db->update('trx_metering_analog',$data);
        }else{
            $this->db->insert('trx_metering_analog',$data);
            $idmetering =  $this->db->insert_id();
        }
        log_message("DEBUG", $this->db->last_query());
        $this->response($idmetering, REST_Controller::HTTP_OK);
    }

    public function laporan_pic_post(){
        $laporan = $this->post("laporan");
        $post = json_decode($laporan, true);//tobe array
        $iduser = $post['iduserCreated'];
        $idqc = $post['idqc'];
        $tgl_laporan = $post['tglLaporan'];
        if (!empty($_FILES['image']['name'])) {
			$config['upload_path'] = FCPATH . 'assets/meterring/';
			$config['overwrite'] = TRUE;
			$config['allowed_types'] = "*";

			// Load and initialize upload library
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			if(!$this->upload->do_upload('image')){
				log_message("ERROR", "error upload file" . $this->upload->display_errors());
				$this->response($idmetering, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
            }
            $post['jawaban'] = 'assets/meterring/'. $_FILES['image']['name'];
            $post['pathlocal'] = $post['pathlocal'];
        }
        $data = [
            'idlokasi' => $post['idlokasi'],
            'idqc' => $idqc,
            'jawaban' => $post['jawaban'],
            'latitude' => $post['latitude'],
            'longitude' => $post['longitude'],
            'tgl_laporan' =>  $tgl_laporan,
            'iduser_created' => $iduser,
            'idlocal' => $post['idlocal'],
            'pathlocal' => $post['pathlocal']
        ];
        $idmetering = 0;
        $cek = $this->db->query("SELECT * FROM trx_metering_laporan WHERE iduser_created='$iduser' AND 
        idqc='$idqc' AND tgl_laporan='$tgl_laporan'")->row_array();
        if(isset($cek)){
            $idmetering = $post['idmetering'];
            $this->db->where('idmetering',$idmetering);
            $this->db->update('trx_metering_laporan',$data);
            log_message('DEBUG',$this->db->last_query());
        }else{
            $this->db->insert('trx_metering_laporan',$data);
            $idmetering =  $this->db->insert_id();
        }
        $this->response($idmetering, REST_Controller::HTTP_OK);
    }

    public function laporan_analog_get(){
		$bln = $this->get('bulan');
		$tahun = $this->get('tahun');
		if(!isset($bln)){
			$bln = date('m');
		}
		if(!isset($tahun)){
			$tahun = date('Y');
		}
        $idlokasi = $this->get('idlokasi');
        $data = [];
        $bulan = $this->db->query("SELECT MONTH(tgl_laporan) as bulan,YEAR(tgl_laporan) as tahun FROM trx_metering_analog WHERE idlokasi='$idlokasi' AND MONTH(tgl_laporan) = '$bln' AND YEAR(tgl_laporan) = '$tahun' GROUP BY MONTH(tgl_laporan),YEAR(tgl_laporan)")->result_array();
        if(isset($bulan)){
            foreach($bulan as $rows){
                $isi = $this->db->query("SELECT *,MONTH(tgl_laporan) as bulan,DATE_FORMAT(tgl_laporan,'%d') as tanggal,1 as sent,CONCAT(IFNULL(first_name,''),' ',
                IFNULL(last_name,'')) as user,YEAR(tgl_laporan) as tahun FROM trx_metering_analog 
                INNER JOIN auth_users u ON u.id = trx_metering_analog.iduser_created WHERE MONTH(tgl_laporan) = '{$rows['bulan']}' AND YEAR(tgl_laporan)='{$rows['tahun']}' AND trx_metering_analog.idlokasi='$idlokasi' ORDER BY tgl_laporan")->result_array();
                $rows['laporan'] = $isi;
                $data[] = $rows;
            }
        }
        $this->response($data, REST_Controller::HTTP_OK);
    }

    public function laporan_digital_get(){
		$bln = $this->get('bulan');
		$tahun = $this->get('tahun');
				if(!isset($bln)){
			$bln = date('m');
		}
		if(!isset($tahun)){
			$tahun = date('Y');
		}
        $idlokasi = $this->get('idlokasi');
        $data = [];
        $bulan = $this->db->query("SELECT MONTH(tgl_laporan) as bulan,YEAR(tgl_laporan) as tahun FROM trx_metering_digital WHERE idlokasi='$idlokasi' AND MONTH(tgl_laporan) = '$bln' AND YEAR(tgl_laporan) = '$tahun' GROUP BY MONTH(tgl_laporan),YEAR(tgl_laporan)")->result_array();
        if(isset($bulan)){
            foreach($bulan as $rows){
                $isi = $this->db->query("SELECT *,MONTH(tgl_laporan) as bulan,DATE_FORMAT(tgl_laporan,'%d') as tanggal,1 as sent,CONCAT(IFNULL(first_name,''),' ',
                IFNULL(last_name,'')) as user,YEAR(tgl_laporan) as tahun FROM trx_metering_digital 
                INNER JOIN auth_users u ON u.id = trx_metering_digital.iduser_created WHERE MONTH(tgl_laporan) = '{$rows['bulan']}' AND YEAR(tgl_laporan)='{$rows['tahun']}' AND trx_metering_digital.idlokasi='$idlokasi' ORDER BY tgl_laporan")->result_array();
                $rows['laporan'] = $isi;
                $data[] = $rows;
            }
        }
        $this->response($data, REST_Controller::HTTP_OK);
    }

    public function laporan_pic_get(){

		$bln = $this->get('bulan');
		$tahun = $this->get('tahun');
				if(!isset($bln)){
			$bln = date('m');
		}
		if(!isset($tahun)){
			$tahun = date('Y');
		}
        $idlokasi = $this->get('idlokasi');
        $data = [];
        $bulan = $this->db->query("SELECT MONTH(tgl_laporan) as bulan,YEAR(tgl_laporan) as tahun FROM trx_metering_laporan WHERE idlokasi='$idlokasi' AND MONTH(tgl_laporan) = '$bln' AND YEAR(tgl_laporan) = '$tahun' GROUP BY MONTH(tgl_laporan),YEAR(tgl_laporan)")->result_array();
        if(isset($bulan)){
            foreach($bulan as $rows){
                $isi = $this->db->query("SELECT *,MONTH(tgl_laporan) as bulan,DATE_FORMAT(tgl_laporan,'%d') as tanggal,1 as sent,CONCAT(IFNULL(first_name,''),' ',
                IFNULL(last_name,'')) as user,YEAR(tgl_laporan) as tahun FROM trx_metering_laporan 
                INNER JOIN auth_users u ON u.id = trx_metering_laporan.iduser_created
                WHERE MONTH(tgl_laporan) = '{$rows['bulan']}' AND YEAR(tgl_laporan)='{$rows['tahun']}' AND trx_metering_laporan.idlokasi='$idlokasi' ORDER BY tgl_laporan")->result_array();
                $rows['laporan'] = $isi;
                $data[] = $rows;
            }
        }
        $this->response($data, REST_Controller::HTTP_OK);
    }

    function laporan_digital_delete_post(){
        $idmetering = $this->post('idmetering');
        $this->db->query("DELETE FROM trx_metering_digital WHERE idmetering='$idmetering'");
        if ($this->db->affected_rows() > 0) {
            $this->response($idmetering, REST_Controller::HTTP_OK);
        } else {
            $this->response(0, REST_Controller::HTTP_NOT_FOUND);
        }
    }

    function laporan_analog_delete_post(){
        $idmetering = $this->post('idmetering');
        $this->db->query("DELETE FROM trx_metering_analog WHERE idmetering='$idmetering'");
        if ($this->db->affected_rows() > 0) {
            $this->response($idmetering , REST_Controller::HTTP_OK);
        } else {
            $this->response(0 , REST_Controller::HTTP_NOT_FOUND);
        }
    }

    function laporan_pic_delete_post(){
        $idmetering = $this->post('idmetering');
        $this->db->query("DELETE FROM trx_metering_laporan WHERE idmetering='$idmetering'");
        if ($this->db->affected_rows() > 0) {
            $this->response($idmetering , REST_Controller::HTTP_OK);
        } else {
            $this->response(0 , REST_Controller::HTTP_NOT_FOUND);
        }
    }

    function isaktif_get(){
        $iduser = $this->get('iduser');
        $this->load->model('users_model', 'user');
        $user = $this->user->is_active($iduser);
        if($user){
            $this->response(1, REST_Controller::HTTP_OK);
        }
        $this->response(0, REST_Controller::HTTP_OK);
    }
	
	 public function trxmitra_get(){
        $data = $this->db->query("SELECT * FROM trx_mitra")->result_array();
        if(isset($data)){
            $this->response($data);
        }
        $this->response([], REST_Controller::HTTP_NOT_FOUND);
    }

    public function trxbamux_get(){
        $data = $this->db->query("SELECT trx_ba_mux.*,ms_mitra.nama_mitra as namaMitra,ms_lokasi_tvri.nama_lokasi as namaLokasi FROM trx_ba_mux INNER JOIN ms_mitra ON ms_mitra.idmitra = trx_ba_mux.idmitra 
        INNER JOIN ms_lokasi_tvri ON ms_lokasi_tvri.idlokasi = trx_ba_mux.idlokasi")->result_array();
        if(isset($data)){
            $this->response($data);
        }
        $this->response([], REST_Controller::HTTP_NOT_FOUND);
    }

    public function laporan_trxbamux_post(){
        $laporan = $this->post("laporan");
        $post = json_decode($laporan, true);//tobe array
        $iduser = $post['iduserCreated'];
        $idqc = $post['idqc'];
        $tgl_laporan = $post['tglLaporan'];
        if (!empty($_FILES['image']['name'])) {
			$config['upload_path'] = FCPATH . 'assets/mux/';
			$config['overwrite'] = TRUE;
			$config['allowed_types'] = "*";

			// Load and initialize upload library
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			if(!$this->upload->do_upload('image')){
				log_message("ERROR", "error upload file" . $this->upload->display_errors());
				$this->response($idmetering, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
            }
            $post['jawaban'] = 'assets/mux/'. $_FILES['image']['name'];
            $post['pathlocal'] = $post['pathlocal'];
        }
        $data = [
            'idlokasi' => $post['idlokasi'],
            'idmitra' => $post['idmitra'],
            'idqc' => $idqc,
            'jawaban' => $post['jawaban'],
            'latitude' => $post['latitude'],
            'longitude' => $post['longitude'],
            'tgl_laporan' =>  $tgl_laporan,
            'iduser_created' => $iduser,
            'idlocal' => $post['idlocal'],
            'pathlocal' => $post['pathlocal']
        ];
        $idmetering = 0;
        if(isset($post['idmetering'])){
            $idmetering = $post['idmetering'];
        }
        $cek = $this->db->query("SELECT * FROM trx_ba_mux WHERE idmetering='$idmetering'")->row_array();
        log_message("DEBUG", $this->db->last_query());
        if(isset($cek)){
            $this->db->where('idmetering',$idmetering);
            $this->db->update('trx_ba_mux',$data);
        }else{
            $this->db->insert('trx_ba_mux',$data);
            $idmetering =  $this->db->insert_id();
        }
        log_message("DEBUG", $this->db->last_query());
        $this->response($idmetering, REST_Controller::HTTP_OK);
    }

    public function trxbafs_get(){
        $data = $this->db->query("SELECT trx_ba_field_strength.*,ms_lokasi_tvri.nama_lokasi as namaLokasi FROM trx_ba_field_strength
        INNER JOIN ms_lokasi_tvri ON ms_lokasi_tvri.idlokasi = trx_ba_field_strength.idlokasi")->result_array();
        
        foreach($data as $index => $row){
            foreach($row as $key => $value){
            if($key == 'headendMuxDto'){
                $row['headendMuxDto'] = json_decode($value,true,JSON_UNESCAPED_SLASHES);
                $data[$index] = $row;
            }
            if($key == 'detailOnIrd'){
                $row['detailOnIrd'] = json_decode($value,true,JSON_UNESCAPED_SLASHES);
                $data[$index] = $row;
            }
            if($key == 'detailOnEncoder'){
                $row['detailOnEncoder'] = json_decode($value,true,JSON_UNESCAPED_SLASHES);
                $data[$index] = $row;
            }
        }
        }
        if(isset($data)){
            $this->response($data);
        }
        $this->response([], REST_Controller::HTTP_NOT_FOUND);
    }

    public function laporan_trxbafs_post(){
        $laporan = $this->post("laporan");
        $post = json_decode($laporan, true);//tobe array
        $iduser = $post['iduserCreated'];
        $idqc = $post['idqc'];
        $tgl_laporan = $post['tglLaporan'];
        if (!empty($_FILES['image']['name'])) {
			$config['upload_path'] = FCPATH . 'assets/mux/';
			$config['overwrite'] = TRUE;
			$config['allowed_types'] = "*";

			// Load and initialize upload library
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			if(!$this->upload->do_upload('image')){
				log_message("ERROR", "error upload file" . $this->upload->display_errors());
				$this->response($idmetering, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
            }
            $post['jawaban'] = 'assets/mux/'. $_FILES['image']['name'];
            $post['pathlocal'] = $post['pathlocal'];
        }
            $jawaban = $post['jawaban'];
            if(count($post['headendMuxDto']) > 0){
                $jawaban = json_encode($post['headendMuxDto']);
            }
            if(count($post['detailOnIrd']) > 0){
                $jawaban = json_encode($post['detailOnIrd']);
            }
            if(count($post['detailOnEncoder']) > 0){
                $jawaban = json_encode($post['detailOnEncoder']);
            }
        $data = [
            'idlokasi' => $post['idlokasi'],
            'idqc' => $idqc,
            'jawaban' =>  $jawaban,
            'latitude' => $post['latitude'],
            'longitude' => $post['longitude'],
            'tgl_laporan' =>  $tgl_laporan,
            'iduser_created' => $iduser,
            'idlocal' => $post['idlocal'],
            'pathlocal' => $post['pathlocal'],
            'headendMuxDto' => json_encode($post['headendMuxDto']),
            'detailOnIrd' => json_encode($post['detailOnIrd']),
            'detailOnEncoder' => json_encode($post['detailOnEncoder'])
        ];
        $idba = 0;
        if(isset($post['idba'])){
            $idba = $post['idba'];
        }
        $cek = $this->db->query("SELECT * FROM trx_ba_field_strength WHERE idba='$idba'")->row_array();
        log_message("DEBUG", $this->db->last_query());
        if(isset($cek)){
            $this->db->where('idba',$idba);
            $this->db->update('trx_ba_field_strength',$data);
        }else{
            $this->db->insert('trx_ba_field_strength',$data);
            $idba =  $this->db->insert_id();
        }
        log_message("DEBUG", $this->db->last_query());
        $this->response($idba, REST_Controller::HTTP_OK);
    }

    public function msdecoder_get(){
        $data = $this->db->query("SELECT CONCAT(`ms_merk_decoder`.`namamerkd`,' # ', `ms_tipe_decoder`.`tipe_decoder`) AS v,  CONCAT(`ms_merk_decoder`.`namamerkd`,' / ', `ms_tipe_decoder`.`tipe_decoder`) AS k
        FROM
            `ms_tipe_decoder`
            INNER JOIN `ms_merk_decoder` 
                ON (`ms_tipe_decoder`.`idmerkd` = `ms_merk_decoder`.`idmerkd`)
        WHERE (`ms_merk_decoder`.`aktif` ='1'
            AND `ms_tipe_decoder`.`aktif` ='1')")->result_array();
        if(isset($data)){
            $this->response($data);
        }
        $this->response([], REST_Controller::HTTP_NOT_FOUND);
    }

    public function msmultiplexer_get(){
        $data = $this->db->query("SELECT CONCAT(`ms_merk_multiplexer`.`namamerk`,' # ', `ms_tipe_multiplexer`.`tipe_multiplexer`) AS v,  CONCAT(`ms_merk_multiplexer`.`namamerk`,' / ', `ms_tipe_multiplexer`.`tipe_multiplexer`) AS k
        FROM
            `ms_tipe_multiplexer`
            INNER JOIN `ms_merk_multiplexer` 
                ON (`ms_tipe_multiplexer`.`idmerk` = `ms_merk_multiplexer`.`idmerk`)
        WHERE (`ms_merk_multiplexer`.`aktif` ='1'
            AND `ms_tipe_multiplexer`.`aktif` ='1')")->result_array();
        if(isset($data)){
            $this->response($data);
        }
        $this->response([], REST_Controller::HTTP_NOT_FOUND);
    }
}