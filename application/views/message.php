<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Message</title>
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

			<div class="container" style="margin-left:auto; width: 600px ">

				<div class="row">
					<div class="col-4 ">
						<form method="post" action="<?php echo base_url();?>login_controller/send_message_accounts">

							<div class="form">
								<hr>
								<span style="color: midnightblue;" >
						<center><h1>Message</h1></center>
					</span>
								<br/>

								<div class="form-group">

									<textarea rows="5" cols="50" class="form-control" id="message" name="message" placeholder="type here.."> </textarea>
									<span class="text-danger"><?php echo form_error('message')?></span>
								</div>
								<table width="100%">
									<tr>
										<td width="60px"><input type="checkbox" name="select_acc" value="to_all" id="to_all"><font color="red"> To All</font></td>
										<td width="60px"><input type="checkbox" name="select_acc" value="to_qac"  id="to_qac"> To QAC</td>
										<td width="60px"><input type="checkbox" name="select_acc" value="to_head_of_institute"  id="to_head_of_institute"> To Head of Institute</td>
									</tr>
									<tr>
										<td width="60px"><input type="checkbox" name="select_acc" value="to_external_head"  id="to_external_head"> To External head</td>
										<td width="60px"><input type="checkbox" name="select_acc" value="to_postgraduate_head"  id="to_postgraduate_head"> To Postgraduate head</td>
										<td width="60px"><input type="checkbox" name="select_acc" value="to_undergraduate_head"  id="to_undergraduate_head"> To Undergraduate head</td>
									</tr>
									<tr>
										<td colspan="3"><br/><span class="text-danger"> <?php echo $this->session->flashdata('box'); ?></span></span></td>
									</tr>
								</table>
								<br/>
								<center><button type="submit" class="btn btn-primary" name="submit" value="submit"><span class="glyphicon glyphicon-send"></span> Send </button></center>
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







		</div>
	</div>
</div>
<?php include 'footer.php';?>
</body>
</html>

