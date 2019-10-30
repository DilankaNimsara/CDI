<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Edit Account</title>
    <?php include 'header.php';
    include 'autologout.php';?>
</head>
<body>

<div class="container-fluid">
    <div class="row content">
        <br/>
        <br/>
        <div class="col-sm-1">
			<?php
			if($_SESSION['report']=="report"){
				?>
				<h4><a href="<?php echo base_url()?>login_controller/Report"><span style="color: white";> Go Back </span><span style="color: white;" class="glyphicon glyphicon-triangle-left"></span></a></h4>
				<?php
			}else{
				?>
				<h4><a href="<?php echo base_url()?>login_controller/manageAccount"><span style="color: white";> Go Back </span><span style="color: white;" class="glyphicon glyphicon-triangle-left"></span></a></h4>
				<?php
			}
			?>
           </div>
        <div class="col-sm-10">
                <span class="text-danger"><?php echo form_error('pw')?></span>
                <span class="text-danger"><?php echo form_error('confirm_pw')?></span>
            <hr>
            <h2 style="color: midnightblue;" ><center>Edit</center></h2>

            <div class="container" style="margin-left:auto; width: 500px ">

                <div class="row">
                    <div class="col-4 ">
                        <form method="post" action="<?php echo base_url();?>login_controller/update_and_delete_user_accounts">

                                <br/>
							<?php
							if(($_SESSION['post']=='qac')){
							?>
								<div class="form-group">
									<label for="type">Type</label>
									<input style="color: black;" type="text" class="form-control" name="type" id="type" value="<?php echo strtoupper(str_replace('_', ' ', $_SESSION['account_type']));?>" readonly>
								</div>
								<div class="form-group">
									<label for="type">Post</label>
									<input style="color: black;" type="text" class="form-control" name="post" id="post" value="<?php echo strtoupper(str_replace('_', ' ', $_SESSION['account_post']));?>" readonly>
								</div>
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" value="<?php echo $_SESSION['account_username'];?>" >
                                    <span class="text-danger"><?php echo form_error('username')?></span>
                                </div>

                                <div class="form-group">
                                    <label for="email">E-mail</label>
                                    <input type="text" class="form-control" id="email" name="email" value="<?php echo $_SESSION['account_email'];?>" >
                                    <span class="text-danger"><?php echo form_error('email')?></span>
                                </div>
							<?php
							if ((( $_SESSION['account_type']!='qac')&&($_SESSION['account_type']!='head_of_institute'))){
							?>
								<div class="form-group">
									<label for="password">Password</label>
									<input type="password" class="form-control" id="password" name="password" >
									<span class="text-danger"><?php echo form_error('password')?></span>
								</div>
								<div class="form-group">
									<label for="con_password">Confirm Password</label>
									<input type="password" class="form-control" name="con_password" id="con_password" >
									<span class="text-danger"><?php echo form_error('con_password')?></span>
								</div>

							<?php
							}elseif ((( $_SESSION['account_type']!='qac')&&($this->session->userdata('username')!=$_SESSION['account_username']))){
								?>
								<div class="form-group">
									<label for="password">Password</label>
									<input type="password" class="form-control" id="password" name="password" >
									<span class="text-danger"><?php echo form_error('password')?></span>
								</div>
								<div class="form-group">
									<label for="con_password">Confirm Password</label>
									<input type="password" class="form-control" name="con_password" id="con_password" >
									<span class="text-danger"><?php echo form_error('con_password')?></span>
								</div>
								<?php
							}elseif (($this->session->userdata('username')==$_SESSION['account_username'])){
								?>
								<div class="form-group">
									<label for="password">Password</label>
									<input type="password" class="form-control" id="password" name="password" >
									<span class="text-danger"><?php echo form_error('password')?></span>
								</div>
								<div class="form-group">
									<label for="con_password">Confirm Password</label>
									<input type="password" class="form-control" name="con_password" id="con_password" >
									<span class="text-danger"><?php echo form_error('con_password')?></span>
								</div>
								<?php
							}else{
								?>
								<br/>
								<center>
									<h4 class="text-danger">You cant edit or delete this profile. Contact <a><?php echo $_SESSION['account_username'];?></a> or <a>QAC Head</a></h4>
								</center>
							<?php
							}
							?>


								<?php
							}elseif ($_SESSION['post']=='qac_head'){
								?>
								<div class="form-group">
									<label for="type">Current Type</label>
									<input style="color: black;" type="text" class="form-control" name="type" id="type" value="<?php echo strtoupper(str_replace('_', ' ', $_SESSION['account_type']));?>" readonly>
								</div>
								<div class="form-group">
									<label for="type">Current Post</label>
								<table>
									<tr>
										<td width="375px">
												<input style="color: black;" type="text" class="form-control" name="post" id="post" value="<?php echo strtoupper(str_replace('_', ' ', $_SESSION['account_post']));?>" readonly>

										</td>
										<td width="125px" align="center">
											<?php
											if($_SESSION['account_post']!='qac_head'){
												?>
												<button type="button" class="btn btn-success" data-toggle="modal" data-target="#update_post">change post</button>
												<?php
											}elseif ($_SESSION['account_post']=='qac_head'){
												?>
												<button type="button" class="btn btn-success disabled" data-toggle="modal" data-target="#update_post">change post</button>
											<?php
											}
											?>
										</td>
									</tr>
								</table>
								</div>


								<div class="form-group">
									<label for="username">Username</label>
									<input type="text" class="form-control" id="username" name="username" value="<?php echo $_SESSION['account_username'];?>" >
									<span class="text-danger"><?php echo form_error('username')?></span>
								</div>

								<div class="form-group">
									<label for="email">E-mail</label>
									<input type="text" class="form-control" id="email" name="email" value="<?php echo $_SESSION['account_email'];?>" >
									<span class="text-danger"><?php echo form_error('email')?></span>
								</div>
								<div class="form-group">
									<label for="password">Password</label>
									<input type="password" class="form-control" id="password" name="password" >
									<span class="text-danger"><?php echo form_error('password')?></span>
								</div>
								<div class="form-group">
									<label for="con_password">Confirm Password</label>
									<input type="password" class="form-control" name="con_password" id="con_password" >
									<span class="text-danger"><?php echo form_error('con_password')?></span>
								</div>
							<?php
							}
							if ($_SESSION['post']=='head_of_institute'){
								?>
								<div class="form-group">
									<label for="type">Current Type</label>
									<input style="color: black;" type="text" class="form-control" name="type" id="type" value="<?php echo strtoupper(str_replace('_', ' ', $_SESSION['account_type']));?>" readonly>
								</div>
								<div class="form-group">
									<label for="type">Current Post</label>
									<input style="color: black;" type="text" class="form-control" name="post" id="post" value="<?php echo strtoupper(str_replace('_', ' ', $_SESSION['account_post']));?>" readonly>
								</div>
								<div class="form-group">
									<label for="username">New Type</label>
									<select class="form-control" name="type" id="a_type">
										<option class="text-muted"></option>
										<option name="type" value="under_graduate">Under Graduate</option>
										<option name="type" value="post_graduate">Post Graduate</option>
										<option name="type" value="external">External</option>
										<option name="type" value="qac">QAC</option>
										<option name="type" value="head_of_institute">Head of institute</option>
									</select>
									<span class="text-danger"><?php echo form_error('type')?></span>
								</div>
								<div class="form-group">
									<label for="username">New Post</label>
									<select class="form-control" name="post" id="a_post">
										<option class="text-muted"></option>
									</select>
									<span class="text-danger"><?php echo form_error('post')?></span>
								</div>
								<div class="form-group">
									<label for="username">Username</label>
									<input type="text" class="form-control" id="username" name="username" value="<?php echo $_SESSION['account_username'];?>" >
									<span class="text-danger"><?php echo form_error('username')?></span>
								</div>

								<div class="form-group">
									<label for="email">E-mail</label>
									<input type="text" class="form-control" id="email" name="email" value="<?php echo $_SESSION['account_email'];?>" >
									<span class="text-danger"><?php echo form_error('email')?></span>
								</div>
								<div class="form-group">
									<label for="password">Password</label>
									<input type="password" class="form-control" id="password" name="password" >
									<span class="text-danger"><?php echo form_error('password')?></span>
								</div>
								<div class="form-group">
									<label for="con_password">Confirm Password</label>
									<input type="password" class="form-control" name="con_password" id="con_password" >
									<span class="text-danger"><?php echo form_error('con_password')?></span>
								</div>
							<?php
							}
							?>

                                <br/>
							<?php

							//----------------------------------------update button-----------------------------------------------------------------------------

							if ((( $_SESSION['account_type']!='qac')&&($_SESSION['account_type']!='head_of_institute'))){
								?>
								<center>
									<button type="submit" class="btn btn-primary" name="submit" value="submit">Update</button>
								</center>
								<?php
							}elseif ((( $_SESSION['account_type']!='qac')&&($this->session->userdata('username')!=$_SESSION['account_username']))){
								?>
								<center>
									<button type="submit" class="btn btn-primary" name="submit" value="submit">Update</button>
								</center>
								<?php
							}elseif (($this->session->userdata('username')==$_SESSION['account_username'])){
								?>
								<center>
									<button type="submit" class="btn btn-primary" name="submit" value="submit">Update</button>
								</center>
								<?php
							}elseif(( $_SESSION['type']=='qac')&&($_SESSION['post']=='qac_head')){
								?>
								<center>
									<button type="submit" class="btn btn-primary" name="submit" value="submit">Update</button>
								</center>
								<?php
							}

							?>
                            </div>
                            <br/>
                        </form>


                    </div>
                </div>
            <hr>
			<div class="container">
				<div align="right">
					<?php
					//---------------------------------------- delete button-----------------------------------------------------------------------------
					if( $_SESSION['account_post']!='qac_head'){
						if(( $_SESSION['type']=='qac')&&($_SESSION['post']=='qac_head')){
							?>
							<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete">Delete Account</button>
							<?php
						}elseif (($_SESSION['account_username'])==($this->session->userdata('username'))){
							?>
							<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete">Delete Account</button>
							<?php
						}elseif ((( $_SESSION['account_type']!='qac')&&($this->session->userdata('username')!=$_SESSION['account_username']))){
							?>
							<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete">Delete Account</button>
							<?php
						}
					}elseif(($_SESSION['post']=='qac_head')&&($_SESSION['account_post']=='qac_head')){
						?>
						<button type="button" class="btn btn-danger disabled" data-toggle="modal" data-target="#delete">Delete Account</button>
						<?php
					}

					?>

				</div>

				<!---------------------------------------------------------delete pop uo-------------------------->
				<div class="modal fade" id="delete" role="dialog">
					<div class="modal-dialog">

						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">Delete</h4>
							</div>
							<div class="modal-body">

								<form method="post" action="<?php echo base_url();?>login_controller/delete_conform_account">
									<div class="form-group">
										<label>Password</label>
										<input type="password" class="form-control" id="pw" name="pw" placeholder="Enter admin password">
										<span class="text-danger"><?php echo form_error('pw')?></span>
									</div>
									<div class="form-group">
										<label>Confirm Password</label>
										<input type="password" class="form-control" id="confirm_pw" name="confirm_pw" placeholder="Re-enter admin password"/>
										<span class="text-danger"><?php echo form_error('confirm_pw')?></span>
									</div>
									<input type="text" class="hide" name="admin_password" value="<?php echo $this->session->userdata('password')?>" readonly>

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

				<!-------------------------------------------------------- change post popup------------------------------------------------->
				<div class="modal fade" id="update_post" role="dialog">
					<div class="modal-dialog">

						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">Update post</h4>
							</div>
							<div class="modal-body">

								<form method="post" action="<?php echo base_url();?>login_controller/update_post">

									<div class="form-group">
										<label for="username">New Type</label>
										<select class="form-control" name="type" id="a_type">
											<option class="text-muted"></option>
											<option name="type" value="under_graduate">Under Graduate</option>
											<option name="type" value="post_graduate">Post Graduate</option>
											<option name="type" value="external">External</option>
											<option name="type" value="qac">QAC</option>
											<option name="type" value="head_of_institute">Head of institute</option>
										</select>
										<span class="text-danger"><?php echo form_error('type')?></span>
									</div>
									<div class="form-group">
										<label for="username">New Post</label>
										<select class="form-control" name="post" id="a_post">
											<option class="text-muted"></option>
										</select>
										<span class="text-danger"><?php echo form_error('post')?></span>
									</div>
									<input type="text" class="hide" id="username" name="username" value="<?php echo $_SESSION['account_username'];?>" >
									<input type="text" class="hide" id="email" name="email" value="<?php echo $_SESSION['account_email'];?>" >

									<center>
										<button type="submit" class="btn btn-primary" name="submit" value="Submit">Update</button>
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
            </div>

        </div>
    </div>
