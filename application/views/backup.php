<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Backup</title>
	<?php include 'header.php';
	include 'autologout.php';?>
</head>
<body>

<div class="container-fluid">
	<div class="row content">
		<div class="col-sm-2">
			<?php include 'sidenav.php';?>
		</div>
		<div class="col-sm-10">
			<br/>
			<?php

			if($this->session->flashdata('msg')){
				?>
			<div class="alert alert-danger">
				<span class="text-danger"> <?php echo $this->session->flashdata('msg'); ?></span>
			</div>
			<?php
			}if($this->session->flashdata('msg1')){
			?>
			<div class="alert alert-success">
				<span class="text-success"> <?php echo $this->session->flashdata('msg1'); ?></span>
			</div>
			<?php
			}
			?>
		<form method="post" action="<?php echo base_url().'backup/db_backup';?>">
			<button class="btn btn-primary" name="submit" value="Submit">backup</button>
		</form>







		</div>
	</div>
</div>
<?php include 'footer.php';?>
</body>
</html>

