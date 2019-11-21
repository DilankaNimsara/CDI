<?php


class backup extends CI_Controller
{
	public function db_backup()
	{
		$this->load->helper('url');
		$this->load->helper('file');
		$this->load->helper('download');
		$this->load->library('zip');
		$this->load->dbutil();
		$db_format=array('format'=>'zip','filename'=>'mrdoc121.sql');
		$backup=& $this->dbutil->backup($db_format);
		$dbname='mrdoc-'.date('Y-m-d').'.zip';
		$save='./backup/'.$dbname;
		if(write_file($save,$backup)){
			$this->session->set_flashdata('msg1', 'Backup completed');
		}else{
			$this->session->set_flashdata('msg', 'Something went wrong, Try again!');
		}
		redirect(base_url().'Home/BackUp');
//		force_download($dbname,$backup);

	}

}
