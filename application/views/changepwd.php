<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Change passward</title>
	<?php include 'header.php';
	include 'autologout.php'; ?>
</head>
<body>

<div class="container" style="margin-left:auto; width: 500px ">

	<div class="row">
		<div class="col-4 ">
			<div class="modal-body">
				<form method="post" action="<?php echo base_url(); ?>login_controller/change_pwd">
					<div class="form">
						<hr>
						<span style="color: midnightblue;">
						<center><h1>Password Reset</h1></center>
					</span>
						<br/>

					</div>
					<div class="form-group">
						<label>User Name</label>
						<input type="text" class="form-control" name='username' placeholder="Enter User Name"/>
						<span class="text-danger"><?php echo form_error('username') ?></span>
					</div>
					<div class="form-group">
						<label>New Password</label>
						<input type="password" class="form-control" name='npassword' placeholder="Enter New Passward"/>
						<span class="text-danger"><?php echo form_error('npassword') ?></span>
					</div>
					<div class="form-group">
						<label>Confirm Password</label>
						<input type="password" class="form-control" name='cpassword' placeholder="Re-Enter Passward"/>
						<span class="text-danger"><?php echo form_error('cpassword') ?></span>
					</div>
					<br>
					<center>
						<button type="submit" class="btn btn-primary" name="submit" value="submit">Reset</button>
					</center>

				</form>

				<hr>
				<br>
				<br>
				<br>
				<br>
				<br>

			</div>


		</div>
	</div>
</div>

</div>

<?php include 'footer.php'; ?>
</body>
