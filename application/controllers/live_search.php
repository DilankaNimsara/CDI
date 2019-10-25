<?php

class live_search extends CI_Controller{


    function manageAccount(){
        $output = '';
        $query = '';
        $this->load->model('user_model');
        if ($this->input->post('query')) {
            $query = $this->input->post('query');
        }
        $data = $this->user_model->fetch_data($query);
        $output .= '
  <div class="table-responsive">
     <table class="table table-hover">
      <tr bgcolor="white">
       <th>User Name</th>
       <th>Password</th>
       <th>Account type</th>
       <th>E-mail</th>
        <th>Post</th>
       <th>Edit / Delete</th>
      </tr>
  ';
        if ($data->num_rows() > 0) {
            foreach ($data->result() as $row) {

                $output .= '

      <tr>
      
       <td bgcolor="5CA9F5">' . $row->username . '</td>
       <td>' . $row->password . '</td>
       <td>' .str_replace('_', ' ', $row->type ). '</td>
       <td>' . $row->email . '</td>
       <td>' .str_replace('_', ' ',strtoupper( $row->post)) . '</td>
       <td>
           <form method="post" action="'. base_url('login_controller/filter').'">
                <button class="btn btn-info" name="submit" value="Submit">View</button>
                <input type="text" name="username" value="' . $row->username . '" class="hide">
                <input type="text" name="password" value="' . $row->password . '" class="hide">
                <input type="text" name="type" value="' . $row->type . '" class="hide">
                <input type="text" name="email" value="' . $row->email . '" class="hide">
                 <input type="text" name="post" value="' . $row->post . '" class="hide">
           </form>
       </td>
      </tr>
    ';
            }
        } else {
            $output .= '<tr>
       <td colspan="9">No Data Found</td>
      </tr>';
        }
        $output .= '</table>';
        echo $output;
    }

    public function fetchCategory()
    {
        $output = '';
        $query = '';
        $this->load->model('user_model');
        if ($this->input->post('query')) {
            $query = $this->input->post('query');
        }
        $data = $this->user_model->fetch_category($query);
        $output .= '
  <div class="table-responsive">
     <table class="table table-hover">
      <tr bgcolor="white">
       <th>Category</th>
       <th align="center">View / Details / Edit</th>
      </tr>
  ';
        if ($data->num_rows() > 0) {
            foreach ($data->result() as $row) {
                $output .= '
      <tr>
       <td>' .strtoupper($name=str_replace('_', ' ', $row->category) ). '</td>
       <td align="center">
        <form method="post" action="'.base_url("login_controller/View_cat_details").'">
            <button class="btn btn-info" style="width: 80px;" type="submit" name="Submit" id="' . $row->category . '" value="' . $row->category . '"> View </a></button>
        </form>
       </td>
      </tr>
    ';
            }
        } else {
            $output .= '<tr>
       <td colspan="2">No Data Found</td>
      </tr>';
        }
        $output .= '</table>';
        echo $output;
    }

    public function fetchDoc()
    {
        $output = '';
        $query = '';
        $this->load->model('user_model');
        if ($this->input->post('query')) {
            $query = $this->input->post('query');
        }
        $data = $this->user_model->fetch_doc($query);
        $output .= '
  <div class="table-responsive">
     <table class="table table-hover">
      <tr bgcolor="white">
      <th>Download</th>
       <th>File Name (View)</th>
       <th>Date Created</th>
       <th>Category</th>
       <th>Year</th>
       <th>Semester</th>
       <th>Academic year</th>
       <th>Subject Code</th>
       <th>Author</th>
       <th>Comment</th>
      </tr>
  ';
        if ($data->num_rows() > 0) {
            foreach ($data->result() as $row) {
                $output .= '
      <tr>
       <td><a href="'. base_url("login_controller/direct_download/". $row->file_name) .'"><center><span style="color: #0b0b0b;" class="glyphicon glyphicon-download-alt"></span></center></a></td>
       <td><a href="'. base_url("login_controller/editFile/". $row->file_name) .'">' . $row->file_name . '</a></td>
       <td>' . $row->date_created . '</td>
       <td>' . $row->category . '</td>
       <td>' . $row->year . '</td>
       <td>' . $row->semester . '</td>
       <td>' . $row->academic_year . '</td>
       <td>' . $row->subject_code . '</td>
       <td>' . $row->author . '</td>
       <td>' . $row->comment . '</td>
      </tr>
    ';
            }
        } else {
            $output .= '<tr>
       <td colspan="9">No Data Found</td>
      </tr>';
        }
        $output .= '</table>';
        echo $output;
    }

