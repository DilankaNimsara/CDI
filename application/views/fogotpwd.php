<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
	<?php include 'header.php';
	include 'autologout.php'; ?>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
</head>
<body>

<div class="container" style="margin-left:auto; width: 500px ">

	<div class="row">
		<div class="col-4 ">

			<?php
			$alphabet = '1234567890';
			$pass = array();
			$alphaLength = strlen($alphabet) - 1;
			for ($i = 0; $i < 4; $i++) {
				$n = rand(0, $alphaLength);
				$pass[] = $alphabet[$n];
			}
			$pin = implode($pass);

			?>
			<?php
			if ($this->session->flashdata('msg')) {
				?>
				<div class="alert alert-danger">
					<span class="text-danger"> <?php echo $this->session->flashdata('msg'); ?></span>
				</div>
				<?php
			}
			if ($this->session->flashdata('msg1')) {
				?>
				<div class="alert alert-success">
					<span class="text-success"> <?php echo $this->session->flashdata('msg1'); ?></span>
				</div>
				<?php
			}

			if ($this->session->flashdata('msg2')) {
				?>
				<div class="alert alert-danger">
					<span class="text-danger"> <?php echo $this->session->flashdata('msg2'); ?></span>
				</div>
				<?php
			}
			?>


			<div class="form-group">
        <span style="color: midnightblue;">
						<center><h1>Forgot Password</h1></center>
						<hr>
					</span>

				<br>

				<center>
					<form method="post" action="<?php echo base_url(); ?>login_controller/login_pin">
						<label>Enter Email</label>
						<input type="text" class="hidden" name='Rpin' value="<?php echo $pin; ?>">
						<input type="email" class="form-control" name='email' placeholder="Enter Email "
							   style="width:300px;"/>
						<span class="text-danger"><?php echo form_error('email') ?></span>
						<br/>
						<button type="submit" class="btn btn-success btn-lg" name="submit" value="pinsubmit"
								style="width:300px;">Request PIN
						</button>
					</form>
					<br/>

					<!-- <button type="submit" class="btn btn-primary" name="submit" value="submit">Confirm</button></a> -->

					<form method="post" action="<?php echo base_url(); ?>login_controller/check_pin">
						<div class="form-group form-check">
							<input type="password" class="form-control" name='pin' placeholder="Enter Pin"
								   style="width:300px;"/>
							<span class="text-danger"><?php echo form_error('pin') ?></span>
							<br/>
							<button type="submit" class="btn btn-primary" name="submit" value="submit">Confirm</button>
						</div>
					</form>

					<hr>

				</center>


				<?php
				for ($i = 0; $i < 22; $i++) {
					echo '<br/>';
				}
				?>


			</div>
		</div>
	</div>
</div>
<?php include 'footer.php'; ?>
</body>
</html>
