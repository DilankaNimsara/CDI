
<?php

$actual_link = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
$url= basename($actual_link);

?>

<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Upload file</title>
    <?php include 'header.php';
    include 'autologout.php';?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
</head>
<body>
<div class="container-fluid">
	<div class="row content">
		<div class="col-sm-2">
			<?php include 'sidenav.php';?>
		</div>
		<div class="col-sm-10">

            <div class="container" style="margin-left:auto; width: 600px ">
                <div class="form">
                    <hr>
                    <span style="color: midnightblue;" >
                            <center><h1>Upload Document</h1></center>
                        </span>
                    <br/>



                <?php echo form_open_multipart('login_controller/do_upload');?>

					<table width="100%">
						<tr>
							<td width="25%" height="65px">
								<div class="form-group">
									<label>Course Type</label>
							</td>
							<td width="75%">
								<select class="form-control" name="type" id="#">
									<option class="text-muted"></option>
									<option name="type" value="under_graduate">Under Graduate</option>
									<option name="type" value="post_graduate">Post Graduate</option>
									<option name="type" value="external">External</option>
								</select>
								<span class="text-danger"><?php echo form_error('#')?></span>
							</td>
						</tr>
						<tr>
							<td width="25%" height="65px">
								<div class="form-group">
									<label>Category</label>
							</td>
							<td width="75%">

								<select class="form-control" name="category" id="category_data">
									<option class="text-muted"></option>
									<?php
									if ($fetch_data->num_rows() > 0) {
										foreach ($fetch_data->result() as $row) {
											?>
											<option name="category" value="<?php echo $row->category;?>"><?php echo strtoupper(str_replace('_',' ',$row->category));?></option>
											<?php
										}
									}
									?>
								</select>
								<span class="text-danger"><?php echo form_error('category')?></span>
								</div>
							</td>
						</tr>
						<tr>
							<td width="25%" height="65px">
								<div class="form-group">
									<label>Year</label>
							</td>
							<td width="75%">
								<select class="form-control" name="year" id="yr">
									<option class="text-muted"></option>
									<option name="year" value="1">1st year</option>
									<option name="year" value="2">2nd year</option>
									<option name="year" value="3">3rd year</option>
									<option name="year" value="4">4th year</option>
								</select>
								<span class="text-danger"><?php echo form_error('year')?></span>
								</div>
							</td>
						</tr>
						<tr>
							<td width="25%" height="65px">
								<div class="form-group">
									<label>Semester</label>
							</td>
							<td width="75%">
								<select class="form-control" name="semester" id="sem">
									<option class="text-muted"></option>
									<option name="semester" value="1sem">1st semester</option>
									<option name="semester" value="2sem">2nd semester</option>
								</select>
								<span class="text-danger"><?php echo form_error('semester')?></span>
								</div>
							</td>
						</tr>

						<tr>
							<td width="25%" height="65px">
								<div class="form-group">
									<label>Subject Code</label>
							</td>
							<td width="75%">
									<select name="subject_code" id="subject_code" class="form-control">
										<option value=""></option>
									</select>
								<span class="text-danger"><?php echo form_error('subject_code')?></span>
								</div>
							</td>
						</tr>

						<tr>
							<td width="25%" height="65px">
								<div class="form-group">
									<label>Academic Year</label>
							</td>
							<td width="75%">
								<input type="text" class="form-control" id="academic_year" name="academic_year" placeholder="Enter academic year"/>
								</div>
							</td>
						</tr>

						<tr>
							<td width="25%" height="65px">
								<div class="form-group" >
									<label>File</label>
							</td>
							<td width="75%">
								<input type="file" class="form-control" name="file_name">
								<span class="text-danger"> <?php echo $this->session->flashdata("errorx");?></span>
								</div>
							</td>
						</tr>

						<tr>
							<td width="25%" height="65px">
								<div class="form-group">
									<label>Comment</label>
							</td>
							<td width="75%" height="160px">
									  <textarea rows="5" cols="50" class="form-control" id="comment" name="comment"> </textarea>
								</div>
							</td>
						</tr>

					</table>

                    <br/>
                    <center><input type="submit" class="btn btn-primary" value="upload" /></center>

                </form>
                    <hr>
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
        $('#category_data').change(function(){
            var category_name = $('#category_data').val();
            if(category_name != '')
            {
                $.ajax({
                    url:"<?php echo base_url(); ?>login_controller/fetch_sub",
                    method:"POST",
                    data:{category_name:category_name},
                    success:function(data)
                    {
                        $('#subject_code').html(data);
                        $('#yr').html('<option value=""></option>' +
                            '<option name="year" value="1">1st year</option>' +
                            '<option name="year" value="2">2nd year</option>' +
                            '<option name="year" value="3">3rd year</option>' +
                            '<option name="year" value="4">4th year</option>');
                        $('#sem').html('<option value=""></option>' +
                            '<option name="semester" value="1sem">1st semester</option>' +
                            '<option name="semester" value="2sem">2nd semester</option>');
                    }
                });
            }
            else
            {
               // $('#subject_code').html('<option value="">Select Subject</option>');
            }
        });

        $('#yr').change(function(){
            var year_name = $('#yr').val();
            var category_name = $('#category_data').val();
            if(year_name != '')
            {
                $.ajax({
                    url:"<?php echo base_url(); ?>login_controller/fetch_sub_year",
                    method:"POST",
                    data:{year_name:year_name,category_name:category_name},
                    success:function(data)
                    {
                        $('#subject_code').html(data);
                        $('#sem').html('<option value=""></option>' +
                            '<option name="semester" value="1sem">1st semester</option>' +
                            '<option name="semester" value="2sem">2nd semester</option>');
                    }
                });
            }
            else
            {
               // $('#subject_code').html('<option value="">Select Subject Code</option>');

            }
        });

        $('#sem').change(function(){
            var semester_name=$('#sem').val();
            var year_name = $('#yr').val();
            var category_name = $('#category_data').val();
            if(year_name != '')
            {
                $.ajax({
                    url:"<?php echo base_url(); ?>login_controller/fetch_sub_year_sem",
                    method:"POST",
                    data:{semester_name:semester_name,year_name:year_name,category_name:category_name},
                    success:function(data)
                    {
                        $('#subject_code').html(data);
                    }
                });
            }
            else
            {
                $('#subject_code').html('<option value="">Select Subject Code</option>');

            }
        });

    });
</script>
