<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Login</title>
	<?php include 'header.php';?>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
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
						<span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
						<span class="text-danger"><?php echo form_error('password')?></span>
					</div>
					<div class="form-group form-check">
						<a href="<?php echo base_url()."login_controller/fogotP";?>">Forgot Password?</a>
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

<script>
    $(document).ready(function(){

        $(".toggle-password").click(function() {

            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
    });
</script>


