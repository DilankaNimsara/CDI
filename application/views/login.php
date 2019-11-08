<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Login</title>
	<?php include 'header.php';?>
</head>

<body>


<div class="container" style="margin-left:auto; width: 500px ">


	<div class="row">
		<div class="col-4 ">
			<form method="post" action="<?php echo base_url();?>login_controller/login_validation">

				<div class="form">
					<?php
					for($i=0;$i<4;$i++){
						echo '<br/>';
					}
					?>
					<hr>
					<span style="color: midnightblue;" >
						<center><h1>Login</h1></center>
					</span>
					<br/>
					<div class="form-group">
						<label for="username">Username</label>
						<input type="text" class="form-control" id="username" name="username" placeholder="Enter username"/>
						<span class="text-danger"><?php echo form_error('username')?></span>
					</div>
					<div class="form-group">
						<label for="password">Password</label>
						<input type="password" class="form-control" name="password" id="password" placeholder="Enter password"/>
						<span class="text-danger"><?php echo form_error('password')?></span>
					</div>
					<div class="form-group form-check">
						<a href="#">Forgot Password?</a>
					</div>
					<center><button type="submit" class="btn btn-primary" name="submit" value="submit">Login</button></center>
					<hr/>
					<span class="text-danger"> <?php echo $this->session->flashdata("error");?></span>
				</div>
		<?php
			for($i=0;$i<15;$i++){
				echo '<br/>';
			}
		?>
			</form>

		</div>
	</div>

</div>
</body>
<?php include 'footer.php';?>
</html>

