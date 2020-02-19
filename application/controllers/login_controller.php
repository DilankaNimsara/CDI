<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class login_controller extends CI_Controller
{
	//----------------------------------------------------------------------Login page validation
	public function login_validation()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if ($this->form_validation->run()) {

			$username = $this->input->post('username');

			$password = md5($this->input->post('password'));
			$this->load->model('user_model');


			if ($this->user_model->can_login($username, $password)) {
				$session_data = array(
					'username' => $username,
					'password' => $password
				);
				$data['fetch_data'] = $this->user_model->userdetails();
				if ($data['fetch_data']->num_rows() > 0) {
					foreach ($data['fetch_data']->result() as $row) {
						if (($row->post) == 'qac_head') {
							$_SESSION['qac_head_email'] = $row->email;
						}
						if (($username == $row->username) && ($password = $row->password)) {
							if ($row->course_name) {
								$_SESSION['post'] = $row->post;
								$_SESSION['myemail'] = $row->email;
								$_SESSION['type'] = $row->type;
								$_SESSION['course_name'] = $row->course_name;
							} else {
								$_SESSION['type'] = $row->type;
								$_SESSION['post'] = $row->post;
								$_SESSION['myemail'] = $row->email;
								$_SESSION['course_name'] = '';
							}
						}
					}
				}

				$data['fetch_switch'] = $this->user_model->autobackupdata();
				foreach ($data['fetch_switch']->result() as $row) {
					if (($row->action) == 'true') {
						$_SESSION['action'] = $row->action;
					} else {
						$_SESSION['action'] = "";
					}
				}

				if ($_SESSION['action'] == 'true') {
					date_default_timezone_set("Asia/Colombo");
					$date = date("Y-m-d");
					$data['fetch_file'] = $this->user_model->backup_fetch1();
					foreach ($data["fetch_file"]->result() as $row) {
						$Date = $row->date;
						$backupdata = date('Y-m-d', strtotime($Date . ' + 30 days'));

						if ($backupdata >= $Date) {

							$this->load->helper('url');
							$this->load->helper('file');
							$this->load->helper('download');
							$this->load->library('zip');
							$this->load->dbutil();

							$db_format = array('format' => 'zip', 'filename' => 'mrdoc121.sql');
							$this->dbutil->backup($db_format);
//							$save='./backup/'.$dbname;

							$dbname = 'mrdoc-' . date('Y-m-d') . '.zip';

							$filename = 'mrdoc-' . date('Y-m-d') . '.zip';
							$path = 'uploads';
							$this->zip->read_dir($path);
							$this->zip->archive(FCPATH . '/backup/' . $filename);
							$this->zip->archive(FCPATH . '/backup/' . $dbname);

//							write_file($save,$backup);
							$this->load->model('user_model');
							$data = array(
								"date" => $date,
								"backup_name_file" => $filename
							);
							$this->user_model->buckup_insert($data, $date);
						}
					}
				}

				$this->session->set_userdata($session_data);
				redirect(base_url() . 'login_controller/enter');
				$this->session->set_userdata('username');
				$this->session->set_userdata($_SESSION['type']);
				$this->session->set_userdata('password');

			} else {
				$this->session->set_flashdata('error', 'Invalid Username or Password');
				redirect(base_url() . 'login_controller/login');
			}

		} else {

			$this->login();
		}
	}

	//----------------------------------------------------------------------Login page
	public function login()
	{
		$this->load->view('login');
	}

	//----------------------------------------------------------------------logged in after validating
	public function enter()
	{
		if ($this->session->userdata('username') != '') {
			redirect(base_url() . 'Home/index');
		} else {
			redirect(base_url() . 'login_controller/login');
		}
	}

	//----------------------------------------------------------------------logout
	public function logout()
	{
		$this->session->unset_userdata('username');
		session_destroy();
		redirect(base_url() . 'Home/index');
	}

	//----------------------------------------------------------------------user account validation
	public function user_Create_validation()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('post', 'Post', 'required');
		$this->form_validation->set_rules('type', 'Type', 'required');
		$this->form_validation->set_rules('course_name', 'course name', 'required');

		$hashPassword = $this->input->post("password");


		if ($this->form_validation->run()) {
			$this->load->model('user_model');
			$data = array(
				"username" => $this->input->post("username"),
				"password" => md5($hashPassword),
				"type" => $this->input->post("type"),
				"email" => $this->input->post("email"),
				"post" => $this->input->post("post"),
				"course_name" => $this->input->post("course_name")
			);
			$this->user_model->insert_data($data, $this->input->post("username"));

			$body = '<center>Your MrDoc account successfully created. </br> Click here to login "http://localhost/CDI/" <br/> 
			your password : <font color="blue">' . $this->input->post("password") . '</font> and username :<font color="blue">' . $this->input->post("username") . '</font> <br/> use this password for login. then you can change it.<br/>
			 <br/>
			 <br/>
			 <br/>
			 Thank you!<br/>
			 &copy; Copyright - MrDoc<br/>
			 2019
			 </center>';

			include './public/PHPMailer/PHPMailerAutoload.php';

			$mail = new PHPMailer();
			$mail->isSMTP();
			$mail->SMTPAuth = true;
			$mail->SMTPSecure = 'ssl';
			$mail->Host = 'smtp.gmail.com';
			$mail->Port = '465';
			$mail->isHTML();
			$mail->Username = 'mrdoc.dms@gmail.com';
			$mail->Password = 'mrdoc100100100';
			$mail->setFrom('noreply@example.com');

			$mail->Subject = 'MrDoc signed up';
			$mail->Body = $body;
			$mail->AddAddress($this->input->post("email"));
			if ($this->session->flashdata("check") == 'check') {
				$mail->Send();
			}

			redirect(base_url() . "login_controller/userForm");

		} else {
			$this->userForm();
		}
	}

	//----------------------------------------------------------------------account create page
	public function userForm()
	{
		$this->load->view('userform');
	}

	//----------------------------------------------------------------------manage account page
	public function manageAccount()
	{
		$this->load->model('user_model');
		$data["fetch_data"] = $this->user_model->fetch_accounts();
		$this->load->view('manageaccount', $data);
	}

	//----------------------------------------------------------------------update accounts page
	public function update_users()
	{
		$username = $this->uri->segment(3);
		$this->load->model('user_model');
		$data['user_data'] = $this->user_model->fetch_single_data($username);
		$data["fetch_data"] = $this->user_model->fetch_data();
		$this->load->view('manageaccount', $data);
	}

	//----------------------------------------------------------------------update and delete accounts
	public function update_and_delete_user_accounts()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('email', 'E mail', 'trim|required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('con_password', 'confirm password', 'required|matches[password]');


		if ($this->form_validation->run()) {
			$this->load->model('user_model');

			$data = array(
				"type" => strtolower((str_replace(' ', '_', $this->input->post("type")))),
				"post" => strtolower((str_replace(' ', '_', $this->input->post("post")))),
				"username" => $this->input->post("username"),
				"password" => md5($this->input->post("password")),
				"email" => $this->input->post("email")
			);

			$p = strtolower((str_replace(' ', '_', $this->input->post("type"))));
			$t = strtolower((str_replace(' ', '_', $this->input->post("post"))));

			if (($_SESSION['post'] == $p) && ($_SESSION['type'] == $t)) {
				if (($this->input->post("username")) != $this->session->userdata('username')) {
					$this->session->set_userdata('username', $this->input->post("username"));
				}
			}
			$this->user_model->update_user_account_data($data, $_SESSION['account_username']);

			$this->user_model->update_TYPE($data, $this->input->post("username"));

			include './public/PHPMailer/PHPMailerAutoload.php';

			$mail = new PHPMailer();
			$mail->isSMTP();
			$mail->SMTPAuth = true;
			$mail->SMTPSecure = 'ssl';
			$mail->Host = 'smtp.gmail.com';
			$mail->Port = '465';
			$mail->isHTML();
			$mail->Username = 'mrdoc.dms@gmail.com';
			$mail->Password = 'mrdoc100100100';
			$mail->setFrom('noreply@example.com');
			$mail->Subject = $_SESSION['myemail'];
			$mail->Body = 'from : ' . $this->session->userdata('username') . '<br/> Your account has been updated. <br/>
			Username : ' . $this->input->post("username") . '<br/>
			Password : ' . $this->input->post("password") . '
			 <br/>
			 <br/><center>
			 Thank you!<br/>
			 &copy; Copyright - MrDoc<br/>
			 2019
			 </center>';
			$mail->AddAddress($this->input->post('email'));
			$mail->Send();

			$this->session->set_flashdata('msg1', 'Username <b>' . $_SESSION['account_username'] . "</b>'s account successfully updated.");
			if ($_SESSION['report'] != "report") {
				redirect(base_url() . "login_controller/manageAccount");
			} else {
				redirect(base_url() . "login_controller/report");
			}
		} else {
			$this->refilter();
		}

	}

	//----------------------------------------------------------------------account delete confirm

	public function refilter()
	{
		$this->load->view('searchdata');
	}

	//----------------------------------------------------------------------re open searchdata.php

	public function delete_conform_account()
	{

		$this->load->library('form_validation');

		$this->form_validation->set_rules('pw', 'Password', 'required');
		$this->form_validation->set_rules('confirm_pw', 'confirm password', 'required|matches[pw]');
		$pswd = ($this->input->post('admin_password'));
		$con_psw = md5($this->input->post('confirm_pw'));
		$pwd = md5($this->input->post('pw'));
		if ($this->form_validation->run()) {
			$this->load->model('user_model');
			if (($pwd == $pswd) && ($con_psw == $pswd)) {
				$this->user_model->delete_user_account_data($_SESSION['account_username']);
				$this->session->set_flashdata('msg', 'Username ' . $_SESSION['account_username'] . "'s account is deleted.");
				redirect(base_url() . "login_controller/manageAccount");
			} else {
				$this->session->set_flashdata('msg', 'Invalid password!');
				$this->refilter();
			}
		} else {
			$this->refilter();
		}
	}

	//----------------------------------------------------------------------searchdata.php

	public function filter()
	{
		$_SESSION['account_username'] = $this->input->post('username');
		$_SESSION['account_password'] = $this->input->post('password');
		$_SESSION['account_type'] = $this->input->post('type');
		$_SESSION['account_email'] = $this->input->post('email');
		$_SESSION['account_post'] = $this->input->post('post');
		$_SESSION['report'] = $this->input->post('report');
		$_SESSION['id'] = $this->input->post('id');
		$_SESSION['course_name'] = $this->input->post('course_name');
		$this->load->view('searchdata');
	}

	//----------------------------------------------------------------------account password update

	public function user_account_update_validation()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
		$this->form_validation->set_rules('conpass', 'confirm password', 'required|matches[password]');

		if ($this->form_validation->run()) {
			$this->load->model('user_model');
			$data = array(
				"username" => $this->input->post("username"),
				"password" => md5($this->input->post("password")),
				"email" => $this->input->post("email")
			);

			$this->user_model->update_data($data, $this->input->post("username"));
			$this->session->set_flashdata('msg', 'Account successfully updated.');
			redirect(base_url() . "login_controller/useraccountupdate");

		} else {
			$this->useraccountupdate();
		}
	}

	//----------------------------------------------------------------------Admin user name and password update

	public function useraccountupdate()
	{
		$username = $this->session->userdata('username');
		$this->load->model('user_model');
		$data['user_data'] = $this->user_model->fetch_single_data($username);
		$this->load->view('userAccountUpdate', $data);
	}

	//----------------------------------------------------------------------delete account
	public function delete_data()
	{
		$username = $this->uri->segment(3);
		$this->load->model('user_model');
		if ($username != '') {
			$this->user_model->delete_data($username);
		}
		redirect(base_url() . "login_controller/manageAccount");

	}

	//--------------------------------------------------------------------------------upload file

	public function do_upload()
	{

		$this->load->library('form_validation');

		$this->form_validation->set_rules('academic_year', 'Academic Year', 'required');
		$this->form_validation->set_rules('subject_code', 'Subject Code', 'required');
		$this->form_validation->set_rules('semester', 'Semester', 'required');
		$this->form_validation->set_rules('year', 'Year', 'required');
		$this->form_validation->set_rules('category', 'Category', 'required');
		$this->form_validation->set_rules('doc_type', 'Type', 'required');
		$this->form_validation->set_rules('lecturer', 'Lecturer', 'required');
		$this->form_validation->set_rules('academic_year', 'Academic Year', 'required');

		if ($this->form_validation->run()) {

			if($this->input->post("year")==0){

			}else{
				$name4 = $this->input->post("subject_code");
				$name5 = $this->input->post("lecturer");
				$name1 = $this->input->post("academic_year");
				$fileName=$name4 . $name5 . $name1;
				$config['file_name'] = $fileName;
			}

			$config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'pdf';
			$config['max_size'] = 10240;
			$config['overwrite'] = true;
			$config['remove_spaces'] = true;
			$config['file_ext_tolower'] = true; // convert extension to lowercase

			$this->load->library('upload', $config);
			$this->load->model('user_model');

			if (!$this->upload->do_upload('file_name')) {

				$this->load->model('user_model');
//				$data["fetch_data"] = $this->user_model->userdetails();
				$this->session->set_flashdata('errorx', $this->upload->display_errors());
				$this->load->view('uploadfile'/*, $data*/);

				redirect(base_url());
			} else {

				date_default_timezone_set("Asia/Colombo");
				$date_time = date("Y-m-d") . " (" . date("h:i:sa") . ")";
				$up_file_name = $this->upload->data();
				$data = array(
					"file_name" => $up_file_name['file_name'],
					"date_created" => $date_time,
					"category" => $this->input->post("category"),
					"year" => $this->input->post("year"),
					"semester" => $this->input->post("semester"),
					"academic_year" => $this->input->post("academic_year"),
					"subject_code" => $this->input->post("subject_code"),
					"author" => $this->session->userdata('username'),
					"comment" => $this->input->post("comment"),
					"lecturer" => $this->input->post("lecturer"),
					"doc_type" => $this->input->post("doc_type")
				);

				$body = '<b>' . $_SESSION['myemail'] . '</b> <br/>
				
			 New file has been uploaded for your name.  </br> Click here to view "http://localhost/CDI/Home/viewDocument" <br/> 
			 <br/>
			 <br/>
			 <br/>
			 <center>
			 Thank you!<br/>
			 &copy; Copyright - MrDoc<br/>
			 2019
			 </center>';

				$this->user_model->insert_file($data, $up_file_name['file_name']);


				include './public/PHPMailer/PHPMailerAutoload.php';

				$mail = new PHPMailer();
				$mail->isSMTP();
				$mail->SMTPAuth = true;
				$mail->SMTPSecure = 'ssl';
				$mail->Host = 'smtp.gmail.com';
				$mail->Port = '465';
				$mail->isHTML();
				$mail->Username = 'mrdoc.dms@gmail.com';
				$mail->Password = 'mrdoc100100100';
				$mail->setFrom('noreply@example.com');

				$mail->Subject = 'New file Uploaded';
				$mail->Body = $body;
//				$mail->addAttachment('uploads/'.$up_file_name['file_name']);
				$data['fetch_data'] = $this->user_model->userdetails();

				foreach ($data['fetch_data']->result() as $row) {
					if ($row->username == $this->input->post("lecturer")) {
						$mail->AddBcc($row->email);
					}
				}

				if ($this->session->flashdata("check") == 'check') {
					$mail->Send();
				}
				redirect(base_url('login_controller/uploadFile'));
			}
		} else {
			$this->uploadFile();
		}

	}

	//----------------------------------------------------------------------upload page
	public function uploadFile()
	{
		$this->load->model('user_model');
		$data["fetch_data"] = $this->user_model->userdetails();
		$this->load->view('uploadfile', $data);
	}

	//----------------------------------------------------------------------edit page
	public function editFile()
	{
		$_SESSION['file_name'] = $this->uri->segment(3);
		$this->load->model('user_model');
		$data['user_data'] = $this->user_model->fetch_single_file($this->uri->segment(3));
		$data['user_data2'] = $this->user_model->getcommits($_SESSION['file_name']);
		$this->load->view('edit', $data);
	}




	//----------------------------------------------------------------------re open edit page
	public function reopen_editFile()
	{
		$this->load->model('user_model');
		$data['user_data'] = $this->user_model->fetch_single_file($_SESSION['file_name']);
		$data['user_data2'] = $this->user_model->getcommits($_SESSION['file_name']);
		$this->load->view('edit', $data);
	}

	//----------------------------------------------------------------------download
	public function direct_download()
	{
		$this->load->helper('download');
		if ($this->uri->segment(3)) {
			$data = file_get_contents('./uploads/' . $this->uri->segment(3));
			$name = $this->uri->segment(3);
			force_download($name, $data);
		}
	}

	//----------------------------------------------------------------------download
	public function download_file()
	{
		$this->load->helper('download');
		if ($this->input->post("submit")) {
			$data = file_get_contents('update_and_delete_user_accounts' . $this->input->post("submit"));
			$name = $this->input->post("submit");
			force_download($name, $data);
		}
		if ($this->input->post("edit")) {
			redirect(base_url('login_controller/edit_uploaded_files'));
		}

		if ($_SESSION['file_name_to_delete']) {
			redirect(base_url('login_controller/delete_uploaded_file'));
		}

	}

	public function edit_uploaded_files(){
		$this->load->model('user_model');
		$data['fetch_data'] = $this->user_model->fetch_single_file($_SESSION['file_name']);
		$this->load->view('edit_file', $data);
	}

	public function delete_uploaded_file()
	{
		$this->load->model('user_model');
		$file = 'uploads/' . $_SESSION['file_name_to_delete'];
		$newfile = './uploads/Trash/' . $_SESSION['file_name_to_delete'];
		copy($file, $newfile);

		$data["fetch_data"] = $this->user_model->fetch_file_to_delete($_SESSION['file_name_to_delete']);

		foreach ($data["fetch_data"]->result() as $row) {
			$data1 = array(
				"file_name" => $row->file_name,
				"date_created" => $row->date_created,
				"category" => $row->category,
				"year" => $row->year,
				"semester" => $row->semester,
				"academic_year" => $row->academic_year,
				"subject_code" => $row->subject_code,
				"author" => $row->author,
				"comment" => $row->comment,
				"lecturer" => $row->lecturer,
				"doc_type" => $row->doc_type
			);

		}


		$this->user_model->trashed_Files($data1, $_SESSION['file_name_to_delete']);
		unlink("uploads/" . $_SESSION['file_name_to_delete']);
		$this->user_model->deleteFiles($_SESSION['file_name_to_delete']);
		$this->session->set_flashdata('delete_massage', 'file "' . $_SESSION['file_name_to_delete'] . '" successfully Moved to Trash. [You cannot delete files permanently]');
		unset($_SESSION['file_name_to_delete']);
		redirect(base_url('Home/viewDocument'));
	}

	//----------------------------------------------------------------------document settings page

	public function insertCat()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('category', 'Category', 'required');

		if ($this->form_validation->run()) {

			$cat = strtolower($this->input->post('category'));
			$name = str_replace(' ', '_', $cat);

			$this->load->model('user_model');
			$data = array(
				"category" => $name
			);
			?>
			<script>
                // alert('One category is successfully inserted');
                window.location.href = '<?php echo base_url();?>login_controller/Document_Settings';
			</script>

			<?php
//			$this->session->set_flashdata('msg1', 'Undergraduate course inserted.');
			$name = str_replace(' ', '_', $this->input->post("category"));

			$this->user_model->insert_cat($data, $cat);
			$this->load->model('user_model');
			$this->user_model->create_tables($name);

		} else {
			$this->Document_Settings();
		}
	}

	public function Document_Settings()
	{
		$this->load->model('user_model');
		$data["fetch_data"] = $this->user_model->fetch_cat();
		$this->load->view('DocumentSettings', $data);
	}

	//----------------------------------------------------------------------delete category(under graduate)

	public function delete_cat()
	{
		$category = $_SESSION['x'];
		$name = str_replace(' ', '_', $category);
		$this->load->model('user_model');
		if ($category != '') {
			$this->user_model->delete_cat($category);
			$this->user_model->delete_tables($name);
		}
		$this->session->set_flashdata('msg', 'Category <b>' . $category . '</b> deleted.');
		redirect(base_url('login_controller/Document_Settings'));
	}

	//----------------------------------------------------------------------delete category(post graduate)
	public function delete_cat_postgraduate()
	{
		$category = $_SESSION['pg'];
		$name = str_replace(' ', '_', $category);
		$this->load->model('user_model');
		if ($category != '') {
			$this->user_model->delete_cat_postgraduate($category);
			$this->user_model->delete_tables($name);
		}
		$this->session->set_flashdata('msg', 'Category <b>' . $category . '</b> deleted.');
		redirect(base_url('login_controller/Post_Graduate'));
	}

	//----------------------------------------------------------------------delete category(external degree)
	public function delete_cat_external()
	{
		$category = $_SESSION['ext'];
		$name = str_replace(' ', '_', $category);
		$this->load->model('user_model');
		if ($category != '') {
			$this->user_model->delete_cat_external($category);
			$this->user_model->delete_tables($name);
		}
		$this->session->set_flashdata('msg', 'Category <b>' . $category . '</b> deleted.');
		redirect(base_url('login_controller/external_deg'));
	}

	//----------------------------------------------------------------------add subjects
	public function add_subject()
	{

		$this->load->library('form_validation');
		$this->form_validation->set_rules('category', 'category', 'required');
		$this->form_validation->set_rules('subject_name', 'Subject Name', 'required');
		$this->form_validation->set_rules('subject_code', 'Subject Code', 'required');
		$this->form_validation->set_rules('year', 'Year', 'required');
		$this->form_validation->set_rules('semester', 'Semester', 'required');

		if ($this->form_validation->run()) {
			$tname = strtolower($this->input->post('category'));
			$subject_code = strtoupper($this->input->post("subject_code"));
			$this->load->model('user_model');
			$data = array(
				"subject_code" => $subject_code,
				"subject_name" => $this->input->post("subject_name"),
				"year" => $this->input->post("year"),
				"semester" => $this->input->post("semester")
			);
			$this->user_model->insertdata($tname, $data);
			?>
			<script>
                alert('One Subject is successfully inserted');
                window.location.href = '<?php echo base_url();?>login_controller/Document_Settings';
			</script>
			<?php
		} else {
			$this->Document_Settings();
		}
	}

	//----------------------------------------------------------------------get subjects for drop down
	function fetch_sub()
	{

		if ($this->input->post('category_name')) {
			$this->load->model('user_model');
			echo $this->user_model->fetch_subject($this->input->post('category_name'));
		}
	}

	//----------------------------------------------------------------------get subjects for drop down
	public function fetch_sub_year()
	{
		if ($this->input->post('year_name')) {
			$this->load->model('user_model');
			echo $this->user_model->fetch_subject_year($this->input->post('year_name'), $this->input->post('category_name'));
		}
	}

	//----------------------------------------------------------------------get subjects for drop down
	public function fetch_sub_year_sem()
	{
		if ($this->input->post('semester_name')) {
			$this->load->model('user_model');
			echo $this->user_model->fetch_subject_year_semester($this->input->post('year_name'), $this->input->post('category_name'), $this->input->post('semester_name'));
		}

	}

	//----------------------------------------------------------------------view category details(under graduate)

	public function View_cat_details_External()
	{
		$category = $this->input->post("Submit");
		$this->load->model('user_model');
		$_SESSION['ext'] = $category;
		$data["fetch_data"] = $this->user_model->fetch_data_cat_table($category);
		$this->load->view('ViewCategoryDetailsExternal', $data);
	}

	//----------------------------------------------------------------------view category details(post graduate)

	public function category_update()
	{

		$this->load->library('form_validation');
		$this->form_validation->set_rules('category', 'category', 'required');

		$oldcat = str_replace(' ', '_', $this->input->post('hide'));
		$Oldname = strtolower($oldcat);
		$cat = str_replace(' ', '_', $this->input->post('category'));
		$Newname = strtolower($cat);

		if ($this->form_validation->run()) {
			$this->load->model('user_model');
			$data = array(
				"category" => $Newname,
			);
			$data2 = array(
				"course_name" => $Newname,
			);
			$this->user_model->update_data_user($Oldname, $data2);
			$this->user_model->update_data_category($Oldname, $data);
			$this->user_model->update_data_fileupload($Oldname, $data);
			$this->user_model->rename_category($Oldname, $Newname);

			unset($_SESSION['x']);
			$_SESSION['x'] = $Newname;
			redirect(base_url() . "login_controller/reopen_View_cat_details");
		} else {
			$this->View_cat_details();
		}

	}

	//----------------------------------------------------------------------view category details(external degree)

	public function View_cat_details()
	{

		$category = $this->input->post("Submit");
		$this->load->model('user_model');
		$_SESSION['x'] = $category;
		$data["fetch_data"] = $this->user_model->fetch_data_cat_table($category);
		$this->load->view('viewCategoryDetails', $data);

	}

	//----------------------------------------------------------------------update category details(under graduate)

	public function category_update_postgraduate()
	{

		$this->load->library('form_validation');
		$this->form_validation->set_rules('category', 'category', 'required');

		$oldcat = str_replace(' ', '_', $this->input->post('hide'));
		$Oldname = strtolower($oldcat);
		$cat = str_replace(' ', '_', $this->input->post('category'));
		$Newname = strtolower($cat);

		if ($this->form_validation->run()) {
			$this->load->model('user_model');
			$data = array(
				"category" => $Newname,
			);
			$data2 = array(
				"course_name" => $Newname,
			);
			$this->user_model->update_data_user($Oldname, $data2);
			$this->user_model->update_data_category_postgraduate($Oldname, $data);
			$this->user_model->update_data_fileupload($Oldname, $data);
			$this->user_model->rename_category($Oldname, $Newname);

			unset($_SESSION['pg']);
			$_SESSION['pg'] = $Newname;
			redirect(base_url() . "login_controller/reopen_View_cat_details_post_graduate");
		} else {
			$this->View_cat_details_post_graduate();
		}

	}

	//----------------------------------------------------------------------update category details(post graduate)

	public function View_cat_details_post_graduate()
	{

		$category = $this->input->post("Submit");
		$this->load->model('user_model');
		$_SESSION['pg'] = $category;
		$data["fetch_data"] = $this->user_model->fetch_data_cat_table($category);
		$this->load->view('ViewCategoryDetailsPostGraduate', $data);

	}

	//----------------------------------------------------------------------update category details(external degree)

	public function category_update_external()
	{

		$this->load->library('form_validation');
		$this->form_validation->set_rules('category', 'category', 'required');

		$oldcat = str_replace(' ', '_', $this->input->post('hide'));
		$Oldname = strtolower($oldcat);
		$cat = str_replace(' ', '_', $this->input->post('category'));
		$Newname = strtolower($cat);

		if ($this->form_validation->run()) {
			$this->load->model('user_model');
			$data = array(
				"category" => $Newname,
			);
			$data2 = array(
				"course_name" => $Newname,
			);
			$this->user_model->update_data_user($Oldname, $data2);
			$this->user_model->update_data_category_external($Oldname, $data);
			$this->user_model->update_data_fileupload($Oldname, $data);
			$this->user_model->rename_category($Oldname, $Newname);

			unset($_SESSION['ext']);
			$_SESSION['ext'] = $Newname;
			redirect(base_url() . "login_controller/reopen_View_cat_details_external");
		} else {
			$this->reopen_View_cat_details_external();
		}

	}

	//----------------------------------------------------------------------re open category details(under graduate)

	public function reopen_View_cat_details_external()
	{
		$this->load->model('user_model');
		$Newname = $_SESSION['ext'];
		$data["fetch_data"] = $this->user_model->fetch_data_cat_table($Newname);
		$this->load->view('ViewCategoryDetailsExternal', $data);
	}

	//----------------------------------------------------------------------re open category details(post graduate)

	public function add_subjects_cat()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('subject_name', 'Subject Name', 'required');
		$this->form_validation->set_rules('subject_code', 'Subject Code', 'required');
		$this->form_validation->set_rules('year', 'Year', 'required');
		$this->form_validation->set_rules('semester', 'Semester', 'required');

		if ($this->form_validation->run()) {
			$tname = strtolower($this->input->post('category'));
			$subject_code = strtoupper($this->input->post("subject_code"));
			$this->load->model('user_model');
			$data = array(
				"subject_code" => $subject_code,
				"subject_name" => $this->input->post("subject_name"),
				"year" => $this->input->post("year"),
				"semester" => $this->input->post("semester")
			);
			$this->user_model->insertdata($tname, $data, $subject_code);
			?>

			<script>
                // alert('One Subject is successfully inserted');
                window.location.href = '<?php echo base_url();?>login_controller/reopen_View_cat_details';
			</script>
			<?php
//			$this->session->set_flashdata('msg1', 'New subject is successfully inserted');
		} else {
			$this->session->set_flashdata('msg', 'Oops! something went wrong.');
			$this->reopen_View_cat_details();

		}

	}

	//----------------------------------------------------------------------re open category details(external degree)

	public function reopen_View_cat_details()
	{
		$this->load->model('user_model');
		$Newname = $_SESSION['x'];
		$data["fetch_data"] = $this->user_model->fetch_data_cat_table($Newname);
		$this->load->view('viewCategoryDetails', $data);
	}

	//----------------------------------------------------------------------add subjects(under graduate)

	public function add_subjects_cat_post_graduate()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('subject_name', 'Subject Name', 'required');
		$this->form_validation->set_rules('subject_code', 'Subject Code', 'required');
		$this->form_validation->set_rules('year', 'Year', 'required');
		$this->form_validation->set_rules('semester', 'Semester', 'required');

		if ($this->form_validation->run()) {
			$tname = strtolower($this->input->post('category'));
			$subject_code = strtoupper($this->input->post("subject_code"));
			$this->load->model('user_model');
			$data = array(
				"subject_code" => $subject_code,
				"subject_name" => $this->input->post("subject_name"),
				"year" => $this->input->post("year"),
				"semester" => $this->input->post("semester")
			);
			$this->user_model->insertdata($tname, $data, $subject_code);
			?>

			<script>
                // alert('One Subject is successfully inserted');
                window.location.href = '<?php echo base_url();?>login_controller/reopen_View_cat_details_post_graduate';
			</script>
			<?php
//			$this->session->set_flashdata('msg1', 'New subject is successfully inserted');
		} else {
			$this->session->set_flashdata('msg', 'Oops! something went wrong.');
			$this->reopen_View_cat_details_post_graduate();

		}
	}

	//----------------------------------------------------------------------add subjects(post graduate)

	public function reopen_View_cat_details_post_graduate()
	{
		$this->load->model('user_model');
		$Newname = $_SESSION['pg'];
		$data["fetch_data"] = $this->user_model->fetch_data_cat_table($Newname);
		$this->load->view('ViewCategoryDetailsPostGraduate', $data);
	}

	//----------------------------------------------------------------------add subjects(external degree)

	public function add_subjects_cat_external()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('subject_name', 'Subject Name', 'required');
		$this->form_validation->set_rules('subject_code', 'Subject Code', 'required');
		$this->form_validation->set_rules('year', 'Year', 'required');
		$this->form_validation->set_rules('semester', 'Semester', 'required');

		if ($this->form_validation->run()) {
			$tname = strtolower($this->input->post('category'));
			$subject_code = strtoupper($this->input->post("subject_code"));
			$this->load->model('user_model');
			$data = array(
				"subject_code" => $subject_code,
				"subject_name" => $this->input->post("subject_name"),
				"year" => $this->input->post("year"),
				"semester" => $this->input->post("semester")
			);
			$this->user_model->insertdata($tname, $data, $subject_code);
			?>

			<script>
                // alert('One Subject is successfully inserted');
                window.location.href = '<?php echo base_url();?>login_controller/reopen_View_cat_details_external';
			</script>
			<?php
//			$this->session->set_flashdata('msg1', 'New subject is successfully inserted');
		} else {
			$this->session->set_flashdata('msg', 'Oops! something went wrong.');
			$this->reopen_View_cat_details_external();
		}
	}

	//----------------------------------------------------------------------delete category(under graduate)
	public function delete_category_dt()
	{
		$subject = $this->input->post('submit');
		$category = $this->input->post('category');
		$this->load->model('user_model');
		if ($subject != '') {
			$this->user_model->delete_cat_data($subject, $category);
		}
		$this->session->set_flashdata('msg', 'Subject <b>' . $subject . '</b> deleted.');
		redirect(base_url() . "login_controller/reopen_View_cat_details");
	}

	//----------------------------------------------------------------------delete category(post graduate)
	public function delete_category_dt_postgraduate()
	{
		$subject = $this->input->post('submit');
		$category = $this->input->post('category');
		$this->load->model('user_model');
		if ($subject != '') {
			$this->user_model->delete_cat_data($subject, $category);
		}
		$this->session->set_flashdata('msg', 'Subject ' . $subject . ' is successfully deleted');
		redirect(base_url() . "login_controller/reopen_View_cat_details_post_graduate");
	}

	//----------------------------------------------------------------------delete category(external degree)
	public function delete_category_dt_external()
	{
		$subject = $this->input->post('submit');
		$category = $this->input->post('category');
		$this->load->model('user_model');
		if ($subject != '') {
			$this->user_model->delete_cat_data($subject, $category);
		}
		$this->session->set_flashdata('msg', 'Subject ' . $subject . ' is successfully deleted');
		redirect(base_url() . "login_controller/reopen_View_cat_details_external");
	}

	//----------------------------------------------------------------------update subjects

	public function update_subjects_cat()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('subject_name', 'Subject Name', 'required');
		$this->form_validation->set_rules('subject_code', 'Subject Code', 'required');
		$this->form_validation->set_rules('year', 'Year', 'required');
		$this->form_validation->set_rules('semester', 'Semester', 'required');

		if ($this->form_validation->run()) {

			$tname = $_SESSION['category'];

			$old_subject_code = $this->input->post("hide");
			$this->load->model('user_model');
			$data = array(
				"subject_code" => $this->input->post("subject_code"),
				"subject_name" => $this->input->post("subject_name"),
				"year" => $this->input->post("year"),
				"semester" => $this->input->post("semester")
			);
			$data2 = array(
				"subject_code" => $this->input->post("subject_code")
			);
			$this->user_model->update_category_date($tname, $data, $old_subject_code);

			$this->user_model->update_category_fileupload($data2, $old_subject_code);

			if ($_SESSION['accounttype'] == "postgraduate") {
				$this->session->set_flashdata('msg1', 'Subject is successfully updated');
				redirect(base_url('login_controller/reopen_View_cat_details_post_graduate'));
			} elseif ($_SESSION['accounttype'] == "external_deg") {
				$this->session->set_flashdata('msg1', 'Subject is successfully updated');
				redirect(base_url('login_controller/reopen_View_cat_details_external'));
			} else {
				?>
				<script>
                    // alert('A Subject is successfully Updated');
                    window.location.href = '<?php echo base_url();?>login_controller/reopen_View_cat_details';
				</script>
				<?php
				$this->session->set_flashdata('msg1', 'Subject is successfully updated');
			}
		} else {
			$this->Update_subject();
		}
	}

	//----------------------------------------------------------------------update subjects(post,under,external)

	public function Update_subject()
	{
		$_SESSION['year'] = $this->input->post('year');
		$_SESSION['semester'] = $this->input->post('semester');
		$_SESSION['subject_code'] = $this->input->post('subject_code');
		$_SESSION['subject_name'] = $this->input->post('subject_name');
		$_SESSION['category'] = $this->input->post('category');
		$_SESSION['accounttype'] = $this->input->post('type');

		$this->load->view('subject_edit');
	}

	//---------------------------------------------------------------------- edit file page

	function view_edit_file()
	{
		$this->load->model('user_model');
		$data['fetch_data'] = $this->user_model->fetch_single_file($_SESSION['file_name']);
		$this->load->view('uploadFile', $data);
	}

	//----------------------------------------------------------------------dropdown
	function fetch_sub_update()
	{

		if ($this->input->post('category_name')) {
			$this->load->model('user_model');
			echo $this->user_model->fetch_subject_update($this->input->post('category_name'));
		}
	}

	//----------------------------------------------------------------------dropdown
	public function fetch_sub_year_update()
	{
		if ($this->input->post('year_name')) {
			$this->load->model('user_model');
			echo $this->user_model->fetch_subject_year_update($this->input->post('year_name'), $this->input->post('category_name'));
		}
	}

	//----------------------------------------------------------------------dropdown
	public function fetch_sub_year_sem_update()
	{
		if ($this->input->post('semester_name')) {
			$this->load->model('user_model');
			echo $this->user_model->fetch_subject_year_semester_update($this->input->post('year_name'), $this->input->post('category_name'), $this->input->post('semester_name'));
		}

	}

	//----------------------------------------------------------------------post graduate page

	public function insertExternal()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('category', 'Category', 'required');

		if ($this->form_validation->run()) {

			$cat = strtolower($this->input->post('category'));
			$name = str_replace(' ', '_', $cat);

			$this->load->model('user_model');
			$data = array(
				"category" => $name
			);
			?>
			<script>
                // alert('One category is successfully inserted');
                window.location.href = '<?php echo base_url();?>login_controller/external_deg';
			</script>

			<?php
//			$this->session->set_flashdata('msg1', 'External course inserted.');
			$name = str_replace(' ', '_', $this->input->post("category"));

			$this->user_model->insert_external($data, $cat);
			$this->load->model('user_model');
			$this->user_model->create_tables($name);

		} else {
			$this->external_deg();
		}
	}

	//----------------------------------------------------------------------external degree page

	public function External_Deg()
	{
		$this->load->model('user_model');
		$data["fetch_data"] = $this->user_model->fetch_cat_External();
		$this->load->view('external_deg', $data);
	}

	//----------------------------------------------------------------------insert category(external degree)

	public function insertPostgraduate()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('category', 'Category', 'required');

		if ($this->form_validation->run()) {

			$cat = strtolower($this->input->post('category'));
			$name = str_replace(' ', '_', $cat);

			$this->load->model('user_model');
			$data = array(
				"category" => $name
			);
			?>
			<script>
                // alert('One category is successfully inserted');
                window.location.href = '<?php echo base_url();?>login_controller/Post_Graduate';
			</script>

			<?php
//			$this->session->set_flashdata('msg1', 'Postgraduate course inserted.');
			$name = str_replace(' ', '_', $this->input->post("category"));

			$this->user_model->insert_postgraduate($data, $cat);
			$this->load->model('user_model');
			$this->user_model->create_tables($name);


		} else {
			$this->Post_Graduate();
		}
	}

	//----------------------------------------------------------------------insert category(post graduate)

	public function Post_Graduate()
	{
		$this->load->model('user_model');
		$data["fetch_data"] = $this->user_model->fetch_cat_postgraduate();
		$this->load->view('postgraduate', $data);
	}

	//----------------------------------------------------------------------report page

	public function Report()
	{
		$this->load->model('user_model');
		$data["count_data"] = $this->user_model->userdetails();
		$data["count_file"] = $this->user_model->fileupload_count();
		$data["fetch_data_un"] = $this->user_model->count_category();
		$data["fetch_data_pg"] = $this->user_model->count_category_p();
		$data["fetch_data_ex"] = $this->user_model->count_category_e();
		$this->load->view('report', $data);
	}

	public function fetch_category_TYPE()
	{
		$this->load->model('user_model');
		if ($this->input->post('account_type')) {
			echo $this->user_model->fetch_category_type($this->input->post('account_type'));
		}

	}

	public function fetch_users()
	{
		$this->load->model('user_model');
		echo $this->user_model->ftusers();

	}


	public function update_post()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('type', 'type', 'required');
		$this->form_validation->set_rules('post', 'post', 'required');

		if ($this->form_validation->run()) {
			$this->load->model('user_model');

			if ($this->input->post('post') != 'course_coordinator') {
				$data = array(
					"type" => strtolower((str_replace(' ', '_', $this->input->post("type")))),
					"post" => strtolower((str_replace(' ', '_', $this->input->post("post")))),
					"course_name" => ' '
				);
				$this->user_model->update_TYPE($data, $this->input->post("username"));
				include './public/PHPMailer/PHPMailerAutoload.php';

				$mail = new PHPMailer();
				$mail->isSMTP();
				$mail->SMTPAuth = true;
				$mail->SMTPSecure = 'ssl';
				$mail->Host = 'smtp.gmail.com';
				$mail->Port = '465';
				$mail->isHTML();
				$mail->Username = 'mrdoc.dms@gmail.com';
				$mail->Password = 'mrdoc100100100';
				$mail->setFrom('noreply@example.com');
				$mail->Subject = $_SESSION['myemail'];
				$mail->Body = 'from : ' . $this->session->userdata('username') . '<br/> Your current post has been updated. ' . (str_replace(' ', '_', $this->input->post("post"))) . ' <br/>
			 <br/>
			 <br/><center>
			 Thank you!<br/>
			 &copy; Copyright - MrDoc<br/>
			 2019
			 </center>';
				$mail->AddAddress($this->input->post('email'));
				$mail->Send();
			} else {
				$data = array(
					"type" => strtolower((str_replace(' ', '_', $this->input->post("type")))),
					"post" => strtolower((str_replace(' ', '_', $this->input->post("post"))))
				);
				$this->user_model->update_TYPE($data, $this->input->post("username"));

				include './public/PHPMailer/PHPMailerAutoload.php';

				$mail = new PHPMailer();
				$mail->isSMTP();
				$mail->SMTPAuth = true;
				$mail->SMTPSecure = 'ssl';
				$mail->Host = 'smtp.gmail.com';
				$mail->Port = '465';
				$mail->isHTML();
				$mail->Username = 'mrdoc.dms@gmail.com';
				$mail->Password = 'mrdoc100100100';
				$mail->setFrom('noreply@example.com');
				$mail->Subject = $_SESSION['myemail'];
				$mail->Body = 'from : ' . $this->session->userdata('username') . '<br/> Your current post has been updated to ' . (str_replace(' ', '_', $this->input->post("post"))) . '. <br/>
			 <br/>
			 <br/><center>
			 Thank you!<br/>
			 &copy; Copyright - MrDoc<br/>
			 2019
			 </center>';
				$mail->AddAddress($this->input->post('email'));
				$mail->Send();
//			redirect(base_url().'login_controller/refilter');

			}

			$_SESSION['account_username'] = $this->input->post('username');
			$_SESSION['account_email'] = $this->input->post('email');
			$_SESSION['account_post'] = strtolower((str_replace(' ', '_', $this->input->post("post"))));
			$_SESSION['account_type'] = strtolower((str_replace(' ', '_', $this->input->post("type"))));

			redirect(base_url() . "login_controller/refilter");
		} else {
			$_SESSION['account_username'] = $this->input->post('username');
			$_SESSION['account_email'] = $this->input->post('email');
			$_SESSION['account_post'] = strtolower((str_replace(' ', '_', $this->input->post("post"))));
			$_SESSION['account_type'] = strtolower((str_replace(' ', '_', $this->input->post("type"))));
			$this->refilter();
		}

	}

	public function update_course()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('type', 'type', 'required');
		$this->form_validation->set_rules('course_name', 'course name', 'required');

		if ($this->form_validation->run()) {
			$this->load->model('user_model');
			$data = array(
				"type" => strtolower(str_replace(' ', '_', $this->input->post("type"))),
				"course_name" => strtolower((str_replace(' ', '_', $this->input->post("course_name"))))
			);

			$this->user_model->update_TYPE($data, $this->input->post("username"));

			$_SESSION['account_username'] = $this->input->post('username');
			$_SESSION['account_email'] = $this->input->post('email');
			$_SESSION['account_type'] = strtolower((str_replace(' ', '_', $this->input->post("type"))));
			$_SESSION['course_name'] = strtolower((str_replace(' ', '_', $this->input->post("course_name"))));
			redirect(base_url() . "login_controller/refilter");
		} else {
			$_SESSION['account_username'] = $this->input->post('username');
			$_SESSION['account_email'] = $this->input->post('email');
			$_SESSION['course_name'] = strtolower((str_replace(' ', '_', $this->input->post("course_name"))));
			$_SESSION['account_type'] = strtolower((str_replace(' ', '_', $this->input->post("type"))));
			$this->refilter();
		}

	}

