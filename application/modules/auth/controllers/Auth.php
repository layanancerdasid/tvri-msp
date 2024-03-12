<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Auth
 * @property Ion_auth|Ion_auth_model $ion_auth        The ION Auth spark
 * @property CI_Form_validation      $form_validation The form validation library
 */
class Auth extends CI_Controller
{
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
		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		// else if (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
		// {
			// // redirect them to the home page because they must be an administrator to view this
			// $result = $this->ion_auth->get_users_groups($this->session->userdata('id'))->result_array();
			// foreach($result as $v){
				// $arr[] = $v['name'];
			// }	
			// // return show_error(json_encode($arr));
			// if(in_array('ppk',$arr) || in_array('pengawas',$arr)){
				// redirect('auth/login', 'refresh');
			// }
				// return show_error('You must be an administrator to view this page.');
		// }
		else{
			redirect('dashboard', 'refresh');
		}
	}

	public function users(){
		if (!$this->ion_auth->logged_in()) redirect('auth/login', 'refresh');
		if(in_array(7,$this->session->userdata('priv')) == FALSE) return redirect('404_override');
		// set the flash data error message if there is one
		$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

		//list of additional data
		
		
		$this->load->library('gridlibrary');
		$g = new jqgrid($this->db_conf);
		$caps = "Data Auth:Users";
		
		$grid["caption"] = $caps;
		$grid["rowNum"] = 20; 
		$grid["rowList"] = array(20,40,100,'All');
		$grid["rownumbers"] = true;
		$grid["sortname"] = 'ID'; 
		$grid["autowidth"] = true;
		$grid["shrinkToFit"] = false;
		$grid["forceFit"] = false;
		$grid["resizable"] = true;
		$grid["autoresize"] = false;
		$grid["multiselect"] = false; 
		$grid["rowactions"] = true; 
		$grid["toolbar"] = "buttom"; 
		$grid["add_options"] = array("width"=>"460");
		$grid["edit_options"] = array("width"=>"460");
		$grid["view_options"] = array("width"=>"460");
		$grid["export"] = array("format"=>"xls", "filename"=>$this->file_name, "sheetname"=>"master");
		
		$g->set_actions(array(
				"add"=>false,
				"edit"=>true,
				"delete"=>false,
				"rowactions"=>false,
				"export"=>true,
				"autofilter" => true,
				"search" => false
			)
		);
		
		$g->select_command = "SELECT * FROM (
								SELECT u.id,u.username,u.first_name,u.last_name,u.company,u.password
								,u.ip_address,u.email,u.created_on, h.idlokasi, u.phone
								,GROUP_CONCAT(g.name) as role,u.active 
								,CONCAT(u.first_name,' ',IFNULL(u.last_name,'')) fullname
								,u.iduser_ppk
								FROM auth_users u
								LEFT JOIN auth_users_groups ug ON ug.user_id=u.id
								LEFT JOIN auth_groups g ON g.id=ug.group_id
								LEFT JOIN ms_lokasi_tvri h ON h.idlokasi=u.idlokasi
								GROUP BY u.id
								) rpt WHERE 1=1";
		$g->table = "auth_users";
		
		$col = array();
		$col["title"] = "ID";
		$col["name"] = "id";
		$col["hidden"] = true;
		$col["search"] = true;
		$col["editable"] = true;
		$col["isnull"] = true;	
		$col["autoid"] = false;	
		$col["align"] = "center";
		$col["width"] = "120";
		// $col["show"] = array("list"=>false,"edit"=>false,"add"=>true,"view"=>false);
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "USERNAME";
		$col["name"] = "username";
		$col["editoptions"] = array("maxlength" => "64");
		$col["search"] = true;
		$col["editable"] = true;
		$col["align"] = "left";
		$col["width"] = "200";
		$col["show"] = array("add"=>false,"edit"=>true,"view"=>true);
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "NAMA LENGKAP";
		$col["name"] = "fullname";
		$col["search"] = true;
		$col["editable"] = false;
		$col["width"] = "150";
		$col["show"] = array("add"=>false,"edit"=>false,"list"=>true,"view"=>false);
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "NAMA<br/>DEPAN";
		$col["name"] = "first_name";
		$col["editoptions"] = array("maxlength" => "50");
		$col["align"] = "left";
		$col["search"] = true;
		$col["editable"] = true;
		$col["width"] = "150";
		$col["show"] = array("add"=>false,"edit"=>true,"list"=>false,"view"=>false);
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "NAMA<br/>BELAKANG";
		$col["name"] = "last_name";
		$col["editoptions"] = array("maxlength" => "50");
		$col["align"] = "left";
		$col["search"] = true;
		$col["editable"] = true;
		$col["width"] = "150";
		$col["show"] = array("add"=>false,"edit"=>true,"list"=>false,"view"=>false);
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "PASSWORD";
		$col["name"] = "password";
		$col["formatter"] = "password";
		$col["edittype"] = "password";
		$col["editoptions"] = array("maxlength" => "255");
		$col["search"] = true;
		$col["editable"] = true;
		$col["width"] = "150";
		$col["show"] = array("add"=>false,"edit"=>false,"list"=>false);
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "EMAIL";
		$col["name"] = "email";
		$col["editoptions"] = array("maxlength" => "100");
		$col["editrules"] = array("email" => true);
		$col["align"] = "left";
		$col["search"] = true;
		$col["editable"] = true;
		$col["width"] = "250";
		$col["show"] = array("add"=>false,"edit"=>false,"view"=>false);
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "HP";
		$col["name"] = "phone";
		$col["editoptions"] = array("maxlength" => "100");
		//$col["editrules"] = array("email" => true);
		$col["align"] = "left";
		$col["search"] = true;
		$col["editable"] = true;
		$col["width"] = "250";
		$col["show"] = array("add"=>false,"edit"=>true,"view"=>true);
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "IP ADDRESS";
		$col["name"] = "ip_address";
		$col["editoptions"] = array("maxlength" => "45");
		$col["search"] = true;
		$col["editable"] = true;
		$col["align"] = "center";
		$col["width"] = "150";
		$col["show"] = array("add"=>false,"edit"=>false,"view"=>true,"list"=>false);
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Kantor";
		$col["name"] = "idlokasi";
		$col["editable"] = true;
		$col["edittype"] = "select";
		$col["stype"] = "select";		
		$col["formatter"] = "select";
		$str = $g->get_dropdown_values("SELECT DISTINCT idlokasi AS k, nama_lokasi AS v FROM ms_lokasi_tvri ORDER BY 2");
		$col["editoptions"] = array("value" => $str);
		$col["searchoptions"] = array("value" => ":;".$str);
		$col["export"] = false;	
		$col["width"] = "250";
		$cols[] = $col;
		
		/*$col = array();
		$col["title"] = "Kantor";
		$col["name"] = "nama_lokasi";
		$col["editoptions"] = array("maxlength" => "100");
		$col["search"] = true;
		$col["editable"] = true;
		$col["width"] = "250";
		$col["show"] = array("add"=>false,"edit"=>true,"view"=>false);
		$cols[] = $col;*/
		
			
		$col = array();
		$col["title"] = "GRUP<br/>PENGGUNA";
		$col["name"] = "role";
		// $col["dbname"] = "GROUP_CONCAT(g.name)";
		$col["editoptions"] = array("maxlength" => "50");
		$col["search"] = true;
		$col["editable"] = false;
		$col["width"] = "130";
		$col["edittype"] = "select";
		$str = $g->get_dropdown_values("SELECT DISTINCT id AS k, NAME AS v  FROM auth_groups WHERE id<>0 ORDER BY NAME");
		$col["editoptions"] = array("value" =>$str, "separator" => ":", "delimiter" => ";", "multiple" => true);
		$col["show"] = array("add"=>false,"edit"=>false,"view"=>false);
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "AKTIF";
		$col["name"] = "active";
		$col["name"] = "active";
		$col["width"] = "80";
		$col["search"] = false;
		$col["editable"] = true;
		$col["align"] = "center";
		$col["editrules"] = array("required"=>false); 
		$col["edittype"] = "checkbox"; 
		$col["formatter"] = "checkbox";
		$col["editoptions"] = array("maxlength"=>150,"size"=>75,"value"=>"1:0","defaultValue"=>'1');
		$col["show"] = array("add"=>false,"edit"=>true,"view"=>false);
		$cols[] = $col;
	
		$col = array();
		$col["title"] = "";
		$col["name"] = "";
		$col["width"] = "35";
		$col["search"] = false;
		$col["editable"] = false;
		$col["export"] = false;
		$col["align"] = "center";
		$str1  = "<a href='".base_url()."auth/edit_user/{id}' target='_blank' class='ui-custom-icon ui-icon ui-icon-user'>test</a>"; 
		$col["default"] = $str1;
		$col["show"] = array("list"=>true,"edit"=>false,"add"=>false,"view"=>false);
		$col["export"] = false;
		$cols[] = $col;
	
		$g->set_columns($cols);
		$g->set_options($grid);

		$head['title'] = $caps;
		$data['gridout'] = $g->render("list1");
		$this->load->model('Global_model');
		$data['breadcrumbs'] = $this->Global_model->create_breadcrumbs(["Management Akun","Akun Pengguna"]);
		$this->load->view('layout/header',$head);
		$this->load->view('layout/sidebar');
		$this->load->view('grid_pengguna',$data);
		$this->load->view('layout/footer');
	}
	
	public function groups()
	{
		if(in_array(8,$this->session->userdata('priv')) == FALSE) return redirect('404_override');
		$this->load->library('gridlibrary');
		$g = new jqgrid($this->db_conf);
		$caps = "Data Group";
		
		$grid["caption"] = $caps;
		$grid["rowNum"] = 20; 
		$grid["rowList"] = array(20,40,100,'All');
		$grid["rownumbers"] = true;
		$grid["sortname"] = 'id'; 
		$grid["autowidth"] = true;
		$grid["shrinkToFit"] = false;
		$grid["forceFit"] = false;
		$grid["resizable"] = true;
		$grid["autoresize"] = false;
		$grid["multiselect"] = false; 
		$grid["rowactions"] = true; 
		$grid["toolbar"] = "buttom"; 
		$grid["add_options"] = array("width"=>"460");
		$grid["edit_options"] = array("width"=>"460");
		$grid["view_options"] = array("width"=>"460");
		$grid["export"] = array("format"=>"xls", "filename"=>$this->file_name, "sheetname"=>"master");
		
		$g->set_actions(array(
				"add"=>true,
				"edit"=>true,
				"delete"=>false,
				"rowactions"=>false,
				"export"=>false,
				"autofilter" => true,
				"search" => false
			)
		);
		
		$g->select_command = "SELECT id, name, description
								FROM auth_groups";
		$g->table = "auth_groups";
		
		$col = array();
		$col["title"] = "ID";
		$col["name"] = "id";
		$col["hidden"] = true;
		$col["editable"] = true;
		$col["isnull"] = true;	
		$col["autoid"] = false;	
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Nama Group";
		$col["name"] = "name";
		$col["editoptions"] = array("maxlength" => "20","size"=>30);
		$col["editrules"] = array("required" => true);
		$col["search"] = true;
		$col["editable"] = true;
		$col["align"] = "left";
		$col["width"] = "200";
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Keterangan";
		$col["name"] = "description";
		$col["editoptions"] = array("maxlength" => "100","size"=>45);
		$col["editrules"] = array("required" => true);
		$col["search"] = true;
		$col["editable"] = true;
		$col["align"] = "left";
		$col["width"] = "200";
		$cols[] = $col;
		
		$g->set_columns($cols);
		$g->set_options($grid);

		$head['title'] = $caps;
		$data['gridout'] = $g->render("list1");
		$this->load->view('layout/header',$head);
		$this->load->view('layout/sidebar');
		$this->load->view('grid_master',$data);
		$this->load->view('layout/footer');
	}
	
	/**
	 * Log the user in
	 */
	public function login()
	{
		$this->data['title'] = $this->lang->line('login_heading');

		// validate form input
		$this->form_validation->set_rules('identity', str_replace(':', '', $this->lang->line('login_identity_label')), 'required');
		$this->form_validation->set_rules('password', str_replace(':', '', $this->lang->line('login_password_label')), 'required');

		if ($this->form_validation->run() === TRUE)
		{
			// check to see if the user is logging in
			// check for "remember me"
			$remember = (bool)$this->input->post('remember');
			// echo json_encode($remember); die;
			if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember))
			{
				//if the login is successful, redirect them back to the home page
				
				/*log: login success*/
				helper_log($this->input->post('identity'), "Login", "Login sukses");
				
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect('/auth', 'refresh');
			}
			else
			{
				
				helper_log($this->input->post('identity'), "Login", "Login Gagal!");
				
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect('auth/login', 'refresh');
				
			}
		}
		else
		{
			// the user is not logging in so display the login page
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			//list of additional data
			$this->head['title'] = "Login";

			$this->data['identity'] = array(
				'name' => 'identity',
				'id' => 'identity',
				'type' => 'text',
				'class' => 'form-control h-auto text-white placeholder-white opacity-70 bg-dark-o-70 rounded-pill border-0 py-4 px-8 mb-5',
				'placeholder' => 'Email/Username',
				'required'=>'required',
				'value' => $this->form_validation->set_value('identity'),
			);
			$this->data['password'] = array(
				'name' => 'password',
				'id' => 'password',
				'type' => 'password',
				'class' => 'form-control h-auto text-white placeholder-white opacity-70 bg-dark-o-70 rounded-pill border-0 py-4 px-8 mb-5',
				'required'=>'required',
				'placeholder' => 'Password'
				
			);
			/** old
			$this->_render_page( 'auth_head', $this->head);
			$this->_render_page( 'login', $this->data);
			$this->_render_page( 'auth_footer');
			*/
			// new
			$this->_render_page( 'auth_metronic', $this->data);
			
		}
	}

	/**
	 * Log the user out
	 */
	public function logout()
	{
		$this->data['title'] = "Logout";

		/*log: logout
		$logdata = array('ip_address' => '', 'log_user' => '', 'log_tipe' => 'Logout', 'log_aksi' => '');
		$users = $this->ion_auth->user($this->session->userdata('user_id'))->row();
		$logout = $this->ion_auth->logout();
		$logdata['log_aksi'] = ($logout)?'Logout Berhasil':'Logout Gagal';
		if($users){
			$logdata['log_user'] = $users->id;
			$logdata['ip_address'] = $users->ip_address;
		}
		$this->db->insert('app_log', $logdata);
		*/

		// redirect them to the login page
		$logout = $this->ion_auth->logout();
		$this->session->set_flashdata('message', $this->ion_auth->messages());
		redirect('auth/login', 'refresh');
	}

	/**
	 * Change password
	 */
	public function change_password()
	{
		$this->data['title'] = $this->lang->line('change_password_heading');
		$this->form_validation->set_rules('old', $this->lang->line('change_password_validation_old_password_label'), 'required');
		$this->form_validation->set_rules('new', $this->lang->line('change_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
		$this->form_validation->set_rules('new_confirm', $this->lang->line('change_password_validation_new_password_confirm_label'), 'required');

		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login', 'refresh');
		}

		$user = $this->ion_auth->user()->row();

		if ($this->form_validation->run() === FALSE)
		{
			// display the form
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
			$this->data['old_password'] = array(
				'name' => 'old',
				'id' => 'old',
				'type' => 'password',
				'class' => 'form-control',
			);
			$this->data['new_password'] = array(
				'name' => 'new',
				'id' => 'new',
				'type' => 'password',
				'class' => 'form-control',
				'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
			);
			$this->data['new_password_confirm'] = array(
				'name' => 'new_confirm',
				'id' => 'new_confirm',
				'type' => 'password',
				'class' => 'form-control',
				'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
			);
			$this->data['user_id'] = array(
				'name' => 'user_id',
				'id' => 'user_id',
				'type' => 'hidden',
				'value' => $user->id,
			);

	    // set any errors and display the form
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			
			//list of additional data
			//header
			$head['title'] = $this->data['title'];
			$head['collapse'] = true; 
			
			// render
			$this->load->view('layout/header',$head);
			$this->load->view('layout/sidebar');
			$this->_render_page( 'change_password', $this->data);
			$this->load->view('layout/footer');;
		}
		else
		{
			$identity = $this->session->userdata('identity');

			$change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));

			if ($change)
			{
				//if the password was successfully changed
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				$this->logout();
			}
			else
			{
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect('auth/change_password', 'refresh');
			}
		}
	}

	/**
	 * Forgot password
	 */
	public function forgot_password()
	{
		$this->data['title'] = $this->lang->line('forgot_password_heading');
		// setting validation rules by checking whether identity is username or email
		if ($this->config->item('identity', 'ion_auth') != 'email')
		{
			$this->form_validation->set_rules('identity', $this->lang->line('forgot_password_identity_label'), 'required');
		}
		else
		{
			$this->form_validation->set_rules('identity', $this->lang->line('forgot_password_validation_email_label'), 'required|valid_email');
		}


		if ($this->form_validation->run() === FALSE)
		{
			$this->data['type'] = $this->config->item('identity', 'ion_auth');

			// setup the input
			$this->data['identity'] = array('name' => 'identity',
				'id' => 'identity',
				'class' => 'form-control',
				'placeholder' => 'Email/Username',
			);

			if ($this->config->item('identity', 'ion_auth') != 'email')
			{
				$this->data['identity_label'] = $this->lang->line('forgot_password_identity_label');
			}
			else
			{
				$this->data['identity_label'] = $this->lang->line('forgot_password_email_identity_label');
			}

			// set any errors and display the form
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			//list of additional data
			//header
			$head['title'] = $this->data['title'];
			
			//revisi
			$this->_render_page( 'auth_head', $this->data);
			$this->_render_page( 'forgot_password', $this->data);
			$this->_render_page( 'auth_footer');
		}
		else
		{
			$identity_column = $this->config->item('identity', 'ion_auth');
			$identity = $this->ion_auth->where($identity_column, $this->input->post('identity'))->users()->row();

			if (empty($identity))
			{

				if ($this->config->item('identity', 'ion_auth') != 'email')
				{
					$this->ion_auth->set_error('forgot_password_identity_not_found');
				}
				else
				{
					$this->ion_auth->set_error('forgot_password_email_not_found');
				}

				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect("auth/forgot_password", 'refresh');
			}

			// run the forgotten password method to email an activation code to the user
			$forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});

			if ($forgotten)
			{
				// if there were no errors
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect("auth/login", 'refresh'); //we should display a confirmation page here instead of the login page
			}
			else
			{
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect("auth/forgot_password", 'refresh');
			}
		}
	}

	/**
	 * Reset password - final step for forgotten password
	 *
	 * @param string|null $code The reset code
	 */
	public function reset_password($code = NULL)
	{
		if (!$code)
		{
			show_404();
		}

		$user = $this->ion_auth->forgotten_password_check($code);

		if ($user)
		{
			$this->data['title'] = $this->lang->line('reset_password_heading');
			// if the code is valid then display the password reset form

			$this->form_validation->set_rules('new', $this->lang->line('reset_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
			$this->form_validation->set_rules('new_confirm', $this->lang->line('reset_password_validation_new_password_confirm_label'), 'required');

			if ($this->form_validation->run() === FALSE)
			{
				// display the form

				// set the flash data error message if there is one
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

				$this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
				$this->data['new_password'] = array(
					'name' => 'new',
					'id' => 'new',
					'type' => 'password',
					'class' => 'form-control',
					'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
				);
				$this->data['new_password_confirm'] = array(
					'name' => 'new_confirm',
					'id' => 'new_confirm',
					'type' => 'password',
					'class' => 'form-control',
					'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
				);
				$this->data['user_id'] = array(
					'name' => 'user_id',
					'id' => 'user_id',
					'type' => 'hidden',
					'value' => $user->id,
				);
				$this->data['csrf'] = $this->_get_csrf_nonce();
				$this->data['code'] = $code;

				// render
				// $this->_render_page( 'reset_password', $this->data);
				
				//revisi
				$this->_render_page( 'auth_head', $this->data);
				$this->_render_page( 'reset_password', $this->data);
				$this->_render_page( 'auth_footer');
			}
			else
			{
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $user->id != $this->input->post('user_id'))
				{

					// something fishy might be up
					$this->ion_auth->clear_forgotten_password_code($code);

					show_error($this->lang->line('error_csrf'));

				}
				else
				{
					// finally change the password
					$identity = $user->{$this->config->item('identity', 'ion_auth')};

					$change = $this->ion_auth->reset_password($identity, $this->input->post('new'));

					if ($change)
					{
						// if the password was successfully changed
						$this->session->set_flashdata('message', $this->ion_auth->messages());
						redirect("auth/login", 'refresh');
					}
					else
					{
						$this->session->set_flashdata('message', $this->ion_auth->errors());
						redirect('auth/reset_password/' . $code, 'refresh');
					}
				}
			}
		}
		else
		{
			// if the code is invalid then send them back to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect("auth/forgot_password", 'refresh');
		}
	}

	/**
	 * Activate the user
	 *
	 * @param int         $id   The user ID
	 * @param string|bool $code The activation code
	 */
	public function activate($id, $code = FALSE)
	{
		if ($code !== FALSE)
		{
			$activation = $this->ion_auth->activate($id, $code);
		}
		else if ($this->ion_auth->is_admin())
		{
			$activation = $this->ion_auth->activate($id);
		}

		if ($activation)
		{
			// redirect them to the auth page
			$this->session->set_flashdata('message', $this->ion_auth->messages());
			redirect("auth", 'refresh');
		}
		else
		{
			// redirect them to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect("auth/forgot_password", 'refresh');
		}
	}

	/**
	 * Deactivate the user
	 *
	 * @param int|string|null $id The user ID
	 */
	public function deactivate($id = NULL)
	{
		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}

		$id = (int)$id;

		$this->load->library('form_validation');
		$this->form_validation->set_rules('confirm', $this->lang->line('deactivate_validation_confirm_label'), 'required');
		$this->form_validation->set_rules('id', $this->lang->line('deactivate_validation_user_id_label'), 'required|alpha_numeric');

		if ($this->form_validation->run() === FALSE)
		{
			$this->data['title'] = $this->lang->line('deactivate_heading');
			// insert csrf check
			$this->data['csrf'] = $this->_get_csrf_nonce();
			$this->data['user'] = $this->ion_auth->user($id)->row();

			//list of additional data
			//header
			$head['title'] = $this->data['title'];
			
			// render
			$this->load->view('layout/header',$head);
			$this->load->view('layout/sidebar');
			$this->_render_page( 'deactivate_user', $this->data);
			$this->load->view('layout/footer');

			// $this->_render_page( 'auth_head', $this->head);
			// $this->_render_page( 'deactivate_user', $this->data);
			// $this->_render_page( 'auth_footer');
		}
		else
		{
			// do we really want to deactivate?
			if ($this->input->post('confirm') == 'yes')
			{
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
				{
					return show_error($this->lang->line('error_csrf'));
				}

				// do we have the right userlevel?
				if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
				{
					$this->ion_auth->deactivate($id);
				}
			}

			// redirect them back to the auth page
			redirect('auth', 'refresh');
		}
	}

	/**
	 * Create a new user
	 */
	public function create_user()
	{
		$this->data['title'] = $this->lang->line('create_user_heading');
		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			redirect('auth', 'refresh');
		}
		$tables = $this->config->item('tables', 'ion_auth');
		$identity_column = $this->config->item('identity', 'ion_auth');
		$this->data['identity_column'] = $identity_column;
		$groups = $this->ion_auth->groups()->result_array();
		
		// validate form input
		$this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'trim|required');
		$this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'trim|required');
		if ($identity_column !== 'email')
		{
			$this->form_validation->set_rules('identity', $this->lang->line('create_user_validation_identity_label'), 'trim|required|is_unique[' . $tables['users'] . '.' . $identity_column . ']');
			#$this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'trim|required|valid_email');
		}
		else
		{
			$this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'trim|required|valid_email|is_unique[' . $tables['users'] . '.email]');
		}
		
		$this->form_validation->set_rules('phone', $this->lang->line('create_user_validation_phone_label'), 'trim');
		$this->form_validation->set_rules('company', $this->lang->line('create_user_validation_company_label'), 'trim');
		$this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
		$this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');
		$this->form_validation->set_rules('phone', $this->lang->line('create_user_validation_phone_label'), 'required');
		if ($this->form_validation->run() === TRUE)
		{
			$email = strtolower($this->input->post('email'));
			$identity = ($identity_column === 'email') ? $email : $this->input->post('identity');
			$password = $this->input->post('password');
			$groupData = $this->input->post('groups');
			
			$additional_data = array(
				'first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
				'company' => $this->input->post('idlokasi'),
				'idlokasi' => $this->input->post('idlokasi'),
				'phone' => $this->input->post('phone'),
			);
		}
		if ($this->form_validation->run() === TRUE && $this->ion_auth->register($identity, $password, $email, $additional_data, $groupData))
		{
			// check to see if we are creating the user
			// redirect them back to the admin page
			$this->session->set_flashdata('message', $this->ion_auth->messages());
			redirect("auth/users", 'refresh');
		}
		else
		{
			// display the create user form
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

			//list of additional data
			$this->head['title'] = $this->data['title'];
			
			$this->data['first_name'] = array(
				'name'  => 'first_name',
				'id'    => 'first_name',
				'type'  => 'text',
				'class' => 'form-control col-sm-10',
				'style' => 'margin-left: 1rem;margin-right: 1rem;',
				'value' => $this->form_validation->set_value('first_name'),
			);
			$this->data['last_name'] = array(
				'name' => 'last_name',
				'id' => 'last_name',
				'type' => 'text',
				'class' => 'form-control col-sm-10',
				'style' => 'margin-left: 1rem;margin-right: 1rem;',
				'value' => $this->form_validation->set_value('last_name'),
			);
			$this->data['identity'] = array(
				'name' => 'identity',
				'id' => 'identity',
				'type' => 'text',
				'placeholder' => 'Username',
				'class' => 'form-control col-sm-10',
				'style' => 'margin-left: 1rem;margin-right: 1rem;',
				'value' => $this->form_validation->set_value('identity'),
			);
			$this->data['email'] = array(
				'name' => 'email',
				'id' => 'email',
				'type' => 'text',
				'class' => 'form-control col-sm-10',
				'style' => 'margin-left: 1rem;margin-right: 1rem;',
				'value' => $this->form_validation->set_value('email'),
			);
			$this->data['company'] = array(
				'name' => 'company',
				'id' => 'company',
				'type' => 'text',
				'placeholder' => '',
				'class' => 'form-control col-sm-10',
				'style' => 'margin-left: 1rem;margin-right: 1rem;',
				'value' => $this->form_validation->set_value('company'),
			);
			$this->data["listKantor"] = $this->ion_auth->kantorlist();
			$this->data["idlokasi"] = $this->form_validation->set_value('idlokasi');
			 $this->data['phone'] = array(
			 'name' => 'phone',
			 'id' => 'phone',
			 'type' => 'text',
			 'placeholder' => 'No. telp',
			 'class' => 'form-control col-sm-8',
			 'value' => $this->form_validation->set_value('phone'),
			 );
			$this->data['password'] = array(
				'name' => 'password',
				'id' => 'password',
				'type' => 'password',
				'placeholder' => 'Password Min 8 karakter',
				'class' => 'form-control col-sm-10',
				'style' => 'margin-left: 1rem;margin-right: 1rem;',
				'value' => $this->form_validation->set_value('password'),
			);
			$this->data['password_confirm'] = array(
				'name' => 'password_confirm',
				'id' => 'password_confirm',
				'type' => 'password',
				'class' => 'form-control col-sm-10',
				'style' => 'margin-left: 1rem;margin-right: 1rem;',
				'value' => $this->form_validation->set_value('password_confirm'),
			);
			
			$head["title"]=$this->data['title'];
			$this->load->model('Global_model');
			$this->data['breadcrumbs'] = $this->Global_model->create_breadcrumbs(["Akun","Pengguna"]);
			$this->data["groups"] = $groups;
			$this->load->view('layout/header',$head);
			$this->load->view('layout/sidebar');
			$this->_render_page( 'create_user', $this->data);
			$this->load->view('layout/footer');
		}
	}
	
	/**
	* Redirect a user checking if is admin
	*/
	public function redirectUser(){
		if ($this->ion_auth->is_admin()){
			redirect('auth', 'refresh');
		}
		redirect('/', 'refresh');
	}

	/**
	 * Edit a user
	 *
	 * @param int|string $id
	 */
	public function edit_user($id)
	{
		$this->data['title'] = $this->lang->line('edit_user_heading');
//$this->data["listKantor"] = $this->ion_auth->kantorlist();
		if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !($this->ion_auth->user()->row()->id == $id)))
		{
			redirect('auth', 'refresh');
		}

		$user = $this->ion_auth->user($id)->row();
		$groups = $this->ion_auth->groups()->result_array();
		$currentGroups = $this->ion_auth->get_users_groups($id)->result();

		// validate form input
		$this->form_validation->set_rules('first_name', $this->lang->line('edit_user_validation_fname_label'), 'trim|required');
		$this->form_validation->set_rules('last_name', $this->lang->line('edit_user_validation_lname_label'), 'trim|required');
		// $this->form_validation->set_rules('phone', $this->lang->line('edit_user_validation_phone_label'), 'trim|required');
		//$this->form_validation->set_rules('company', $this->lang->line('edit_user_validation_company_label'), 'trim|required');

		if (isset($_POST) && !empty($_POST))
		{
			// do we have a valid request?
			/*
			if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
			{
				// show_error('error_csrf');
				show_error($this->lang->line('error_csrf'));
			}
			*/

			// update the password if it was posted
			if ($this->input->post('password'))
			{
				$this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
				$this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');
			}
			$this->data["listKantor"] = $this->ion_auth->kantorlist();
			if ($this->form_validation->run() === TRUE)
			{
				$data = array(
					'first_name' => $this->input->post('first_name'),
					'last_name' => $this->input->post('last_name'),
					//'company' => $this->input->post('idlokasi'),
					//'idlokasi' => $this->input->post('idlokasi'),					
					'phone' => $this->input->post('phone'),
				);

				// update the password if it was posted
				if ($this->input->post('password'))
				{
					$data['password'] = $this->input->post('password');
				}

				// Only allow updating groups if user is admin
				if ($this->ion_auth->is_admin())
				{
					// Update the groups user belongs to
					$groupData = $this->input->post('groups');

					if (isset($groupData) && !empty($groupData))
					{

						$this->ion_auth->remove_from_group('', $id);

						foreach ($groupData as $grp)
						{
							$this->ion_auth->add_to_group($grp, $id);
						}

					}
				}

				// check to see if we are updating the user
				if ($this->ion_auth->update($user->id, $data))
				{
					// redirect them back to the admin page if admin, or to the base url if non admin
					$this->session->set_flashdata('message', $this->ion_auth->messages());
					$this->redirectUser();

				}
				else
				{
					// redirect them back to the admin page if admin, or to the base url if non admin
					$this->session->set_flashdata('message', $this->ion_auth->errors());
					$this->redirectUser();

				}

			}
		}

		// display the edit user form
		$this->data['csrf'] = $this->_get_csrf_nonce();

		// set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

		// pass the user to the view
		$this->data['user'] = $user;
		$this->data['groups'] = $groups;
		$this->data['currentGroups'] = $currentGroups;

		$this->data['first_name'] = array(
			'name'  => 'first_name',
			'id'    => 'first_name',
			'type'  => 'text',
			'class' => 'form-control col-sm-10',
			'placeholder' => 'Nama depan',
			'style' => 'margin-left: 1rem;margin-right: 1rem;',
			'value' => $this->form_validation->set_value('first_name', $user->first_name),
		);
		$this->data['last_name'] = array(
			'name'  => 'last_name',
			'id'    => 'last_name',
			'type'  => 'text',
			'placeholder' => 'Nama belakang',
			'class' => 'form-control col-sm-10',
			'style' => 'margin-left: 1rem;margin-right: 1rem;',
			'value' => $this->form_validation->set_value('last_name', $user->last_name),
		);
		$this->data['company'] = array(
			'name'  => 'company',
			'id'    => 'company',
			'type'  => 'text',
			'placeholder' => '',
			'class' => 'form-control col-sm-10',
			'style' => 'margin-left: 1rem;margin-right: 1rem;',
			'value' => $this->form_validation->set_value('company', $user->company),
		);
		// $this->data['phone'] = array(
			// 'name'  => 'phone',
			// 'id'    => 'phone',
			// 'type'  => 'text',
			// 'placeholder' => 'No. telp',
			// 'class' => 'form-control col-sm-8',
			// 'value' => $this->form_validation->set_value('phone', $user->phone),
		// );
		$this->data['password'] = array(
			'name' => 'password',
			'id'   => 'password',
			'type' => 'password',
			'placeholder' => 'Password',
			'class' => 'form-control col-sm-10',
			'style' => 'margin-left: 1rem;margin-right: 1rem;',
		);
		$this->data['password_confirm'] = array(
			'name' => 'password_confirm',
			'id'   => 'password_confirm',
			'type' => 'password',
			'placeholder' => 'Ketikkan ulang password',
			'class' => 'form-control col-sm-10',
		'style' => 'margin-left: 1rem;margin-right: 1rem;',				
		);

		//list of additional data
		//header
		$head['title'] = $this->data['title'];
		$this->load->model('Global_model');
		$this->data['breadcrumbs'] = $this->Global_model->create_breadcrumbs(["Akun","Pengguna"]);
		
		// render
		$this->load->view('layout/header',$head);
		$this->load->view('layout/sidebar');
		$this->_render_page( 'edit_user', $this->data);
		$this->load->view('layout/footer');
	}

	/**
	 * Create a new group
	 */
	public function create_group()
	{
		$this->data['title'] = $this->lang->line('create_group_title');

		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			redirect('auth', 'refresh');
		}

		// validate form input
		$this->form_validation->set_rules('group_name', $this->lang->line('create_group_validation_name_label'), 'trim|required|alpha_dash');

		if ($this->form_validation->run() === TRUE)
		{
			$new_group_id = $this->ion_auth->create_group($this->input->post('group_name'), $this->input->post('description'));
			if ($new_group_id)
			{
				// check to see if we are creating the group
				// redirect them back to the admin page
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect("auth", 'refresh');
			}
		}
		else
		{
			// display the create group form
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

			//list of additional data
			$this->head['title'] = "Create Group";

			$this->data['group_name'] = array(
				'name'  => 'group_name',
				'id'    => 'group_name',
				'type'  => 'text',
				'class' => 'form-control',
				'value' => $this->form_validation->set_value('group_name'),
			);
			$this->data['description'] = array(
				'name'  => 'description',
				'id'    => 'description',
				'type'  => 'text',
				'class' => 'form-control',
				'value' => $this->form_validation->set_value('description'),
			);

			$this->_render_page( 'auth_head', $this->head);
			$this->_render_page( 'create_group', $this->data);
			$this->_render_page( 'auth_footer');
		}
	}

	/**
	 * Edit a group
	 *
	 * @param int|string $id
	 */
	public function edit_group($id)
	{
		// bail if no group id given
		if (!$id || empty($id))
		{
			redirect('auth', 'refresh');
		}

		$this->data['title'] = $this->lang->line('edit_group_title');

		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			redirect('auth', 'refresh');
		}

		$group = $this->ion_auth->group($id)->row();

		// validate form input
		$this->form_validation->set_rules('group_name', $this->lang->line('edit_group_validation_name_label'), 'required|alpha_dash');

		if (isset($_POST) && !empty($_POST))
		{
			if ($this->form_validation->run() === TRUE)
			{
				$group_update = $this->ion_auth->update_group($id, $_POST['group_name'], $_POST['group_description']);

				if ($group_update)
				{
					$this->session->set_flashdata('message', $this->lang->line('edit_group_saved'));
				}
				else
				{
					$this->session->set_flashdata('message', $this->ion_auth->errors());
				}
				redirect("auth", 'refresh');
			}
		}

		// set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

		//list of additional data
		$this->head['title'] = "Edit Group";

		// pass the user to the view
		$this->data['group'] = $group;

		$readonly = $this->config->item('admin_group', 'ion_auth') === $group->name ? 'readonly' : '';

		$this->data['group_name'] = array(
			'name'    => 'group_name',
			'id'      => 'group_name',
			'type'    => 'text',
			'class' => 'form-control',
			'value'   => $this->form_validation->set_value('group_name', $group->name),
			$readonly => $readonly,
		);
		$this->data['group_description'] = array(
			'name'  => 'group_description',
			'id'    => 'group_description',
			'type'  => 'text',
			'class' => 'form-control',
			'value' => $this->form_validation->set_value('group_description', $group->description),
		);
		
		$this->_render_page( 'auth_head', $this->head);
		$this->_render_page( 'edit_group', $this->data);
		$this->_render_page( 'auth_footer');
	}

	/**
	 * @return array A CSRF key-value pair
	 */
	public function _get_csrf_nonce()
	{
		$this->load->helper('string');
		$key = random_string('alnum', 8);
		$value = random_string('alnum', 20);
		$this->session->set_flashdata('csrfkey', $key);
		$this->session->set_flashdata('csrfvalue', $value);

		return array($key => $value);
	}

	/**
	 * @return bool Whether the posted CSRF token matches
	 */
	public function _valid_csrf_nonce(){
		$csrfkey = $this->input->post($this->session->flashdata('csrfkey'));
		if ($csrfkey && $csrfkey === $this->session->flashdata('csrfvalue')){
			return TRUE;
		}
			return FALSE;
	}

	/**
	 * @param string     $view
	 * @param array|null $data
	 * @param bool       $returnhtml
	 *
	 * @return mixed
	 */
	public function _render_page($view, $data = NULL, $returnhtml = FALSE)//I think this makes more sense
	{

		$this->viewdata = (empty($data)) ? $this->data : $data;

		$view_html = $this->load->view($view, $this->viewdata, $returnhtml);

		// This will return html on 3rd argument being true
		if ($returnhtml)
		{
			return $view_html;
		}
	}
	
	//group_menu
	public function group_menu()
	{		
		error_reporting(E_ALL);
		ini_set('display_errors', 1);
		$this->load->library('gridlibrary');
		global $g;
		$g = new jqgrid($this->db_conf);
		$caps = "Data Group";
		
		$grid["caption"] = $caps;
		$grid["rowNum"] = 20; 
		$grid["rowList"] = array(20,40,100,'All');
		$grid["rownumbers"] = true;
		$grid["sortname"] = 'id'; 
		$grid["autowidth"] = true;
		$grid["shrinkToFit"] = false;
		$grid["forceFit"] = false;
		$grid["resizable"] = true;
		$grid["autoresize"] = false;
		$grid["multiselect"] = false; 
		$grid["rowactions"] = true; 
		$grid["toolbar"] = "buttom"; 
		$grid["height"] = "170"; 
		$grid["add_options"] = array("width"=>"460");
		$grid["edit_options"] = array("width"=>"460");
		$grid["view_options"] = array("width"=>"460");
		$grid["export"] = array("format"=>"xls", "filename"=>$this->file_name, "sheetname"=>"master");
		
		$grid["detail_grid_id"] = "list2"; 

		$grid["onSelectRow"] = "function(id){ 
				var nm = $('#list1').jqGrid('getCell', id, 'name');
				$('#list2').jqGrid('setCaption','Group Menu : '+nm); 
			}";
		// refresh detail grid on master edit 
		$grid["edit_options"]["afterSubmit"] = "function(){ jQuery('#list2').trigger('reloadGrid', [{current:true}]); return [true,'']; jQuery('#list1').setSelection(jQuery('#list1').jqGrid('getGridParam','selrow')); }"; 
		$grid["add_options"]["afterComplete"] = "function (response, postdata) { r = JSON.parse(response.responseText); $('#list1').setSelection(r.id); }"; 
		
		$grid["subgridparams"] = "id,name"; 
		$grid["multiselect"] = false; 
		
		$g->set_actions(array(
				"add"=>true,
				"edit"=>true,
				"delete"=>false,
				"rowactions"=>false,
				"export"=>false,
				"autofilter" => true,
				"search" => false
			)
		);
		
		$g->select_command = "SELECT id, name, description
								FROM auth_groups";
		$g->table = "auth_groups";
				
		$col = array();
		$col["title"] = "ID";
		$col["name"] = "id";
		$col["hidden"] = true;
		$col["editable"] = true;
		$col["isnull"] = true;	
		$col["autoid"] = false;	
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Nama Group";
		$col["name"] = "name";
		$col["editoptions"] = array("maxlength" => "20","size"=>30);
		$col["editrules"] = array("required" => true);
		$col["search"] = true;
		$col["editable"] = true;
		$col["align"] = "left";
		$col["width"] = "200";
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Keterangan";
		$col["name"] = "description";
		$col["editoptions"] = array("maxlength" => "100","size"=>45);
		$col["editrules"] = array("required" => true);
		$col["search"] = true;
		$col["editable"] = true;
		$col["align"] = "left";
		$col["width"] = "400";
		$cols[] = $col;
		
		$g->set_columns($cols);
		$g->set_options($grid);
		
		{
			// menu grup
			$this->load->library('gridlibrary');
			$g2 = new jqgrid($this->db_conf);
			
			
			$id = intval($_GET["rowid"]); 
			$dcaps = "Group Menu :";
			
			$opt["caption"] = $dcaps;
			$opt["rowNum"] = 20; 
			$opt["rowList"] = array(20,40,100,'All');
			$opt["rownumbers"] = true;
			$opt["sortname"] = 'idmenu'; 
			$opt["autowidth"] = true;
			$opt["shrinkToFit"] = true;
			$opt["forceFit"] = false;
			$opt["resizable"] = true;
			$opt["autoresize"] = false;
			$opt["multiselect"] = false; 
			$opt["rowactions"] = true; 
			$opt["toolbar"] = "buttom"; 
			$opt["height"] = ""; 
			$opt["add_options"] = array("width"=>"460");
			$opt["edit_options"] = array("width"=>"460");
			$opt["view_options"] = array("width"=>"460");
			$opt["export"] = array("format"=>"xls", "filename"=>$this->file_name, "sheetname"=>"master");
			
			// fill detail grid add dialog with master grid id 
			$opt["add_options"]["afterShowForm"] = 'function() { var selr = jQuery("#list1").jqGrid("getGridParam","selrow"); jQuery("#idkeu").val( selr ) }'; 

			// reload master after detail update 
			$opt["onAfterSave"] = "function(){ var selr = jQuery('#list1').jqGrid('getGridParam','selrow'); jQuery('#list1').trigger('reloadGrid',[{jqgrid_page:1}]); setTimeout( function(){jQuery('#list1').setSelection(selr,true);},500 ); }"; 
			$g2->set_options($opt); 

			// and use in sql for filteration 
			$g2->select_command = "SELECT a.idmenu,a.nama_menu,a.url_menu
										,CASE 
											WHEN (a.idmenu IN (SELECT b.idmenu FROM app_menu_priv b WHERE b.idgroup='".$id."')) 
											THEN 1 ELSE 0 END AS menu
										FROM app_menu a
										WHERE idmenu<23"; 
			$cols = null;

			$col = array(); 
			$col["title"] = "id";  
			$col["name"] = "idmenu"; 
			$col["editable"] = true;
			$col["hidden"] = true;
			$col["isnull"] = true;	
			$col["autoid"] = false;	
			$cols[] = $col;     

			$col = array(); 
			$col["title"] = "Menu";  
			$col["name"] = "nama_menu"; 
			$col["editable"] = true; 
			$col["editoptions"] = array("readonly"=>"readonly");
			$cols[] = $col; 

			$col = array(); 
			$col["title"] = "Menu URL";  
			$col["name"] = "url_menu"; 
			$col["editable"] = true; 
			$col["editoptions"] = array("readonly"=>"readonly");
			$cols[] = $col;   
			
			$col = array();
			$col["title"] = "Status";
			$col["name"] = "menu";
			$col["width"] = "80";
			$col["search"] = true;
			$col["editable"] = true;
			$col["align"] = "center";
			$col["editrules"] = array("required"=>false); 
			$col["edittype"] = "checkbox"; 
			$col["formatter"] = "checkbox";
			$col["editoptions"] = array("maxlength"=>150,"size"=>75,"value"=>"1:0","defaultValue"=>'1');
			$cols[] = $col;
			
			$g2->set_columns($cols); 
			$g2->set_actions(array(
					"add"=>false,
					"edit"=>true,
					"delete"=>false,
					"rowactions"=>false,
					"export"=>false,
					"autofilter" => true,
					"search" => false
				)
			);
			
			$e = null;
			$e["on_update"] = array("up_privilage", null, false); 
			$g2->set_events($e); 

			function up_privilage(&$data) 
			{ 
				global $g;
				$idgroup = intval($_GET["rowid"]); 
				$idmenu = $data["params"]["idmenu"];
				$menu = $data["params"]["menu"];
				
				if($menu==1){
					//create priv
					$str = "INSERT INTO app_menu_priv (idmenu,idgroup) VALUES ('".$idmenu."','".$idgroup."')";
				} else {
					//Delete priv
					$str = "DELETE FROM app_menu_priv WHERE idgroup='".$idgroup."' AND idmenu='".$idmenu."'";
				}
				$g->execute_query($str);
			} 
			
			$g2->table = "app_menu_priv"; 
			$data['griddetail'] = $g2->render("list2"); 
		}
		$data['gridout'] = $g->render("list1");
		$head['title'] = $caps;
		$head['collapse'] = true; 
		$this->load->model('Global_model');
		$data['breadcrumbs'] = $this->Global_model->create_breadcrumbs(["Management Akun","Grup Pengguna"]);
		
		$this->load->view('layout/header',$head);
		$this->load->view('layout/sidebar');
		$this->load->view('grid_master_detail',$data);
		$this->load->view('layout/footer');
	}

	public function test(){ 
		set_cookie(array(
				'name'   => 'apipcookie',
			'value'  => 'feyanh4@yahoo.com',
			'expire' => (60*60*24*365*2)
			    // 'name'   => $this->config->item('identity_cookie_name', 'ion_auth'),
			    // 'value'  => $user->{$this->identity_column},
			    // 'expire' => $expire
			));
	}

}
