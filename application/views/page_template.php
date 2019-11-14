<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title></title>
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


			<?php

			$_SESSION['subject']='MrDoc signed up';
			$_SESSION['tomail']= $this->input->post("email");
			$_SESSION['body']='<center>Your MrDoc account successfully created. </br> Click hear to login "http://localhost/CDI/" <br/> 
			your password : '.$this->input->post("password").' and username :' .$this->input->post("username").' <br/> use this password for login. then you can change it.<br/>
			 <br/>
			 <br/>
			 <br/>
			 Thank you!<br/>
			 &copy; Copyright - MrDoc<br/>
			 2019
			 </center>';
			?>








		</div>
	</div>
</div>
<?php include 'footer.php';?>
</body>
</html>

