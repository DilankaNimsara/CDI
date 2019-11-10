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
            $password = $this->input->post('password');
			$this->load->model('user_model');

            if ($this->user_model->can_login($username, $password)) {
                $session_data = array(
                    'username' => $username,
                    'password'=>$password
                );
				$data['fetch_data'] = $this->user_model->userdetails();
				if ($data['fetch_data']->num_rows() > 0) {
					foreach ($data['fetch_data']->result() as $row) {
						if(($username==$row->username)&&($password = $row->password)){
							if($row->course_name){
								$_SESSION['post']=$row->post;
								$_SESSION['type']=$row->type;
								$_SESSION['course_name']=$row->course_name;
							}else{
								$_SESSION['type']=$row->type;
								$_SESSION['post']=$row->post;
								$_SESSION['course_name']='';
							}


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
        redirect(base_url() . 'login_controller/login');
    }

	//----------------------------------------------------------------------user account validation
    public function user_Create_validation()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
		$this->form_validation->set_rules('post', 'Post', 'required');
		$this->form_validation->set_rules('type', 'Type', 'required');

        if ($this->form_validation->run()) {
            $this->load->model('user_model');
            $data = array(
                "username" => $this->input->post("username"),
                "password" => $this->input->post("password"),
                "type" => $this->input->post("type"),
                "email" => $this->input->post("email"),
				"post" => $this->input->post("post"),
				"course_name" =>$this->input->post("course_name")
            );
            $this->user_model->insert_data($data);
            ?>
            <script>
                window.location.href = '<?php echo base_url();?>login_controller/manageAccount';
                alert('User Account is created');
            </script>
            <?php
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
    public function update_and_delete_user_accounts(){
        $this->load->library('form_validation');

        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('email', 'E mail', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('con_password', 'confirm password', 'required|matches[password]');


        if ($this->form_validation->run()) {
            $this->load->model('user_model');

            $data = array(
				"type" => strtolower((str_replace(' ', '_', $this->input->post("type")))),
				"post" => strtolower((str_replace(' ', '_', $this->input->post("post")))),
                "username" => $this->input->post("username"),
                "password" => $this->input->post("password"),
                "email" => $this->input->post("email")
            );
            $this->user_model->update_user_account_data($data, $_SESSION['account_username']);
            redirect(base_url() . "login_controller/manageAccount");

        }else{
            $this->refilter();
        }

    }

	//----------------------------------------------------------------------account delete confirm
    public function delete_conform_account(){

        $this->load->library('form_validation');

        $this->form_validation->set_rules('pw', 'Password', 'required');
        $this->form_validation->set_rules('confirm_pw', 'confirm password', 'required|matches[pw]');
        $pswd=$this->input->post('admin_password');
        $con_psw=$this->input->post('confirm_pw');
        $pwd=$this->input->post('pw');
        if ($this->form_validation->run()) {
            $this->load->model('user_model');
            if(($pwd == $pswd )&&($con_psw==$pswd)){
                $this->user_model->delete_user_account_data($_SESSION['account_username']);
                redirect(base_url() . "login_controller/manageAccount");
            }else{
                $this->refilter();
            }
        }else{
            $this->refilter();
        }
    }

	//----------------------------------------------------------------------re open searchdata.php
    public function refilter(){
        $this->load->view('searchdata');
    }

	//----------------------------------------------------------------------searchdata.php
    public function filter()
    {
        $_SESSION['account_username']=$this->input->post('username');
        $_SESSION['account_password']=$this->input->post('password');
        $_SESSION['account_type']=$this->input->post('type');
        $_SESSION['account_email']=$this->input->post('email');
		$_SESSION['account_post']=$this->input->post('post');
		$_SESSION['report']=$this->input->post('report');
		$_SESSION['course_name']=$this->input->post('course_name');
        $this->load->view('searchdata');
    }

	//----------------------------------------------------------------------account password update

    public function user_account_update_validation()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('conpass', 'confirm password', 'required|matches[password]');

        if ($this->form_validation->run()) {
            $this->load->model('user_model');
            $data = array(
                "username" => $this->input->post("username"),
                "password" => $this->input->post("password"),
                "email" => $this->input->post("email")
            );
			$this->session->unset_userdata('username');

			$this->session->unset_userdata('username');
            $this->user_model->update_data($data, $this->input->post("username"));
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
        //$this->load->helper(array('form', 'url'));
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

				$name1=$this->input->post("category");
				$name2=$this->input->post("year").'y';
				$name3=$this->input->post("semester");
				$name4=$this->input->post("subject_code");
				$name5=$this->input->post("lecturer");
				$name6=$this->input->post("academic_year");


            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'pdf';

            $config['file_name'] =$name1.$name2.$name3.$name4.$name5.$name6;

            $config['overwrite'] = true;
            $config['remove_spaces'] = true;
            $config['file_ext_tolower'] = true; // convert extension to lowercase

            $this->load->library('upload', $config);

            $this->load->model('user_model');

            if (!$this->upload->do_upload('file_name')) {

                $this->load->model('user_model');
                $data["fetch_data"] = $this->user_model->userdetails();
				$this->session->set_flashdata('errorx', $this->upload->display_errors());
                $this->load->view('uploadfile', $data);

            } else {


                date_default_timezone_set("Asia/Colombo");
                $date_time= date("Y-m-d") . " (" . date("h:i:sa") . ")";


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
                ?>
                <script>
                    alert('Your file was successfully uploaded!');
                    window.location.href = '<?php echo base_url();?>login_controller/uploadFile';
                </script>

                <?php
                $this->user_model->insert_file($data);
            }
        } else {
            $this->uploadFile();
        }

    }

	//----------------------------------------------------------------------upload page
    public function uploadFile(){
        $this->load->model('user_model');
        $data["fetch_data"] = $this->user_model->userdetails();
       // $this->load->helper(array('form', 'url'));
        $this->load->view('uploadfile', $data);
    }

	//----------------------------------------------------------------------edit page
    public function editFile(){
		$_SESSION['file_name']= $this->uri->segment(3);
		$this->load->model('user_model');
		$data['user_data'] = $this->user_model->fetch_single_file($this->uri->segment(3));
		$this->load->view('edit',$data);
    }

	//----------------------------------------------------------------------re open edit page
    public function reopen_editFile(){
		$this->load->model('user_model');
		$data['user_data'] = $this->user_model->fetch_single_file($_SESSION['file_name']);
		$this->load->view('edit',$data);
	}

	//----------------------------------------------------------------------download
    public function direct_download(){
		$this->load->helper('download');
		if($this->uri->segment(3)) {
			$data   = file_get_contents('./uploads/'.$this->uri->segment(3));
			$name   = $this->uri->segment(3);
			force_download($name, $data);
		}
	}

	//----------------------------------------------------------------------download
	public function download_file(){
		$this->load->helper('download');
		if($this->input->post("submit")) {
			$data   = file_get_contents('./uploads/'.$this->input->post("submit"));
			$name   = $this->input->post("submit");
			force_download($name, $data);
		}
		if($this->input->post("edit")) {
			redirect(base_url('login_controller/view_edit_file'));
		}
		if($this->input->post("delete")) {
			$path = $_SERVER['DOCUMENT_ROOT'].'/uploads/';
			$this->load->model('user_model');
			$this->user_model->deleteFiles($path, $this->input->post("delete"));

		}
	}

	//----------------------------------------------------------------------document settings page
    public function Document_Settings()
    {
		$this->load->model('user_model');
		$data["fetch_data"] = $this->user_model->fetch_cat();
        $this->load->view('DocumentSettings',$data);
    }
    public function insertCat()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('category', 'Category', 'required');

        if ($this->form_validation->run()) {

            $cat=strtolower($this->input->post('category'));
            $name=str_replace(' ', '_', $cat);

            $this->load->model('user_model');
            $data = array(
                "id" => rand(0, 100),
                "category" => $name
            );
            ?>
            <script>
                alert('One category is successfully inserted');
                window.location.href = '<?php echo base_url();?>login_controller/Document_Settings';
            </script>

            <?php

            $name=str_replace(' ', '_', $this->input->post("category"));

            $this->user_model->insert_cat($data);
            $this->load->model('user_model');
            $this->user_model->create_tables($name);

        }else{
            $this->Document_Settings();
        }
    }

	//----------------------------------------------------------------------delete category(under graduate)
    public function delete_cat()
    {
        $category=$_SESSION['x'];
        $name=str_replace(' ', '_', $category);
        $this->load->model('user_model');
        if ($category != '') {
            $this->user_model->delete_cat($category);
            $this->user_model->delete_tables($name);
        }
        redirect(base_url('login_controller/Document_Settings'));
    }

	//----------------------------------------------------------------------delete category(post graduate)
	public function delete_cat_postgraduate()
	{
		$category=$_SESSION['pg'];
		$name=str_replace(' ', '_', $category);
		$this->load->model('user_model');
		if ($category != '') {
			$this->user_model->delete_cat_postgraduate($category);
			$this->user_model->delete_tables($name);
		}
		redirect(base_url('login_controller/Post_Graduate'));
	}

	//----------------------------------------------------------------------delete category(external degree)
	public function delete_cat_external()
	{
		$category=$_SESSION['ext'];
		$name=str_replace(' ', '_', $category);
		$this->load->model('user_model');
		if ($category != '') {
			$this->user_model->delete_cat_external($category);
			$this->user_model->delete_tables($name);
		}
		redirect(base_url('login_controller/external_deg'));
	}

	//----------------------------------------------------------------------add subjects
    public function add_subject(){

        $this->load->library('form_validation');
        $this->form_validation->set_rules('category', 'category', 'required');
        $this->form_validation->set_rules('subject_name', 'Subject Name', 'required');
        $this->form_validation->set_rules('subject_code', 'Subject Code', 'required');
        $this->form_validation->set_rules('year', 'Year', 'required');
        $this->form_validation->set_rules('semester', 'Semester', 'required');

        if ($this->form_validation->run()) {
            $tname=strtolower($this->input->post('category'));
            $subject_code=strtoupper($this->input->post("subject_code"));
            $this->load->model('user_model');
            $data = array(
                "subject_code" => $subject_code,
                "subject_name" => $this->input->post("subject_name"),
                "year" => $this->input->post("year"),
                "semester" => $this->input->post("semester")
            );
            $this->user_model->insertdata($tname,$data);
            ?>
            <script>
                alert('One Subject is successfully inserted');
                window.location.href = '<?php echo base_url();?>login_controller/Document_Settings';
            </script>
            <?php
        }else{
            $this->Document_Settings();
        }
    }

	//----------------------------------------------------------------------get subjects for drop down
    function fetch_sub(){

        if($this->input->post('category_name')) {
            $this->load->model('user_model');
            echo $this->user_model->fetch_subject($this->input->post('category_name'));
        }
    }

	//----------------------------------------------------------------------get subjects for drop down
    public function fetch_sub_year(){
        if($this->input->post('year_name')) {
            $this->load->model('user_model');
            echo $this->user_model->fetch_subject_year($this->input->post('year_name'),$this->input->post('category_name'));
        }
    }

	//----------------------------------------------------------------------get subjects for drop down
    public function fetch_sub_year_sem(){
        if($this->input->post('semester_name')) {
            $this->load->model('user_model');
            echo $this->user_model->fetch_subject_year_semester($this->input->post('year_name'),$this->input->post('category_name'),$this->input->post('semester_name'));
        }

    }

	//----------------------------------------------------------------------view category details(under graduate)
    public function View_cat_details(){

        $category=$this->input->post("Submit");
        $this->load->model('user_model');
        $_SESSION['x']=$category;
        $data["fetch_data"] = $this->user_model->fetch_data_cat_table($category);
        $this->load->view('viewCategoryDetails',$data);

    }

	//----------------------------------------------------------------------view category details(post graduate)
	public function View_cat_details_post_graduate(){

		$category=$this->input->post("Submit");
		$this->load->model('user_model');
		$_SESSION['pg']=$category;
		$data["fetch_data"] = $this->user_model->fetch_data_cat_table($category);
		$this->load->view('ViewCategoryDetailsPostGraduate',$data);

	}

	//----------------------------------------------------------------------view category details(external degree)
	public function View_cat_details_External(){
		$category=$this->input->post("Submit");
		$this->load->model('user_model');
		$_SESSION['ext']=$category;
		$data["fetch_data"] = $this->user_model->fetch_data_cat_table($category);
		$this->load->view('ViewCategoryDetailsExternal',$data);
	}

	//----------------------------------------------------------------------update category details(under graduate)
    public function category_update(){

        $this->load->library('form_validation');
        $this->form_validation->set_rules('category', 'category', 'required');

        $oldcat=str_replace(' ', '_', $this->input->post('hide'));
        $Oldname=strtolower($oldcat);
        $cat=str_replace(' ', '_', $this->input->post('category'));
        $Newname=strtolower($cat);

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
            $this->user_model->rename_category($Oldname,$Newname);

            unset($_SESSION['x']);
            $_SESSION['x']=$Newname;
            redirect(base_url() . "login_controller/reopen_View_cat_details");
        } else {
            $this->View_cat_details();
        }

    }

	//----------------------------------------------------------------------update category details(post graduate)
	public function category_update_postgraduate(){

		$this->load->library('form_validation');
		$this->form_validation->set_rules('category', 'category', 'required');

		$oldcat=str_replace(' ', '_', $this->input->post('hide'));
		$Oldname=strtolower($oldcat);
		$cat=str_replace(' ', '_', $this->input->post('category'));
		$Newname=strtolower($cat);

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
			$this->user_model->rename_category($Oldname,$Newname);

			unset($_SESSION['pg']);
			$_SESSION['pg']=$Newname;
			redirect(base_url() . "login_controller/reopen_View_cat_details_post_graduate");
		} else {
			$this->View_cat_details_post_graduate();
		}

	}

	//----------------------------------------------------------------------update category details(external degree)
	public function category_update_external(){

		$this->load->library('form_validation');
		$this->form_validation->set_rules('category', 'category', 'required');

		$oldcat=str_replace(' ', '_', $this->input->post('hide'));
		$Oldname=strtolower($oldcat);
		$cat=str_replace(' ', '_', $this->input->post('category'));
		$Newname=strtolower($cat);

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
			$this->user_model->rename_category($Oldname,$Newname);

			unset($_SESSION['ext']);
			$_SESSION['ext']=$Newname;
			redirect(base_url() . "login_controller/reopen_View_cat_details_external");
		} else {
			$this->reopen_View_cat_details_external();
		}

	}

	//----------------------------------------------------------------------re open category details(under graduate)
	public function reopen_View_cat_details(){
        $this->load->model('user_model');
        $Newname=$_SESSION['x'];
        $data["fetch_data"] = $this->user_model->fetch_data_cat_table($Newname);
        $this->load->view('viewCategoryDetails',$data);
    }

	//----------------------------------------------------------------------re open category details(post graduate)
	public function reopen_View_cat_details_post_graduate(){
		$this->load->model('user_model');
		$Newname=$_SESSION['pg'];
		$data["fetch_data"] = $this->user_model->fetch_data_cat_table($Newname);
		$this->load->view('ViewCategoryDetailsPostGraduate',$data);
	}

	//----------------------------------------------------------------------re open category details(external degree)
	public function reopen_View_cat_details_external(){
		$this->load->model('user_model');
		$Newname=$_SESSION['ext'];
		$data["fetch_data"] = $this->user_model->fetch_data_cat_table($Newname);
		$this->load->view('ViewCategoryDetailsExternal',$data);
	}

	//----------------------------------------------------------------------add subjects(under graduate)
    public function add_subjects_cat(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('subject_name', 'Subject Name', 'required');
        $this->form_validation->set_rules('subject_code', 'Subject Code', 'required');
        $this->form_validation->set_rules('year', 'Year', 'required');
        $this->form_validation->set_rules('semester', 'Semester', 'required');

        if ($this->form_validation->run()) {
            $tname=strtolower($this->input->post('category'));
            $subject_code=strtoupper($this->input->post("subject_code"));
            $this->load->model('user_model');
            $data = array(
                "subject_code" => $subject_code,
                "subject_name" => $this->input->post("subject_name"),
                "year" => $this->input->post("year"),
                "semester" => $this->input->post("semester")
            );
            $this->user_model->insertdata($tname,$data);
            ?>

            <script>
                alert('One Subject is successfully inserted');
                window.location.href = '<?php echo base_url();?>login_controller/reopen_View_cat_details';
            </script>
            <?php
        }else{
            $this->reopen_View_cat_details();
        }

    }

	//----------------------------------------------------------------------add subjects(post graduate)
	public function add_subjects_cat_post_graduate(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('subject_name', 'Subject Name', 'required');
		$this->form_validation->set_rules('subject_code', 'Subject Code', 'required');
		$this->form_validation->set_rules('year', 'Year', 'required');
		$this->form_validation->set_rules('semester', 'Semester', 'required');

		if ($this->form_validation->run()) {
			$tname=strtolower($this->input->post('category'));
			$subject_code=strtoupper($this->input->post("subject_code"));
			$this->load->model('user_model');
			$data = array(
				"subject_code" => $subject_code,
				"subject_name" => $this->input->post("subject_name"),
				"year" => $this->input->post("year"),
				"semester" => $this->input->post("semester")
			);
			$this->user_model->insertdata($tname,$data);
			?>

			<script>
                alert('One Subject is successfully inserted');
                window.location.href = '<?php echo base_url();?>login_controller/reopen_View_cat_details_post_graduate';
			</script>
			<?php
		}else{
			$this->reopen_View_cat_details_post_graduate();
		}
	}

	//----------------------------------------------------------------------add subjects(external degree)
	public function add_subjects_cat_external(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('subject_name', 'Subject Name', 'required');
		$this->form_validation->set_rules('subject_code', 'Subject Code', 'required');
		$this->form_validation->set_rules('year', 'Year', 'required');
		$this->form_validation->set_rules('semester', 'Semester', 'required');

		if ($this->form_validation->run()) {
			$tname=strtolower($this->input->post('category'));
			$subject_code=strtoupper($this->input->post("subject_code"));
			$this->load->model('user_model');
			$data = array(
				"subject_code" => $subject_code,
				"subject_name" => $this->input->post("subject_name"),
				"year" => $this->input->post("year"),
				"semester" => $this->input->post("semester")
			);
			$this->user_model->insertdata($tname,$data);
			?>

			<script>
                alert('One Subject is successfully inserted');
                window.location.href = '<?php echo base_url();?>login_controller/reopen_View_cat_details_external';
			</script>
			<?php
		}else{
			$this->reopen_View_cat_details_external();
		}
	}

	//----------------------------------------------------------------------delete category(under graduate)
    public function delete_category_dt(){
        $subject = $this->input->post('submit');
        $category = $this->input->post('category');
        $this->load->model('user_model');
        if ($subject != '') {
            $this->user_model->delete_cat_data($subject,$category);
        }
        redirect(base_url() . "login_controller/reopen_View_cat_details");
    }

	//----------------------------------------------------------------------delete category(post graduate)
	public function delete_category_dt_postgraduate(){
		$subject = $this->input->post('submit');
		$category = $this->input->post('category');
		$this->load->model('user_model');
		if ($subject != '') {
			$this->user_model->delete_cat_data($subject,$category);
		}
		redirect(base_url() . "login_controller/reopen_View_cat_details_post_graduate");
	}

	//----------------------------------------------------------------------delete category(external degree)
	public function delete_category_dt_external(){
		$subject = $this->input->post('submit');
		$category = $this->input->post('category');
		$this->load->model('user_model');
		if ($subject != '') {
			$this->user_model->delete_cat_data($subject,$category);
		}
		redirect(base_url() . "login_controller/reopen_View_cat_details_external");
	}

	//----------------------------------------------------------------------update subjects
    public function Update_subject(){
        $_SESSION['year']=$this->input->post('year');
        $_SESSION['semester']=$this->input->post('semester');
        $_SESSION['subject_code']=$this->input->post('subject_code');
        $_SESSION['subject_name']=$this->input->post('subject_name');
        $_SESSION['category']=$this->input->post('category');
		$_SESSION['accounttype']=$this->input->post('type');

        $this->load->view('subject_edit');
    }

	//----------------------------------------------------------------------update subjects(post,under,external)
    public function update_subjects_cat(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('subject_name', 'Subject Name', 'required');
        $this->form_validation->set_rules('subject_code', 'Subject Code', 'required');
        $this->form_validation->set_rules('year', 'Year', 'required');
        $this->form_validation->set_rules('semester', 'Semester', 'required');

        if ($this->form_validation->run()) {

            $tname=$_SESSION['category'];

            $old_subject_code=$this->input->post("hide");
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
			$this->user_model->update_category_date($tname,$data,$old_subject_code);

            $this->user_model->update_category_fileupload($data2,$old_subject_code);

			if($_SESSION['accounttype']=="postgraduate"){
				redirect(base_url('login_controller/reopen_View_cat_details_post_graduate'));
			}elseif($_SESSION['accounttype']=="external_deg"){
				redirect(base_url('login_controller/reopen_View_cat_details_external'));
			}else{
				?>
				<script>
                    alert('A Subject is successfully Updated');
                    window.location.href = '<?php echo base_url();?>login_controller/reopen_View_cat_details';
				</script>
				<?php
			}
        }else{
            $this->Update_subject();
        }
    }
	//---------------------------------------------------------------------- edit file page
    function view_edit_file(){
		$this->load->model('user_model');
		$data['fetch_data'] = $this->user_model->fetch_single_file($_SESSION['file_name']);
		$this->load->view('edit_file',$data);
	}

	//----------------------------------------------------------------------dropdown
	function fetch_sub_update(){

		if($this->input->post('category_name')) {
			$this->load->model('user_model');
			echo $this->user_model->fetch_subject_update($this->input->post('category_name'));
		}
	}

	//----------------------------------------------------------------------dropdown
	public function fetch_sub_year_update(){
		if($this->input->post('year_name')) {
			$this->load->model('user_model');
			echo $this->user_model->fetch_subject_year_update($this->input->post('year_name'),$this->input->post('category_name'));
		}
	}

	//----------------------------------------------------------------------dropdown
	public function fetch_sub_year_sem_update(){
		if($this->input->post('semester_name')) {
			$this->load->model('user_model');
			echo $this->user_model->fetch_subject_year_semester_update($this->input->post('year_name'),$this->input->post('category_name'),$this->input->post('semester_name'));
		}

	}

	//----------------------------------------------------------------------post graduate page
	public function Post_Graduate(){
		$this->load->model('user_model');
		$data["fetch_data"] = $this->user_model->fetch_cat_postgraduate();
		$this->load->view('postgraduate',$data);
	}

	//----------------------------------------------------------------------external degree page
	public function External_Deg(){
		$this->load->model('user_model');
		$data["fetch_data"] = $this->user_model->fetch_cat_External();
		$this->load->view('external_deg',$data);
	}

	//----------------------------------------------------------------------insert category(external degree)
	public function insertExternal()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('category', 'Category', 'required');

		if ($this->form_validation->run()) {

			$cat=strtolower($this->input->post('category'));
			$name=str_replace(' ', '_', $cat);

			$this->load->model('user_model');
			$data = array(
				"id" => rand(0, 100),
				"category" => $name
			);
			?>
			<script>
                alert('One category is successfully inserted');
                window.location.href = '<?php echo base_url();?>login_controller/external_deg';
			</script>

			<?php

			$name=str_replace(' ', '_', $this->input->post("category"));

			$this->user_model->insert_external($data);
			$this->load->model('user_model');
			$this->user_model->create_tables($name);

		}else{
			$this->external_deg();
		}
	}

	//----------------------------------------------------------------------insert category(post graduate)
	public function insertPostgraduate()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('category', 'Category', 'required');

		if ($this->form_validation->run()) {

			$cat=strtolower($this->input->post('category'));
			$name=str_replace(' ', '_', $cat);

			$this->load->model('user_model');
			$data = array(
				"id" => rand(0, 100),
				"category" => $name
			);
			?>
			<script>
                alert('One category is successfully inserted');
                window.location.href = '<?php echo base_url();?>login_controller/Post_Graduate';
			</script>

			<?php

			$name=str_replace(' ', '_', $this->input->post("category"));

			$this->user_model->insert_postgraduate($data);
			$this->load->model('user_model');
			$this->user_model->create_tables($name);


		}else{
			$this->Post_Graduate();
		}
	}

	//----------------------------------------------------------------------report page
	public function Report(){
		$this->load->model('user_model');
		$data["count_data"] = $this->user_model->userdetails();
    	$this->load->view('report',$data);
	}

	public function fetch_category_TYPE(){
		if($this->input->post('account_type')) {
			$this->load->model('user_model');
			echo $this->user_model->fetch_category_type($this->input->post('account_type'));
		}
	}

	public function update_post(){
		$this->load->library('form_validation');

		$this->form_validation->set_rules('type', 'type', 'required');
		$this->form_validation->set_rules('post', 'post', 'required');

		if ($this->form_validation->run()) {
			$this->load->model('user_model');

			if($this->input->post('post')!='course_coordinator'){
				$data = array(
					"type" => strtolower((str_replace(' ', '_', $this->input->post("type")))),
					"post" => strtolower((str_replace(' ', '_', $this->input->post("post")))),
					"course_name" => ' '
				);
				$this->user_model->update_TYPE($data, $this->input->post("username"));
			}else{
				$data = array(
					"type" => strtolower((str_replace(' ', '_', $this->input->post("type")))),
					"post" => strtolower((str_replace(' ', '_', $this->input->post("post"))))
				);
				$this->user_model->update_TYPE($data, $this->input->post("username"));
			}

			$_SESSION['account_username']=$this->input->post('username');
			$_SESSION['account_email']=$this->input->post('email');
			$_SESSION['account_post']=strtolower((str_replace(' ', '_', $this->input->post("post"))));
			$_SESSION['account_type']=strtolower((str_replace(' ', '_', $this->input->post("type"))));

			redirect(base_url() . "login_controller/refilter");
		}else{
			$_SESSION['account_username']=$this->input->post('username');
			$_SESSION['account_email']=$this->input->post('email');
			$_SESSION['account_post']=strtolower((str_replace(' ', '_', $this->input->post("post"))));
			$_SESSION['account_type']=strtolower((str_replace(' ', '_', $this->input->post("type"))));
			$this->refilter();
		}

	}

	public function update_course(){
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

			$_SESSION['account_username']=$this->input->post('username');
			$_SESSION['account_email']=$this->input->post('email');
			$_SESSION['account_type']=strtolower((str_replace(' ', '_', $this->input->post("type"))));
			$_SESSION['course_name']=strtolower((str_replace(' ', '_', $this->input->post("course_name"))));
			redirect(base_url() . "login_controller/refilter");
		}else{
			$_SESSION['account_username']=$this->input->post('username');
			$_SESSION['account_email']=$this->input->post('email');
			$_SESSION['course_name']=strtolower((str_replace(' ', '_', $this->input->post("course_name"))));
			$_SESSION['account_type']=strtolower((str_replace(' ', '_', $this->input->post("type"))));
			$this->refilter();
		}

	}











}