    function fetchsubject(){
        $output = '';
        $query = '';
        $this->load->model('user_model');
        if ($this->input->post('query')) {
            $query = $this->input->post('query');
        }
        $data = $this->user_model->fetch_subject_cat($query);
        $output .= '
  <div class="table-responsive">
     <table class="table table-hover">
      <tr bgcolor="white">
       <th>Year</th>
       <th>Semester</th>
       <th>Subject Code</th>
       <th>Subject Name</th>
       <th>Edit</th>
       <th>Delete</th>
      </tr>
  ';
        if ($data->num_rows() > 0) {
            foreach ($data->result() as $row) {

                $output .= '

      <tr>
      
       <td bgcolor="5CA9F5">' . $row->year . '</td>
       <td>' . $row->semester . '</td>
       <td>' . $row->subject_code . '</td>
       <td>' . $row->subject_name . '</td>
       <td>
           <form method="post" action="'. base_url('login_controller/Update_subject').'">
                <button class="btn btn-info" name="submit" value="Submit">Edit</button>
                <input type="text" class="hide" name="year" value="' . $row->year . '">
                <input type="text" class="hide" name="semester" value="' . $row->semester . '">
                <input type="text" class="hide" name="subject_code" value="' . $row->subject_code . '">
                <input type="text" class="hide" name="subject_name" value="' . $row->subject_name . '">
                <input type="text" class="hide" name="category" value="' . $_SESSION['x'] . '">
           </form>
       </td>
       <td>
         <form method="post" action="'.base_url('login_controller/delete_category_dt').'">
            <button class="btn btn-danger" name="submit" value="' . $row->subject_code . '">Delete</button>
            <input type="text" class="hide" value="'.$_SESSION['x'].'" name="category">
         </form>
       </td>
      </tr>
    ';
            }
        } else {
            $output .= '<tr>
       <td colspan="9">No Data Found</td>
      </tr>';
        }
        $output .= '</table>';
        echo $output;
    }
	function fetchsubject_post_graduate(){
		$output = '';
		$query = '';
		$this->load->model('user_model');
		if ($this->input->post('query')) {
			$query = $this->input->post('query');
		}
		$data = $this->user_model->fetch_subject_cat_post_graduate($query);
		$output .= '
  <div class="table-responsive">
     <table class="table table-hover">
      <tr bgcolor="white">
       <th>Year</th>
       <th>Semester</th>
       <th>Subject Code</th>
       <th>Subject Name</th>
       <th>Edit</th>
       <th>Delete</th>
      </tr>
  ';
		if ($data->num_rows() > 0) {
			foreach ($data->result() as $row) {

				$output .= '

      <tr>
      
       <td bgcolor="5CA9F5">' . $row->year . '</td>
       <td>' . $row->semester . '</td>
       <td>' . $row->subject_code . '</td>
       <td>' . $row->subject_name . '</td>
       <td>
           <form method="post" action="'. base_url('login_controller/Update_subject').'">
                <button class="btn btn-info" name="submit" value="Submit">Edit</button>
                <input type="text" class="hide" name="year" value="' . $row->year . '">
                <input type="text" class="hide" name="semester" value="' . $row->semester . '">
                <input type="text" class="hide" name="subject_code" value="' . $row->subject_code . '">
                <input type="text" class="hide" name="subject_name" value="' . $row->subject_name . '">
                <input type="text" class="hide" name="category" value="' . $_SESSION['pg'] . '">
                <input type="text" class="hide" name="type" value="postgraduate">
           </form>
       </td>
       <td>
         <form method="post" action="'.base_url('login_controller/delete_category_dt_postgraduate').'">
            <button class="btn btn-danger" name="submit" value="' . $row->subject_code . '">Delete</button>
            <input type="text" class="hide" value="'.$_SESSION['pg'].'" name="category">
         </form>
       </td>
      </tr>
    ';
			}
		} else {
			$output .= '<tr>
       <td colspan="9">No Data Found</td>
      </tr>';
		}
		$output .= '</table>';
		echo $output;
	}

