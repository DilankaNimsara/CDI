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
			<table>
				<tr>
					<th width="20%" >Course</th>
					<th width="5%"></th>
					<th width="20%" >Category</th>
					<th width="5%"></th>
					<th width="20%" >Year</th>
					<th width="5%"></th>
					<th width="20%" >Semester</th>

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
					<td>
						<form method="post" action="<?php echo base_url(); ?>login_controller/search_multiples">
							<button class="btn btn-default" type="submit" value="Submit">Search</button>
						</form>
					</td>
				</tr>

			</table>

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
	</div>
	</div>
</div>

</body>
<?php include 'footer.php';?>
</html>

<script>
    $(document).ready(function(){

        load_data();

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
				$('#yr').html('<option value="null">-</option>');
				$('#sem').html('<option value="null">-</option>');
				$('#category_data').html('<option value="null">-</option>');
			}
		});


    });
</script>


