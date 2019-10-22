<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class login_controller extends CI_Controller
{

    //------------------------------------------------------------Login page
    public function login_validation()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run()) {

            $username = $this->input->post('username');
            $password = $this->input->post('password');
           // $type = $this->input->post('type');
            //---------------------------
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
							$_SESSION['type']=$row->type;
							$_SESSION['post']=$row->post;
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

    public function login()
    {
        $this->load->view('login');
    }


    public function enter()
    {
        if ($this->session->userdata('username') != '') {
            redirect(base_url() . 'Home/index');
        } else {
            redirect(base_url() . 'login_controller/login');
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('username');
        session_destroy();
        redirect(base_url() . 'login_controller/login');
    }

    /* ---------------------------------------------------------------useless
    public function QAC_Create_validation()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');

        if ($this->form_validation->run()) {
            $this->load->model('user_model');
            $data = array(
                "username" => $this->input->post("username"),
                "password" => $this->input->post("password"),
                "type" => "QAC",
                "email" => $this->input->post("email")
            );
            $this->user_model->insert_data($data);
            ?>
            <script>
                window.location.href = '<?php echo base_url();?>login_controller/manageAccount';
                alert('QAC Account is created');
            </script>
            <?php
            //	redirect(base_url() . 'login_controller/qacinserted');
        } else {
            $this->qacForm();
        }
    }*/

	/*-------------------------------------------------------------useless
	public function qacForm()
	{
		$this->load->view('qacform');
	}*/
/*-------------------------------------------------------------useless
	public function qacinserted()
	{
		$this->qacForm();
	}*/

    //----------------------------------------------------------------------QAC

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
				"post" => $this->input->post("post")
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

    public function userForm()
    {
        $this->load->view('userform');
    }

    //----------------------------------------------------------------------User

    public function admin_account_update_validation()
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
            $this->user_model->update_data($data, $this->input->post("username"));
            redirect(base_url() . "login_controller/manageAccount");
        } else {
            $this->manageAccount();
        }
    }

    public function manageAccount()
    {
		$this->load->model('user_model');
		$data["fetch_data"] = $this->user_model->fetch_accounts();
		$data["fetch_data_user"] = $this->user_model->fetch_accounts_user();
		$data["fetch_data_qac"] = $this->user_model->fetch_accounts_qac();
		$this->load->view('manageaccount', $data);
    }

    //----------------------------------------------------------------------Admin user name and password update

    public function update_users()
    {
        $username = $this->uri->segment(3);
        $this->load->model('user_model');
        $data['user_data'] = $this->user_model->fetch_single_data($username);
        $data["fetch_data"] = $this->user_model->fetch_data();
        $this->load->view('manageaccount', $data);
    }

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
//-----------------------------------------------------------------------------------------
    public function refilter(){
        $this->load->view('searchdata');
    }

    public function filter()
    {
        $_SESSION['account_username']=$this->input->post('username');
        $_SESSION['account_password']=$this->input->post('password');
        $_SESSION['account_type']=$this->input->post('type');
        $_SESSION['account_email']=$this->input->post('email');
		$_SESSION['account_post']=$this->input->post('post');
        $this->load->view('searchdata');
    }
    //------------------------------------------------------------QAC Account Update page

    public function QAC_account_update_validation()
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

            $this->user_model->update_data($data, $this->input->post("username"));
            redirect(base_url() . "login_controller/QACaccountUpdate");

        } else {
            $this->QACaccountUpdate();
        }
    }

    //-----------------------------------------------------------User Account Update page

    public function QACaccountUpdate()
    {
        $username = $this->session->userdata('username');
        $this->load->model('user_model');
        $data['user_data'] = $this->user_model->fetch_single_data($username);
        //$data["fetch_data"] = $this->user_model->fetch_data();
        $this->load->view('QACaccountUpdate', $data);
    }

    //----------------------------------------------------------------------Admin user name and password update

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

    public function delete_data()
    {
        $username = $this->uri->segment(3);
        $this->load->model('user_model');
        if ($username != '') {
            $this->user_model->delete_data($username);
        }
        redirect(base_url() . "login_controller/manageAccount");

    }

//------------------------------------------------------------Sign Up page

    public function sign_validation()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');

        if ($this->form_validation->run()) {
            $this->load->model('user_model');
            $data = array(
                "username" => $this->input->post("username"),
                "password" => $this->input->post("password"),
                "type" => "User",
                "email" => $this->input->post("email")
            );
            $this->user_model->insert_data($data);
            ?>
            <script>
                window.location.href = '<?php echo base_url();?>login_controller/login';
                alert('User Account is created');
            </script>
            <?php
        } else {
            $this->signUp();
        }
    }

    public function signUp()
    {
        $this->load->view('signup');
    }



