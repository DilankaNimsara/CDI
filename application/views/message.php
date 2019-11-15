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
									<label>send group</label>
									<select class="form-control" name="select_acc" id="tp">
									<option class="text-muted"></option>
									<?php
									if($_SESSION['post']=='qac_head'){
									?>
									<option name="select_acc" value="to_all" id="to_all"> To All</option>
									<option name="select_acc" value="to_qac"  id="to_qac"> To QAC</option>
									<option name="select_acc" value="to_head_of_institute"  id="to_head_of_institute"> To Head of Institute</option>
									<option name="select_acc" value="to_external_head"  id="to_external_head"> To External head</option>
									<option name="select_acc" value="to_postgraduate_head"  id="to_postgraduate_head"> To Postgraduate head</option>
									<option name="select_acc" value="to_undergraduate_head"  id="to_undergraduate_head"> To Undergraduate head</option>
									<option name="select_acc" value="to_all_heads"  id="to_all_heads"> To All heads</option>
									<option name="select_acc" value="to_head_of_institute"  id="to_head_of_institute"> To Head of Institute</option>
									<?php
										}elseif (($_SESSION['post']=='head_of_course')&&($_SESSION['type']=='external')){
										foreach ($fetch_cat->result() as $row) {
											?>
											<option name="select_acc" value="<?php echo $row->category ;?>_course_coordinator"  id="ecc"> To <?php echo $row->category ;?> course coordinator</option>
											<?php
										}
										?>
										<option name="select_acc" value="to_all_externals"  id="to_all_externals"> To all external lecturers</option>
										<option name="select_acc" value="to_qac"  id="to_qac"> To QAC</option>
										<option name="select_acc" value="to_qac_head" id="to_qac_head"> To QAC Head </option>
									<?php
									}elseif (($_SESSION['post']=='head_of_institute')||($_SESSION['post']=='qac')) {
										?>
										<option name="select_acc" value="to_all" id="to_all"> To All</option>
										<option name="select_acc" value="to_qac"  id="to_qac"> To QAC</option>
										<option name="select_acc" value="to_head_of_institute"  id="to_head_of_institute"> To Head of Institute</option>
										<option name="select_acc" value="to_external_head"  id="to_external_head"> To External head</option>
										<option name="select_acc" value="to_postgraduate_head"  id="to_postgraduate_head"> To Postgraduate head</option>
										<option name="select_acc" value="to_undergraduate_head"  id="to_undergraduate_head"> To Undergraduate head</option>
										<option name="select_acc" value="to_all_heads"  id="to_all_heads"> To All heads</option>
									    <option name="select_acc" value="to_qac_head" id="to_qac_head"> To QAC Head </option>
										<?php
									}elseif (($_SESSION['post']=='head_of_course')&&($_SESSION['type']=='under_graduate')) {
										foreach ($fetch_cat2->result() as $row) {
											?>
											<option name="select_acc" value="<?php echo $row->category; ?>_course_coordinator" id="ucc">To <?php echo $row->category; ?> course coordinator
											</option>
											<?php
										}
										?>
										<option name="select_acc" value="to_all_undergraduates"  id="to_all_undergraduates"> To all undergraduate lecturers</option>
										<option name="select_acc" value="to_qac"  id="to_qac"> To QAC</option>
										<option name="select_acc" value="to_qac_head" id="to_qac_head"> To QAC Head </option>
									<?php
									}elseif (($_SESSION['post']=='head_of_course')&&($_SESSION['type']=='post_graduate')) {
										foreach ($fetch_cat3->result() as $row) {
											?>
											<option name="select_acc" value="<?php echo $row->category; ?>_course_coordinator" id="ucc">To <?php echo $row->category; ?> course coordinator
											</option>
											<?php
										}
										?>
										<option name="select_acc" value="to_all_postgraduates"  id="to_all_postgraduates"> To all postgraduate lecturers</option>
										<option name="select_acc" value="to_qac"  id="to_qac"> To QAC</option>
										<option name="select_acc" value="to_qac_head" id="to_qac_head"> To QAC Head </option>
										<?php
									}

									elseif (($_SESSION['post']=='course_coordinator')&&($_SESSION['type']=='post_graduate')) {
										foreach ($fetch_cat3->result() as $row) {
											if(($_SESSION['course_name']==$row->category)){
												?>
												<option name="select_acc" value="to_all_postgraduate_<?php echo $row->category;?>"  id="to_all_postgraduate_<?php echo $row->category;?>"> To all postgraduate <?php echo $row->category;?> lecturers </option>
												<?php
											}
										}
										?>
										<option name="select_acc" value="to_qac"  id="to_qac"> To QAC</option>
										<option name="select_acc" value="to_qac_head" id="to_qac_head"> To QAC Head </option>
										<?php
									}

									elseif (($_SESSION['post']=='course_coordinator')&&($_SESSION['type']=='under_graduate')) {
										foreach ($fetch_cat2->result() as $row) {
											if(($_SESSION['course_name']==$row->category)){
												?>
												<option name="select_acc" value="to_all_undergraduate_<?php echo $row->category;?>"  id="to_all_undergraduate_<?php echo $row->category;?>"> To all undergraduate <?php echo $row->category;?> lecturers </option>
											<?php
												}
										}
										?>
										<option name="select_acc" value="to_qac"  id="to_qac"> To QAC</option>
										<option name="select_acc" value="to_qac_head" id="to_qac_head"> To QAC Head </option>
										<?php
									}
									elseif (($_SESSION['post']=='course_coordinator')&&($_SESSION['type']=='external')) {
										foreach ($fetch_cat->result() as $row) {
											if(($_SESSION['course_name']==$row->category)){
												?>
												<option name="select_acc" value="to_all_external_<?php echo $row->category;?>"  id="to_all_external_<?php echo $row->category;?>"> To all undergraduate <?php echo $row->category;?> lecturers </option>
												<?php
											}
										}
										?>
										<option name="select_acc" value="to_qac"  id="to_qac"> To QAC</option>
										<option name="select_acc" value="to_qac_head" id="to_qac_head"> To QAC Head </option>
										<?php
									}

									?>




								</select>
									<span class="text-danger"><?php echo form_error('select_acc')?></span>
								</div>
								<div class="form-group">
									<label>Message</label>
									<textarea rows="5" cols="50" class="form-control" id="message" name="message" placeholder="type here.."> </textarea>
									<span class="text-danger"><?php echo form_error('message')?></span>
								</div>

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


