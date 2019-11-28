<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
	<?php include 'header.php';
	include 'autologout.php';
	if($this->session->userdata('username') == ''){
		include 'index.php';
	}?>
</head>
<body>

<div class="container-fluid">
	<div class="row content">
		<div class="col-sm-2">
			<?php include 'sidenav.php';?>
		</div>
		<div class="col-sm-10">
			<br/>
			<div class="alert alert-info">
				<span class="text-primary">jkkkk</span>
			</div>
		</div>
			<div class="col-sm-7">
			<?php
			$alphabet = '1234567890';
			$pass = array();
			$alphaLength = strlen($alphabet) - 1;
			for ($i = 0; $i < 5; $i++) {
				$n = rand(0, $alphaLength);
				$pass[] = $alphabet[$n];
			}
//			echo implode($pass);
			?>
			<center>
				<form>
					<button style="width: 200px;" class=" btn btn-success"> Request PIN</button>
					<br/>
					<br/>
					<button style="width: 200px;" class=" btn btn-success"> Request to Delete</button>
				</form>
				<br/>
				<br/>
				<label>
					Enter PIN :
				</label>
				<input style="width: 200px;" type="text" class="form-control">
			</center>
			<br/>
			<br/>
			<br/>
			<center>
				<button style="width: 100px;" class=" btn btn-danger delete_data"  id="<?php $_SESSION['file_name'];?>"><span class="glyphicon glyphicon-trash"></span> Delete</button>
			</center>
		</div>
		<div class="col-sm-3">
			<label>Received PIN :</label>
			<input type="text" value=""  style="width: 200px; color: gray;" class="form-control" readonly>
		</div>
	</div>
</div>
<?php include 'footer.php';?>
</body>
</html>

<script>
    $(document).ready(function(){
        $('.delete_data').click(function () {
            var id = $(this).attr("id");
            if (confirm("Are you sure, You want to delete this document ")) {
                window.location = "<?php echo base_url(); ?>login_controller/delete_uploaded_file";
            } else {
                return false;
            }
        });
    });
</script>