	function fetchsubject_External(){
		$output = '';
		$query = '';
		$this->load->model('user_model');
		if ($this->input->post('query')) {
			$query = $this->input->post('query');
		}
		$data = $this->user_model->fetch_subject_cat_external($query);
		$output .= '
  <div class="table-responsive">
     <table class="table table-hover">
      <tr bgcolor="white">
       <th>Year</th>
       <th>Semester</th>
       <th>Subject Code</th>
       <th>Subject Name</th>
       <th>Edit</th>
       <th>Delete</th>
      </tr>
  ';
		if ($data->num_rows() > 0) {
			foreach ($data->result() as $row) {

				$output .= '

      <tr>
      
       <td bgcolor="5CA9F5">' . $row->year . '</td>
       <td>' . $row->semester . '</td>
       <td>' . $row->subject_code . '</td>
       <td>' . $row->subject_name . '</td>
       <td>
           <form method="post" action="'. base_url('login_controller/#').'">
                <button class="btn btn-info" name="submit" value="Submit">Edit</button>
                <input type="text" class="hide" name="year" value="' . $row->year . '">
                <input type="text" class="hide" name="semester" value="' . $row->semester . '">
                <input type="text" class="hide" name="subject_code" value="' . $row->subject_code . '">
                <input type="text" class="hide" name="subject_name" value="' . $row->subject_name . '">
                <input type="text" class="hide" name="category" value="' . $_SESSION['ext'] . '">
                <input type="text" class="hide" name="type" value="external_deg">
           </form>
       </td>
       <td>
         <form method="post" action="'.base_url('login_controller/#').'">
            <button class="btn btn-danger" name="submit" value="' . $row->subject_code . '">Delete</button>
            <input type="text" class="hide" value="'.$_SESSION['ext'].'" name="category">
         </form>
       </td>
      </tr>
    ';
			}
		} else {
			$output .= '<tr>
       <td colspan="9">No Data Found</td>
      </tr>';
		}
		$output .= '</table>';
		echo $output;
	}



	function Fetch_Postgraduate()
	{
		$output = '';
		$query = '';
		$this->load->model('user_model');
		if ($this->input->post('query')) {
			$query = $this->input->post('query');
		}
		$data = $this->user_model->fetch_post_graduate($query);
		$output .= '
  <div class="table-responsive">
     <table class="table table-hover">
      <tr bgcolor="white">
       <th>Category</th>
       <th align="center">View / Details / Edit</th>
      </tr>
  ';
		if ($data->num_rows() > 0) {
			foreach ($data->result() as $row) {
				$output .= '
      <tr>
       <td>' . strtoupper($name = str_replace('_', ' ', $row->category)) . '</td>
       <td align="center">
        <form method="post" action="' . base_url("login_controller/View_cat_details_post_graduate") . '">
            <button class="btn btn-info" style="width: 80px;" type="submit" name="Submit" id="' . $row->category . '" value="' . $row->category . '"> View </a></button>
        </form>
       </td>
      </tr>
    ';
			}
		} else {
			$output .= '<tr>
       <td colspan="2">No Data Found</td>
      </tr>';
		}
		$output .= '</table>';
		echo $output;
	}


	function Fetch_External()
	{
		$output = '';
		$query = '';
		$this->load->model('user_model');
		if ($this->input->post('query')) {
			$query = $this->input->post('query');
		}
		$data = $this->user_model->fetch_external($query);
		$output .= '
  <div class="table-responsive">
     <table class="table table-hover">
      <tr bgcolor="white">
       <th>Category</th>
       <th align="center">View / Details / Edit</th>
      </tr>
  ';
		if ($data->num_rows() > 0) {
			foreach ($data->result() as $row) {
				$output .= '
      <tr>
       <td>' . strtoupper($name = str_replace('_', ' ', $row->category)) . '</td>
       <td align="center">
        <form method="post" action="' . base_url("login_controller/View_cat_details_External") . '">
            <button class="btn btn-info" style="width: 80px;" type="submit" name="Submit" id="' . $row->category . '" value="' . $row->category . '"> View </a></button>
        </form>
       </td>
      </tr>
    ';
			}
		} else {
			$output .= '<tr>
       <td colspan="2">No Data Found</td>
      </tr>';
		}
		$output .= '</table>';
		echo $output;
	}
















}


