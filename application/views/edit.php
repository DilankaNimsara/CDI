<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Edit</title>
	<?php include 'header.php';
	include 'autologout.php';
	if($this->session->userdata('username') == ''){
		include 'index.php';
	}?>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
</head>
<body>
<div class="container-fluid">
	<div class="row content">
		<div class="col-sm-12">
			<div class="col-sm-6">
			<br/>

			<div style="color: wheat;">
			You are here : <a style="color: wheat;" data-toggle="tooltip" title="Go back" href="<?php echo base_url('Home/viewDocument')?>"> View Document </a>  > Details
			</div>
			<br/>
			<h4><a href="<?php echo base_url();?>Home/viewDocument"><span style="color: white";> Go Back </span><span style="color: white;" class="glyphicon glyphicon-triangle-left"></span></a></h4>
			<br/>



			<center>
			<h2><?php echo $_SESSION['file_name'];?></h2>
			</center>
			<br/>

		<table align="center" style="font-weight: bold;">

				<?php
			if (isset($user_data)) {
				foreach ($user_data->result() as $row) { ?>
			<tr height="30px">
				<td>Date Created</td>
				<td width="20px"> : </td>
				<td><?php echo $row->date_created;?></td>
				<td></td>
			</tr>
			<tr height="30px">
				<td>Category</td>
				<td> : </td>
				<td><?php echo $row->category;?></td>
			</tr>
			<tr height="30px">
				<td>Year</td>
				<td> : </td>
				<td><?php echo $row->year;?></td>
			</tr>
			<tr height="30px">
				<td>Semester</td>
				<td> : </td>
				<td><?php echo $row->semester;?></td>
			</tr>
			<tr height="30px">
				<td>Academic Year </td>
				<td> : </td>
				<td><?php echo $row->academic_year;?></td>
			</tr>
			<tr height="30px">
				<td>Subject Code</td>
				<td> : </td>
				<td><?php echo $row->subject_code;?></td>
			</tr>
			<tr height="30px">
				<td>Lecturer</td>
				<td> : </td>
				<td><?php echo $row->lecturer;?></td>
			</tr>
			<tr height="30px">
				<td>Document Type</td>
				<td> : </td>
				<td><?php echo str_replace('_',' ',$row->doc_type);?></td>
			</tr>
			<tr height="30px">
				<td>Author</td>
				<td> : </td>
				<td><?php echo $row->author;?></td>
			</tr>
			<tr height="30px">
				<td>Comment</td>
				<td> : </td>
				<td><?php echo $row->comment;?></td>
			</tr>

					<?php
				}
			}
				?>

		</table>

			<br/>

			<table align="center" width="250px">
				<tr>
					<td>
						<form method="post" action="<?php echo base_url();?>login_controller/download_file">
							<center>
								<button style="width: 100px;" class="btn btn-info" name="submit" value="<?php echo $_SESSION['file_name'];?>"><span class="glyphicon glyphicon-download-alt"></span> View</button>
							</center>
						</form>
					</td>
					<td align="right">
						<?php
						if(($_SESSION['type']=='qac')||($_SESSION['type']=='head_of_institute')){
						?>
							<button style="width: 100px;" class=" btn btn-danger"  name="delete" value="delete" data-toggle="modal" data-target="#delete"><span class="glyphicon glyphicon-trash"></span> Delete</button>
							<?php
						}
						?>
					</td>
				</tr>
			</table>

				<!---------------------------------------------------------delete pop upz-------------------------->
				<div class="modal fade" id="delete" role="dialog">
					<div class="modal-dialog">

						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">Delete</h4>
							</div>
							<div class="modal-body">

								<form method="post" action="<?php echo base_url();?>login_controller/delete_conform_file">
									<div class="form-group">
										<label>Password</label>
										<input type="password" class="form-control" id="pw" name="pw" placeholder="Enter admin password">
										<span toggle="#pw" class="fa fa-fw fa-eye field-icon toggle-password"></span>
										<span class="text-danger"><?php echo form_error('pw')?></span>
									</div>
									<div class="form-group">
										<label>Confirm Password</label>
										<input type="password" class="form-control" id="confirm_pw" name="confirm_pw" placeholder="Re-enter admin password"/>
										<span toggle="#confirm_pw" class="fa fa-fw fa-eye field-icon toggle-password"></span>
										<span class="text-danger"><?php echo form_error('confirm_pw')?></span>
									</div>
									<input type="text" class="hide" name="admin_password" value="<?php echo $this->session->userdata('password');?>" >
									<input type="text" class="hide" name="filenametodelete" value="<?php echo $_SESSION['file_name'];?>" >
									<center>
										<button type="submit" class="btn btn-danger" name="delete" value="Delete">Delete</button>
									</center>
								</form>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							</div>
						</div>

					</div>
				</div>

			</div>

			<div class="col-sm-3">
				<form method="post" action="<?php echo base_url();?>login_controller/submit_commit">
					<h1 align="center">Add comments</h1>
					<br/>
					<center>
						<textarea rows="5" cols="50" class="form-control" id="commit" name="commit"> </textarea>
						<input type="text" class="hide" name="filenametosubit" value="<?php echo $_SESSION['file_name']; ?>">
						<span class="text-danger"><?php echo form_error('commit')?></span>
						<br/>
						<button style="width: 100px;" class=" btn btn-success"  name="submit" value="Submit"> Submit </button>
					</center>
				</form>
			</div>

			<div class="col-sm-3">

				<h1 align="center">Comments</h1>
				<br/>
				<div class="well well-lg tx" ;">
				<div class="ex3">
					<?php
					foreach ($user_data2->result()as $row) {
					?>
					<div class="container2" >
						<p><?php echo $row->commit;?></p>
					</div>
					<?php
					}
					?>
				</div>

			</div>

		</div>
	</div>
</div>
<?php include 'footer.php';?>
</body>
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