//--------------------------------------------------------------------------------upload file

    public function do_upload()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');

        $this->form_validation->set_rules('academic_year', 'Academic Year', 'required');
        $this->form_validation->set_rules('subject_code', 'Subject Code', 'required');
        $this->form_validation->set_rules('semester', 'Semester', 'required');
        $this->form_validation->set_rules('year', 'Year', 'required');
        $this->form_validation->set_rules('category', 'Category', 'required');

        if ($this->form_validation->run()) {

            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'pdf';
            $config['max_size'] = '100000';
            $config['overwrite'] = true;
            $config['file_ext_tolower'] = true; // convert extension to lowercase
            $config['remove_spaces'] = true;     // remove replace underscore to spaces in file name


            $this->load->library('upload', $config);

            $this->load->model('user_model');

            if (!$this->upload->do_upload('file_name')) {

                $this->load->model('user_model');
                $data["fetch_data"] = $this->user_model->fetch_cat();
                $this->load->helper(array('form', 'url'));
                $error = array('error' => $this->upload->display_errors());
                $this->load->view('uploadfile', $data, array('error' => $this->upload->display_errors()));

            } else {


                date_default_timezone_set("Asia/Colombo");
                $date_time= date("Y-m-d") . "(" . date("h:i: sa") . ")";


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
                    "comment" => $this->input->post("comment")
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

    public function uploadFile(){
        $this->load->model('user_model');
        $data["fetch_data"] = $this->user_model->fetch_cat();
        $this->load->helper(array('form', 'url'));
        $this->load->view('uploadfile', $data, array('error' => ' '));
    }

    public function editFile(){
		$_SESSION['file_name']= $this->uri->segment(3);
		$this->load->model('user_model');
		$data['user_data'] = $this->user_model->fetch_single_file($this->uri->segment(3));
		$this->load->view('edit',$data);
    }

    public function reopen_editFile(){
		$this->load->model('user_model');
		$data['user_data'] = $this->user_model->fetch_single_file($_SESSION['file_name']);
		$this->load->view('edit',$data);
	}

    public function direct_download(){
		$this->load->helper('download');
		if($this->uri->segment(3)) {
			$data   = file_get_contents('./uploads/'.$this->uri->segment(3));
			$name   = $this->uri->segment(3);
			force_download($name, $data);
		}
	}

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

    function fetch_sub(){

        if($this->input->post('category_name')) {
            $this->load->model('user_model');
            echo $this->user_model->fetch_subject($this->input->post('category_name'));
        }
    }

    public function fetch_sub_year(){
        if($this->input->post('year_name')) {
            $this->load->model('user_model');
            echo $this->user_model->fetch_subject_year($this->input->post('year_name'),$this->input->post('category_name'));
        }
    }

    public function fetch_sub_year_sem(){
        if($this->input->post('semester_name')) {
            $this->load->model('user_model');
            echo $this->user_model->fetch_subject_year_semester($this->input->post('year_name'),$this->input->post('category_name'),$this->input->post('semester_name'));
        }

    }

    public function View_cat_details(){

        $category=$this->input->post("Submit");
        $this->load->model('user_model');
        $_SESSION['x']=$category;
        $data["fetch_data"] = $this->user_model->fetch_data_cat_table($category);
        $this->load->view('viewCategoryDetails',$data);

    }

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
            $this->user_model->update_data_category($Oldname, $data);
            $this->user_model->rename_category($Oldname,$Newname);



            unset($_SESSION['x']);
            $_SESSION['x']=$Newname;
            redirect(base_url() . "login_controller/reopen_View_cat_details");
        } else {
            $this->View_cat_details();
        }

    }

    public function reopen_View_cat_details(){
        $this->load->model('user_model');
        $Newname=$_SESSION['x'];
        $data["fetch_data"] = $this->user_model->fetch_data_cat_table($Newname);
        $this->load->view('viewCategoryDetails',$data);
    }

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

    public function delete_category_dt(){
        $subject = $this->input->post('submit');
        $category = $this->input->post('category');
        $this->load->model('user_model');
        if ($subject != '') {
            $this->user_model->delete_cat_data($subject,$category);
        }
        redirect(base_url() . "login_controller/reopen_View_cat_details");


    }

    public function Update_subject(){
        $_SESSION['year']=$this->input->post('year');
        $_SESSION['semester']=$this->input->post('semester');
        $_SESSION['subject_code']=$this->input->post('subject_code');
        $_SESSION['subject_name']=$this->input->post('subject_name');
        $_SESSION['category']=$this->input->post('category');

        $this->load->view('subject_edit');
    }

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
            $this->user_model->update_category_date($tname,$data,$old_subject_code);
            ?>
            <script>
                alert('A Subject is successfully Updated');
                window.location.href = '<?php echo base_url();?>login_controller/reopen_View_cat_details';
            </script>
            <?php
        }else{
            $this->Update_subject();
        }
    }

    function view_edit_file(){
		$this->load->model('user_model');
		$data['fetch_data'] = $this->user_model->fetch_single_file($_SESSION['file_name']);
		$this->load->view('edit_file',$data);
	}

	//------------------------------------------------------------------------------------------------------------------


	function fetch_sub_update(){

		if($this->input->post('category_name')) {
			$this->load->model('user_model');
			echo $this->user_model->fetch_subject_update($this->input->post('category_name'));
		}
	}

	public function fetch_sub_year_update(){
		if($this->input->post('year_name')) {
			$this->load->model('user_model');
			echo $this->user_model->fetch_subject_year_update($this->input->post('year_name'),$this->input->post('category_name'));
		}
	}

	public function fetch_sub_year_sem_update(){
		if($this->input->post('semester_name')) {
			$this->load->model('user_model');
			echo $this->user_model->fetch_subject_year_semester_update($this->input->post('year_name'),$this->input->post('category_name'),$this->input->post('semester_name'));
		}

	}

	public function Post_Graduate(){
		$this->load->view('postgraduate');
	}

	public function External_Deg(){
		$this->load->view('external_deg');
	}


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



}
