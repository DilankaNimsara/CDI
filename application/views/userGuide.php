<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>User Guide</title>
	<?php include 'header.php';
	include 'autologout.php'; ?>
</head>
<body>


<div class="container-fluid">
	<div class="row content">
		<div class="col-sm-2">
			<?php
			if ($this->session->userdata('username') != '') {
				include 'sidenav.php';
			} else { ?>
				<?php
			} ?>
		</div>
		<br/>
		<div class="col-sm-10">
			<div class="well well-lg tx;">
			<div class="ex33forguid">
				<div style="color: whitesmoke;">
					Type here.........<br/>
					Type here.........<br/>
					Type here.........<br/>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<?php include 'footer.php'; ?>
</body>
</html>