//	--------------------------------------contact qac head or user------------------------------------------------------

	public function contact_user()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('subject', 'subject', 'required');
		$this->form_validation->set_rules('Message', 'Message', 'required');

		if ($this->form_validation->run()) {

			include './public/PHPMailer/PHPMailerAutoload.php';

			$mail = new PHPMailer();
			$mail->isSMTP();
			$mail->SMTPAuth = true;
			$mail->SMTPSecure = 'ssl';
			$mail->Host = 'smtp.gmail.com';
			$mail->Port = '465';
			$mail->isHTML();
			$mail->Username = 'mrdoc.dms@gmail.com';
			$mail->Password = 'mrdoc100100100';
			$mail->setFrom('noreply@example.com');
			$mail->Subject = $this->input->post("from_email");
			$mail->Body = 'from : ' . $this->session->userdata('username') . '<br/><b>' . $this->input->post("subject") . '</b><br/>' . $this->input->post("account_username") . '<br/>' . $this->input->post("account_email") . '<br/>' . $this->input->post("Message") . ' <br/>
			 <br/>
			 <br/><center>
			 Thank you!<br/>
			 &copy; Copyright - MrDoc<br/>
			 2019
			 </center>';
			$mail->AddAddress($this->input->post("to_email"));
			if ($mail->Send()) {
				$this->session->set_flashdata('msg1', 'Your message has been successfully sent .');
			} else {
				$this->session->set_flashdata('msg', 'Oops something went wrong! send fail.');
			}
			redirect(base_url() . 'login_controller/refilter');
		} else {
			$this->refilter();
		}
	}

	public function send_message_accounts()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('message', 'message', 'required');
		$this->form_validation->set_rules('select_acc', 'Select Send group', 'required');
		$this->load->model('user_model');

		if ($this->form_validation->run()) {

			include './public/PHPMailer/PHPMailerAutoload.php';

			$mail = new PHPMailer();
			$mail->isSMTP();
			$mail->SMTPAuth = true;
			$mail->SMTPSecure = 'ssl';
			$mail->Host = 'smtp.gmail.com';
			$mail->Port = '465';
			$mail->isHTML();
			$mail->Username = 'mrdoc.dms@gmail.com';
			$mail->Password = 'mrdoc100100100';
			$mail->setFrom('noreply@example.com');
			$mail->Subject = $_SESSION['myemail'];
			$mail->Body = 'from : ' . $this->session->userdata('username') . '(' . str_replace('_', ' ', $_SESSION['post']) . ')<br/>' . $this->input->post("message") . ' <br/>
			 <br/>
			 <br/><center>
			 Thank you!<br/>
			 &copy; Copyright - MrDoc<br/>
			 2019
			 </center>';
//

			if ($this->input->post('select_acc') == 'to_all') {
				$data['fetch_data'] = $this->user_model->userdetails();
				foreach ($data['fetch_data']->result() as $row) {
					$mail->AddBcc($row->email);
				}
			} elseif ($this->input->post('select_acc') == 'to_head_of_institute') {
				$data['fetch_data'] = $this->user_model->userdetails();
				foreach ($data['fetch_data']->result() as $row) {
					if (($row->post) == 'head_of_institute') {
						$mail->AddBcc($row->email);
					}
				}
			} elseif ($this->input->post('select_acc') == 'to_external_head') {
				$data['fetch_data'] = $this->user_model->userdetails();
				foreach ($data['fetch_data']->result() as $row) {
					if ((($row->type) == 'external') && (($row->post) == 'head_of_course')) {
						$mail->AddBcc($row->email);
					}
				}
			} elseif ($this->input->post('select_acc') == 'to_postgraduate_head') {
				$data['fetch_data'] = $this->user_model->userdetails();
				foreach ($data['fetch_data']->result() as $row) {
					if ((($row->type) == 'post_graduate') && (($row->post) == 'head_of_course')) {
						$mail->AddBcc($row->email);
					}
				}
			} elseif ($this->input->post('select_acc') == 'to_undergraduate_head') {
				$data['fetch_data'] = $this->user_model->userdetails();
				foreach ($data['fetch_data']->result() as $row) {
					if ((($row->type) == 'under_graduate') && (($row->post) == 'head_of_course')) {
						$mail->AddBcc($row->email);
					}
				}
			} elseif ($this->input->post('select_acc') == 'to_qac') {
				$data['fetch_data'] = $this->user_model->userdetails();
				foreach ($data['fetch_data']->result() as $row) {
					if (($row->post) == 'qac') {
						$mail->AddBcc($row->email);
					}
				}
			} elseif ($this->input->post('select_acc') == 'to_all_heads') {
				$data['fetch_data'] = $this->user_model->userdetails();
				foreach ($data['fetch_data']->result() as $row) {
					if (($row->post) == 'head_of_course') {
						$mail->AddBcc($row->email);
					}
				}
			} elseif ($this->input->post('select_acc') == 'to_qac_head') {
				$data['fetch_data'] = $this->user_model->userdetails();
				foreach ($data['fetch_data']->result() as $row) {
					if (($row->post) == 'qac_head') {
						$mail->AddBcc($row->email);
					}
				}
			}

			$this->load->model('user_model');
			$data["fetch_cat"] = $this->user_model->getexternal();
			$data["fetch_file_upload_lec"] = $this->user_model->fileupload_count();

			foreach ($data["fetch_cat"]->result() as $row2) {
				if ($this->input->post('select_acc') == $row2->category . '_course_coordinator') {
					$data['fetch_data'] = $this->user_model->userdetails();
					foreach ($data['fetch_data']->result() as $row) {
						if ((($row->post) == 'course_coordinator') && (($row2->category) == ($row->course_name))) {
							$mail->AddBcc($row->email);
						}
					}
				}
				if ($this->input->post('select_acc') == 'to_all_externals') {
					$data['fetch_data'] = $this->user_model->userdetails();
					foreach ($data['fetch_data']->result() as $row) {
						if ((($row->type) == 'external') && (($row->post) == 'lecturer')) {
							$mail->AddBcc($row->email);
						}
						foreach ($data["fetch_file_upload_lec"]->result() as $row3) {
							if ((($row3->category) == $row2->category)) {
								$mail->AddBcc($row->email);
							}
						}
					}
				}
			}

			$data["fetch_cat2"] = $this->user_model->fetch_cat();
			foreach ($data["fetch_cat2"]->result() as $row2) {
				if ($this->input->post('select_acc') == $row2->category . '_course_coordinator') {
					$data['fetch_data'] = $this->user_model->userdetails();
					foreach ($data['fetch_data']->result() as $row) {
						if ((($row->post) == 'course_coordinator') && (($row2->category) == ($row->course_name))) {
							$mail->AddBcc($row->email);
						}
					}

				}
				if ($this->input->post('select_acc') == 'to_all_undergraduates') {
					$data['fetch_data'] = $this->user_model->userdetails();
					foreach ($data['fetch_data']->result() as $row) {
						if ((($row->type) == 'under_graduate') && (($row->post) == 'lecturer')) {
							$mail->AddBcc($row->email);
						}
						foreach ($data["fetch_file_upload_lec"]->result() as $row3) {
							if ((($row3->category) == $row2->category)) {
								$mail->AddBcc($row->email);
							}
						}
					}
				}
			}

			$data["fetch_cat3"] = $this->user_model->fetch_cat_postgraduate();

			foreach ($data["fetch_cat3"]->result() as $row2) {
				if ($this->input->post('select_acc') == $row2->category . '_course_coordinator') {
					$data['fetch_data'] = $this->user_model->userdetails();
					foreach ($data['fetch_data']->result() as $row) {
						if ((($row->post) == 'course_coordinator') && (($row2->category) == ($row->course_name))) {
							$mail->AddBcc($row->email);
						}
					}

				}
				if ($this->input->post('select_acc') == 'to_all_postgraduates') {
					$data['fetch_data'] = $this->user_model->userdetails();
					foreach ($data['fetch_data']->result() as $row) {
						if ((($row->type) == 'post_graduate') && (($row->post) == 'lecturer')) {
							$mail->AddBcc($row->email);
						}
						foreach ($data["fetch_file_upload_lec"]->result() as $row3) {
							if ((($row3->category) == $row2->category)) {
								$mail->AddBcc($row->email);
							}
						}
					}
				}


			}
			foreach ($data["fetch_cat3"]->result() as $row) {
				if (($_SESSION['course_name'] == $row->category)) {
					if ($this->input->post('select_acc') == 'to_all_postgraduate_' . $row->category) {
						$data['fetch_file'] = $this->user_model->getfileupload();
						foreach ($data["fetch_file"]->result() as $row2) {
							if (($row2->category) == $_SESSION['course_name']) {
								$mail->AddBcc($row2->email);
							}
						}
					}
				}
			}

			foreach ($data["fetch_cat2"]->result() as $row) {
				if (($_SESSION['course_name'] == $row->category)) {
					if ($this->input->post('select_acc') == 'to_all_undergraduate_' . $row->category) {
						$data['fetch_file'] = $this->user_model->getfileupload();
						foreach ($data["fetch_file"]->result() as $row2) {
							if (($row2->category) == $_SESSION['course_name']) {
								$mail->AddBcc($row2->email);
							}
						}
					}
				}
			}
			foreach ($data["fetch_cat"]->result() as $row) {
				if (($_SESSION['course_name'] == $row->category)) {
					if ($this->input->post('select_acc') == 'to_all_external_' . $row->category) {
						$data['fetch_file'] = $this->user_model->getfileupload();
						foreach ($data["fetch_file"]->result() as $row2) {
							if (($row2->category) == $_SESSION['course_name']) {
								$mail->AddBcc($row2->email);
							}
						}
					}
				}
			}


			if ($mail->Send()) {
				date_default_timezone_set("Asia/Colombo");
				$date = date("Y-m-d");
				$time = date("h:i:sa");
				$this->load->model('user_model');
				$data = array(
					"sender" => $this->session->userdata('username'),
					"receiver" => $this->input->post('select_acc'),
					"msg" => $this->input->post("message"),
					"date" => $date,
					"time" => $time
				);
				$this->user_model->insert_messages($data);

				$this->session->set_flashdata('msg1', 'Your message has been successfully sent .');
			} else {
				$this->session->set_flashdata('msg', 'Oops something went wrong! send fail.');
			}
			redirect(base_url() . 'login_controller/send_message');

		} else {
			$this->send_message();
		}

	}

	public function send_message()
	{
		$this->load->model('user_model');
		$data["fetch_cat"] = $this->user_model->getexternal();
		$data["fetch_cat2"] = $this->user_model->fetch_cat();
		$data["fetch_cat3"] = $this->user_model->fetch_cat_postgraduate();
		$data["messages"] = $this->user_model->fetch_messages_for_announcement();
		$data["fetch_file_upload_lecfetch_file_upload_lec"] = $this->user_model->fileupload_count();
		$this->load->view('message', $data);
	}

	public function db_backup()
	{
		$this->load->helper('url');
		$this->load->helper('file');
		$this->load->helper('download');
		$this->load->library('zip');
		$this->load->dbutil();

		$db_format = array('format' => 'zip', 'filename' => 'mrdoc121.sql');
		$this->dbutil->backup($db_format);
		$dbname = 'mrdoc-' . date('Y-m-d') . '.zip';
//		$save='./backup/'.$dbname;

		$filename = 'mrdoc-' . date('Y-m-d') . '.zip';
		$path = 'uploads';
		$this->zip->read_dir($path);
		$this->zip->archive(FCPATH . '/backup/' . $filename);
//		$this->zip->archive(FCPATH.'/backup/'.$dbname);
		if ($this->zip->archive(FCPATH . '/backup/' . $dbname)) {
			$this->session->set_flashdata('msg1', 'Backup completed');
			$this->load->model('user_model');
			date_default_timezone_set("Asia/Colombo");
			$date = date("Y-m-d");
			$data = array(
				"date" => $date,
				"backup_name_file" => $filename
			);
			$this->user_model->buckup_insert($data, $date);
		} else {
			$this->session->set_flashdata('msg', 'Something went wrong, Try again!');
		}
		redirect(base_url() . 'Home/BackUp');
//		force_download($dbname,$backup);

	}

	public function check_action()
	{
		$this->load->model('user_model');
		$data = array(
			"action" => $this->input->post('action')
		);
		$this->user_model->update_action($data);
		$_SESSION['action'] = $this->input->post('action');
	}


	public function download_zip()
	{
		$this->load->helper('download');
		if ($this->input->post('db')) {
			$data = file_get_contents('./backup/' . $this->input->post('db'));
			$name = $this->input->post('db');
			force_download($name, $data);
			redirect(base_url() . 'Home/BackUp');
		} elseif ($this->input->post('file')) {
			$data = file_get_contents('./backup/' . $this->input->post('file'));
			$name = $this->input->post('file');
			force_download($name, $data);
			redirect(base_url() . 'Home/BackUp');
		}
	}

	public function Bulkupload()
	{
		$this->load->view('bulkupload');
	}

	public function Restore()
	{
		$file_name = $this->input->post("filename");

		$this->load->model('user_model');
		$file = 'uploads/Trash/' . $file_name;
		$newfile = './uploads/' . $file_name;
		copy($file, $newfile);

		$data["fetch_data"] = $this->user_model->trash_details($file_name);
		foreach ($data["fetch_data"]->result() as $row) {


			$dta = array(
				"file_name" => $row->file_name,
				"date_created" => $row->date_created,
				"category" => $row->category,
				"year" => $row->year,
				"semester" => $row->semester,
				"academic_year" => $row->academic_year,
				"subject_code" => $row->subject_code,
				"author" => $row->author,
				"comment" => $row->comment,
				"lecturer" => $row->lecturer,
				"doc_type" => $row->doc_type
			);
		}

		$this->user_model->insert_file_restore($dta);
		unlink("uploads/Trash/" . $file_name);
		$this->user_model->deleteFilestrash($file_name);
		redirect(base_url('Home/Trash'));


	}

	public function login_pin()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->load->model('user_model');

		if ($this->form_validation->run()) {

			$email1 = $this->input->post("email");
			if ($this->user_model->get_email($email1)) {

				include './public/PHPMailer/PHPMailerAutoload.php';
				$_SESSION['Rpin'] = $this->input->post("Rpin");

				$mail = new PHPMailer();
				$mail->isSMTP();
				$mail->SMTPAuth = true;
				$mail->SMTPSecure = 'ssl';
				$mail->Host = 'smtp.gmail.com';
				$mail->Port = '465';
				$mail->isHTML();
				$mail->Username = 'mrdoc.dms@gmail.com';
				$mail->Password = 'mrdoc100100100';
				$mail->setFrom('noreply@example.com');
				$mail->Subject = "Reset Password";
				$mail->Body = "Your PIN : " . $this->input->post("Rpin");
				$mail->AddAddress($this->input->post("email"));
				$mail->Send();

				$this->session->set_flashdata('msg1', 'PIN was successfully sent. Check your Email');
				redirect(base_url() . "login_controller/fogotP");
			} else {
				$this->session->set_flashdata('msg2', 'This email cannot found in Mrdoc database.');
				$this->fogotP();
			}

		} else {
			$this->fogotP();
		}
	}

	public function fogotP()
	{
		$this->load->view('fogotpwd');

	}

	public function check_pin()
	{

		$this->load->library('form_validation');

		$this->form_validation->set_rules('pin', 'pin', 'required');

		if ($this->form_validation->run()) {
			if ($_SESSION['Rpin'] == $this->input->post("pin")) {
				redirect(base_url() . "login_controller/changeP");
			} else {
				$this->session->set_flashdata('msg', 'Invalid PIN');
				redirect(base_url() . "login_controller/fogotP");
			}
		} else {
			$this->fogotP();
		}

	}

	public function change_pwd()
	{

		$this->load->library('form_validation');

		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('npassword', 'Password', 'trim|required|min_length[8]');
		$this->form_validation->set_rules('cpassword', 'confirm password', 'required|matches[npassword]');

		if ($this->form_validation->run()) {
			$this->load->model('user_model');

			$password = md5($this->input->post("npassword"));

			$data = array(
				"username" => $this->input->post("username"),
				"password" => $password
			);

			$this->user_model->update_user_account_data($data, $this->input->post("username"));
			redirect(base_url() . "login_controller/login");
		} else {
			$this->changeP();
		}


	}

	public function changeP()
	{
		$this->load->view('changepwd');
	}

	public function submit_commit()
	{

		$this->load->library('form_validation');
		$this->form_validation->set_rules('commit', 'commit', 'required');
		if ($this->form_validation->run()) {
			$this->load->model('user_model');
			$data = array(
				"filename" => $this->input->post("filenametosubit"),
				"commit" => $this->input->post("commit")
			);
			$this->user_model->insert_commits($data);
			redirect(base_url("login_controller/reopen_editFile"));
		}else{
			$this->reopen_editFile();
		}

	}


	public function delete_conform_file()
	{

		$this->load->library('form_validation');

		$this->form_validation->set_rules('pw', 'Password', 'required');
		$this->form_validation->set_rules('confirm_pw', 'confirm password', 'required|matches[pw]');
		$pswd = ($this->input->post('admin_password'));
		$con_psw = md5($this->input->post('confirm_pw'));
		$pwd = md5($this->input->post('pw'));
		if ($this->form_validation->run()) {
			$this->load->model('user_model');
			if (($pwd == $pswd) && ($con_psw == $pswd)) {
				$_SESSION['file_name_to_delete'] = $this->input->post("filenametodelete");
				redirect(base_url() . "login_controller/download_file");
			} else {
				$this->session->set_flashdata('msg', 'Invalid password!');
				$this->reopen_editFile();
			}
		} else {
			$this->reopen_editFile();
		}
	}
	public function viewDocument(){
		$this->load->view('view_document');
	}

	function search_multiples(){

		$this->load->library('form_validation');
		$this->form_validation->set_rules('doc_type', 'Document type', 'required');
		$this->form_validation->set_rules('category', 'Category', 'required');
		$this->form_validation->set_rules('year', 'Year', 'required');
		$this->form_validation->set_rules('semester', 'Semester', 'required');

		if ($this->form_validation->run()) {
			$this->load->model('user_model');

			$_SESSION['search_multiples_doctype']=$this->input->post('doc_type');
			$_SESSION['search_multiples_category']=$this->input->post('category');
			$_SESSION['search_multiples_year']=$this->input->post('year');
			$_SESSION['search_multiples_semester']=$this->input->post('semester');

			redirect(base_url().'Home/SearchMultiplevalues');

		}else{
			$this->viewDocument();
		}

	}

	public function bulk_upload() {

		$this->load->library('form_validation');

		$this->form_validation->set_rules('doc_type', 'Type', 'required');
		$this->form_validation->set_rules('category', 'Category', 'required');
		$this->form_validation->set_rules('academic_year', 'Academic Year', 'required');

		if ($this->form_validation->run()){

			$count = count($_FILES['files']['name']);

			for($i=0;$i<$count;$i++){
				if(!empty($_FILES['files']['name'][$i])){

					$_FILES['file']['name'] = $_FILES['files']['name'][$i];
					$_FILES['file']['type'] = $_FILES['files']['type'][$i];
					$_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
					$_FILES['file']['error'] = $_FILES['files']['error'][$i];
					$_FILES['file']['size'] = $_FILES['files']['size'][$i];

					$config['upload_path'] = './uploads/';
					$config['allowed_types'] = 'pdf';
					$config['max_size'] = 10240;
					$config['overwrite'] = true;
					$config['remove_spaces'] = true;

					$this->load->library('upload',$config);
					$this->load->model('user_model');

					if($this->upload->do_upload('file')){
						$uploadData = $this->upload->data();
						$filename = $uploadData['file_name'];

						$name=str_split($filename);

						$length=count($name);
						$lecturer="";
						$extention="";
						$code="";

						for($j=4;$j<$length-4;$j++){
							$lecturer=$lecturer.$name[$j];
						}
						for($j=$length-4;$j<$length;$j++){
							$extention=$extention.$name[$j];
						}
						for($j=0;$j<4;$j++){
							$code=$code.$name[$j];
						}

							$key1=$name[0];
							$key2=$name[1];

							$year=0;
							$sem="";

							switch($key1){
								case 1:
									$year=1;
									break;
								case 2:
									$year=2;
									break;
								case 3:
									$year=3;
									break;
								case 4:
									$year=4;
									break;
							}

							switch($key2){
								case 1:
									$sem="1sem";
									break;
								case 2:
									$sem="2sem";
									break;
							}

						$data["data_subjects"] = $this->user_model->getfilename($this->input->post("category"));

						$subjectname="";
						foreach ($data["data_subjects"]->result() as $row) {
							$subjectname = $row->subject_code;
							break;
						}

						$sname=str_split($subjectname);
						$lengthsubject=count($sname);
						$sub="";

						for($j=0;$j<$lengthsubject-4;$j++){
							$sub=$sub.$sname[$j];
						}

						$finalname=$sub.$code.$lecturer.$this->input->post("academic_year").$extention;

						$data1['totalFiles'][] = $finalname;
						date_default_timezone_set("Asia/Colombo");
							$date_time= date("Y-m-d") . " (" . date("h:i:sa") . ")";

							$data = array(
								"file_name" => $finalname,
								"date_created" => $date_time,
								"category" => $this->input->post("category"),
								"year" => $year,
								"semester" => $sem,
								"academic_year" => $this->input->post("academic_year"),
								"subject_code" => $sub.$code,
								"author" => $this->session->userdata('username'),
								"comment" => $this->input->post('comment'),
								"lecturer" => $lecturer,
								"doc_type" => $this->input->post("doc_type")
							);
							$this->user_model->insert_file($data,$filename);
					}
				}
			}

			redirect(base_url('login_controller/Bulkupload'));
		}
		else{
			$this->Bulkupload();
		}
	}






}