</div>
<?php include 'footer.php';?>
</body>
</html>

<script>
    $(document).ready(function(){
        $('#a_type').change(function(){
            var a_type = $('#a_type').val();
            if(a_type == 'head_of_institute')
            {
                $.ajax({
                    url:"",
                    method:"POST",
                    data:{a_type:a_type},
                    success:function(data)
                    {
                        $('#a_post').html('<option name="post" value="head_of_institute">Head of institute</option>');
                    }
                });
            }
            if(a_type == 'qac')
            {
                $.ajax({
                    url:"",
                    method:"POST",
                    data:{a_type:a_type},
                    success:function(data)
                    {
                        $('#a_post').html('<option name="post" value=""></option>' +'<option name="post" value="qac">QAC</option>'+'<option name="post" value="qac_head">QAC Head</option>');
                    }
                });
            }
            if((a_type != 'qac') && (a_type != 'head_of_institute'))
            {
                $.ajax({
                    url:"",
                    method:"POST",
                    data:{a_type:a_type},
                    success:function(data)
                    {
                        $('#a_post').html('<option value=""></option>' +
                            '<option name="post" value="lecture">Lecture</option>' +
                            '<option name="post" value="head_of_course">Head of Course</option>' +
                            '<option name="post" value="course_coordinator">Course Coordinator</option>');
                    }
                });
            }
        });
    });
</script>

