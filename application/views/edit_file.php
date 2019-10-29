<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Update Document</title>
	<?php include 'header.php';
	include 'autologout.php';?>
</head>
<body>

<div class="container-fluid">
	<div class="row content">
		<div class="col-sm-12">

			<br/>
			<div style="color: wheat;">
				You are here : <a style="color: wheat;" data-toggle="tooltip" title="Go back" href="<?php echo base_url('Home/viewDocument')?>"> View Document </a>  >
				<a style="color: wheat;" data-toggle="tooltip" title="Go back" href="<?php echo base_url('login_controller/reopen_editFile')?>"> Details </a> > Edit
			</div>
			<br/>
			<h4><a href="<?php echo base_url()?>login_controller/reopen_editFile"><span style="color: white";> Go Back </span><span style="color: white;" class="glyphicon glyphicon-triangle-left"></span></a></h4>

			<?php
			if ($fetch_data->num_rows() > 0) {
				foreach ($fetch_data->result() as $row) {
					//echo $row->category;
					if ($row->year==1){
						$selected_year1='selected';
						$selected_year2='';
						$selected_year3='';
						$selected_year4='';
					}elseif($row->year==2){
						$selected_year1='';
						$selected_year2='selected';
						$selected_year3='';
						$selected_year4='';
					}elseif($row->year==3){
						$selected_year1='';
						$selected_year2='';
						$selected_year3='selected';
						$selected_year4='';
					}elseif($row->year==4){
						$selected_year1='';
						$selected_year2='';
						$selected_year3='';
						$selected_year4='selected';
					}

					if ($row->semester=="1sem"){
						$selected_sem1='selected';
						$selected_sem2='';
					}elseif ($row->semester=="2sem"){
						$selected_sem1='';
						$selected_sem2='selected';
					}

					 $SUBJECT_CODE= $row->subject_code;

				}
			}
			?>

			<input type="text" class="hide" value="<?php echo $selected_year1; ?>" id="yr1">
			<input type="text" class="hide" value="<?php echo $selected_year2; ?>" id="yr2">
			<input type="text" class="hide" value="<?php echo $selected_year3; ?>" id="yr3">
			<input type="text" class="hide" value="<?php echo $selected_year4; ?>" id="yr4">
			<input type="text" class="hide" value="<?php echo $selected_sem1; ?>" id="sem1">
			<input type="text" class="hide" value="<?php echo $selected_sem2; ?>" id="sem2">
			<input type="text" class="hide" value="<?php echo $SUBJECT_CODE; ?>" id="SUB">

			<br/>
			<center>
				<h2><?php echo $_SESSION['file_name']?></h2>
			</center>

			<br/>

			<div class="container" style="margin-left:auto; width: 600px ">
				<div class="form">
			<form method="post" action="<?php echo base_url();?>login_controller/do_upload">

				<div class="form-group">
					<label for="username">Category</label>
					<select class="form-control" name="category" id="category_data">
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

			<div class="form-group">
				<label for="username">Year</label>
				<select class="form-control" name="year" id="yr">
					<option class="text-muted"></option>
					<option name="year" value="1" <?php echo $selected_year1;?>>1st year</option>
					<option name="year" value="2" <?php echo $selected_year2;?>>2nd year</option>
					<option name="year" value="3" <?php echo $selected_year3;?>>3rd year</option>
					<option name="year" value="4" <?php echo $selected_year4;?>>4th year</option>
				</select>
				<span class="text-danger"><?php echo form_error('year')?></span>
			</div>
			<div class="form-group">
				<label for="username">Semester</label>
				<select class="form-control" name="semester" id="sem">
					<option class="text-muted"></option>
					<option name="semester" value="1sem" <?php echo $selected_sem1; ?>>1st semester</option>
					<option name="semester" value="2sem" <?php echo $selected_sem2; ?>>2nd semester</option>
				</select>
				<span class="text-danger"><?php echo form_error('semester')?></span>
			</div>
			<div class="form-group">
				<label for="username">Subject Code</label>
				<div class="form-group">
					<select name="subject_code" id="subject_code" class="form-control">
						<option value="<?php echo $SUBJECT_CODE; ?>"></option>
					</select>
				</div>
				<span class="text-danger"><?php echo form_error('subject_code')?></span>
			</div>
			<div class="form-group">
				<label for="username">Academic Year</label>
				<input type="text" class="form-control" id="academic_year" name="academic_year" placeholder="Enter academic year"/>
			</div>
			<div class="form-group">
				<label for="username">Comment</label>
				<textarea rows="5" cols="50" class="form-control" id="comment" name="comment"></textarea>
			</div>

			<br/>
			<center><input type="submit" class="btn btn-primary" value="Update" /></center>

			</form>
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
            var selected_yr1=$('#yr1').val();
            var selected_yr2=$('#yr2').val();
            var selected_yr3=$('#yr3').val();
            var selected_yr4=$('#yr4').val();
            var selected_sem1=$('#sem1').val();
            var selected_sem2=$('#sem2').val();

            if(category_name != '')
            {
                $.ajax({
                    url:"<?php echo base_url(); ?>login_controller/fetch_sub_update",
                    method:"POST",
                    data:{category_name:category_name},
                    success:function(data)
                    {
                        $('#subject_code').html(data);
                        $('#yr').html('<option value=""></option>' +
                            '<option name="year" value="1" selected_yr1> 1st year</option>' +
                            '<option name="year" value="2" selected_yr2>2nd year</option>' +
                            '<option name="year" value="3" selected_yr3>3rd year</option>' +
                            '<option name="year" value="4" selected_yr4>4th year</option>');
                        $('#sem').html('<option value=""></option>' +
                            '<option name="semester" value="1sem" selected_sem1 >1st semester</option>' +
                            '<option name="semester" value="2sem" selected_sem2>2nd semester</option>');
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
            var SUB = $('#yr').val();
            if(year_name != '')
            {
                $.ajax({
                    url:"<?php echo base_url(); ?>login_controller/fetch_sub_year_update",
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
            var subject_cd=$('#Scode').val();
            if(year_name != '')
            {
                $.ajax({
                    url:"<?php echo base_url(); ?>login_controller/fetch_sub_year_sem_update",
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
                $('#subject_code').html('<option value="">subject_cd</option>');

            }
        });

    });
</script>
