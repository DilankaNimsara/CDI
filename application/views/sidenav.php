<?php

$actual_link = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
$url= basename($actual_link);

?>

<nav>

	<div class="row content">
		<div class="sidenav hidden-xs">
			<h2 style="color: mediumturquoise;"><span class="glyphicon glyphicon-menu-hamburger"></span> Menu</h2>
			<ul class="nav nav-pills nav-stacked">
				<li class="<?php if($url == "index"){echo 'active';} ?>"><a href="<?php echo base_url('Home/index')?>"><span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-home"></span> Home</a></li>
				<li class="<?php if($url == "viewDocument" || $url =='view_edit_file'){echo 'active';} ?>"><a href="<?php echo base_url('Home/viewDocument')?>">View Document <span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-search"></span></a></li>

				<?php
				if(($this->session->userdata('type')=='qac')) {
					?>
					<li class="<?php if ($url == "uploadFile" || $url == "do_upload") {
						echo 'active';
					} ?>"><a href="<?php echo base_url(); ?>login_controller/uploadFile"> Upload Document<span
								style="font-size:16px;"
								class="pull-right hidden-xs showopacity glyphicon glyphicon-upload"></span></a></li>
					<?php
				}
				?>

				<?php
				if(($this->session->userdata('type')=='qac')||($this->session->userdata('type')=='head_of_institute')){
				?>
					<li class="<?php if($url == "manageAccount" ||$url == "user_Create_validation"){
						echo 'active';
					}elseif ($url == "userForm"){
						echo 'active';
					}
					?>"><a href="<?php echo base_url();?>login_controller/manageAccount">Manage Accounts<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-cog"></span></a>
					</li>
					<?php
					if($this->session->userdata('type')!='head_of_institute'){
						?>
						<li class="<?php if($url == "reopen_View_cat_details_post_graduate" ||
							$url == "View_cat_details_post_graduate" ||
							$url == "reopen_View_cat_details_external" ||
							$url == "View_cat_details_External" ||
							$url == "Document_Settings" ||
							$url == "add_subject"||
							$url == "View_cat_details" ||
							$url == "insertCat" ||
							$url == 'reopen_View_cat_details'||
							$url == 'Post_Graduate'||
							$url == 'External_Deg'){echo 'active';} ?>"><a href="<?php echo base_url()?>login_controller/Document_Settings"><span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-book"></span> Document Settings</a></li>
						<?php
					}?>
					<li class="<?php if($url == "Report"){echo 'active';} ?>"><a href="<?php echo base_url();?>login_controller/Report"><span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-folder-open"></span>Report (Posts) </a></li>

					<?php
				}
				?>
				<li class="<?php if($url == "useraccountupdate"){echo 'active';} ?>"><a href="<?php echo base_url();?>login_controller/useraccountupdate"><span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-wrench"></span>My profile</a></li>

			</ul><br>

		</div>
</div>

</nav>
