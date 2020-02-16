<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>View Document</title>
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
	<div class="col-sm-10 text-left">
		<!-- content -->
		<?php
		if(($_SESSION['type']=='external' || $_SESSION['type']=='under_graduate' || $_SESSION['type']=='post_graduate')&&($_SESSION['post']=="lecturer")){
			?>

			<?php
		}else {
			?>
			<br/>
			<a href="#alldocs"><h4 style="color: midnightblue">1) ALL DOCUMENTS</h4></a>
			<a href="#mydoc"><h4 style="color: midnightblue">2) MY DOCUMENTS
					<?php
					if($_SESSION['type']=='qac'){
						?>
						</h4>
						<?php
					}else{
						?>
						(Other Courses)</h4></a>
						<?php
					}
					?>

			<br/>

			<?php
		}
		?>
		<a id="alldocs"><h1 style="color: midnightblue">1) ALL DOCUMENTS</h1></a>
        <br/>
		<?php
		if($this->session->flashdata('delete_massage')){
			?>
			<div class="alert alert-danger">
				<span class="text-danger"> <?php echo $this->session->flashdata('delete_massage'); ?></span>
			</div>
			<?php
		}
		?>
		<div class="container">
			<form method="post" action="<?php echo base_url(); ?>login_controller/search_multiples">
			<table >
				<tr>
					<th width="20%" >Course</th>
					<th width="5%"></th>
					<th width="20%" >Category</th>
					<th width="5%"></th>
					<th width="20%" >Year</th>
					<th width="5%"></th>
					<th width="20%" >Semester</th>
					<th width="5%"></th>
					<th width="20%" ></th>

				</tr>
				<tr>
					<td width="20%" >
						<select class="form-control" name="doc_type" id="tp">
							<option class="text-muted"></option>
							<option name="doc_type" value="under_graduate">Under Graduate</option>
							<option name="doc_type" value="post_graduate">Post Graduate</option>
							<option name="doc_type" value="external">External</option>
							<option name="doc_type" value="other">Other</option>
						</select>
					</td>

					<td width="5%"></td>
					<td width="20%">
						<select class="form-control" name="category" id="category_data">
							<option class="text-muted"></option>
						</select>
					</td>
					<td width="5%"></td>
					<td width="20%">
						<select class="form-control" name="year" id="yr">
							<option class="text-muted"></option>
						</select>
					</td>

					<td width="5%"></td>
					<td width="20%">
						<select class="form-control" name="semester" id="sem">
							<option class="text-muted"></option>
						</select>
					</td>

					<td width="5%"></td>
					<td >
						<button class="btn btn-default" type="submit" value="Submit">Search</button>
					</td>

				</tr>
				<th width="20%" ><span style="font-size: 12px;" class="text-danger"><?php echo form_error('doc_type')?></span></th>
				<th width="5%"></th>
				<th width="20%" ><span style="font-size: 12px;" class="text-danger"><?php echo form_error('category')?></span></th>
				<th width="5%"></th>
				<th width="20%" ><span style="font-size: 12px;" class="text-danger"><?php echo form_error('year')?></span></th>
				<th width="5%"></th>
				<th width="5%"><span style="font-size: 12px;" class="text-danger"><?php echo form_error('semester')?></span></th>
				<th width="20%" ></th>

			</table>
			</form>

		</div>

        <div class="container ">
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon" style="height: 50px;">Search</span>
                    <input type="text" name="search_text" id="search_text" placeholder="Search..." class="form-control" style="width: 350px;" />
                </div>
            </div>
			<br/>
            <div style="width: 100%; font-size: 13px;" id="result"></div>
        </div>
        <div style="clear:both"></div>

		<?php
			if(($_SESSION['type']=='external' || $_SESSION['type']=='under_graduate' || $_SESSION['type']=='post_graduate')&&($_SESSION['post']=="lecturer")){
				?>

		<?php
			}else{
				?>
				<a id="mydoc">
					<h1 style="color: midnightblue">2) MY DOCUMENTS <?php
						if($_SESSION['type']!='qac'){
						?>(Other Courses)

					<?php
					}
					?>
				</h1>
				</a>


				<div class="container ">
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon" style="height: 50px;">Search</span>
							<input type="text" name="search_mydocs" id="search_mydocs" placeholder="Search..." class="form-control" style="width: 350px;" />
						</div>
					</div>
					<br/>
					<div style="width: 100%; font-size: 13px;" id="result2"></div>
				</div>
				<div style="clear:both"></div>
				<br/>
				<br/>
		<?php
			}
		?>


	</div>
	</div>
</div>

</body>
<?php include 'footer.php';?>
</html>

<script>
    $(document).ready(function(){

        load_data();
		load_data_mydoc();

        function load_data(query)
        {
            $.ajax({
                url:"<?php echo base_url(); ?>live_search/fetchDoc",
                method:"POST",
                data:{query:query},
                success:function(data){

                    $('#result').html(data);

                }
            })
        }

        $('#search_text').keyup(function(){
            var search = $(this).val();
            if(search != '')
            {
                load_data(search);
            }
            else
            {
                load_data();
            }
        });

		function load_data_mydoc(query1)
		{
			$.ajax({
				url:"<?php echo base_url(); ?>live_search/fetchMyDoc",
				method:"POST",
				data:{query:query1},
				success:function(data1){

					$('#result2').html(data1);

				}
			})
		}

		$('#search_mydocs').keyup(function(){
			var search1 = $(this).val();
			if(search1 != '')
			{
				load_data_mydoc(search1);
			}
			else
			{
				load_data_mydoc();
			}
		});

		$('#tp').change(function(){
			var account_type = $('#tp').val();
			if(account_type != '')
			{
				$.ajax({
					url:"<?php echo base_url(); ?>login_controller/fetch_category_TYPE",
					method:"POST",
					data:{account_type:account_type},
					success:function(data){
						$('#category_data').html(data);
						$('#yr').html('<option class="text-muted" name="year" value=""></option>'+
							'<option name="year" value="1" >1st year</option>'+
							'<option name="year" value="2" >2nd year</option>'+
							'<option name="year" value="3" >3rd year</option>' +
							'<option name="year" value="4" >4th year</option>'
						);
						$('#sem').html('<option name="semester"value=""></option>'+
						'<option name="semester" value="1sem">1st semester</option>'+
						'<option name="semester" value="2sem">2nd semester</option>'
						);
					}
				});
			}
			if(account_type == 'other'){
				$('#yr').html('<option name="year" value=""  >-</option>');
				$('#sem').html('<option name="semester"value="">-</option>');
				$('#category_data').html('<option name="category" value="">-</option>');
			}
		});

    });
</script>


