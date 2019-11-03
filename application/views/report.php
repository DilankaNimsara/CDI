<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Report</title>
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

			<h1 style="color: midnightblue;">......... Summary .........</h1>
<br/>
			<div class="col-sm-9">
			<div class="container ">
				<div class="form-group">
					<div class="input-group">
						<span class="input-group-addon" style="height: 50px;">Search</span>
						<input type="text" name="search_text" id="search_text" placeholder="Search by User name or Post" class="form-control" style="width: 450px;" />
					</div>
					<br/>
				</div>
				<div style="width: 75%;">
					<div id="result"></div>
				</div>

			</div>
			<div style="clear:both"></div>
			</div>
			<div class="col-sm-3">
				<?php

				$count_qac=0;
				$count_lec_ug=0;
				$count_lec_pg=0;
				$count_lec_eg=0;
				if ($count_data->num_rows() > 0) {
					foreach ($count_data->result() as $row) {
						if(($row->type)=='qac'){
							$count_qac=$count_qac+1;
						}elseif ((($row->post)=='lecture')&&(($row->type)=='under_graduate')){
							$count_lec_ug=$count_lec_ug+1;
						}elseif ((($row->post)=='lecture')&&(($row->type)=='post_graduate')){
							$count_lec_pg=$count_lec_pg+1;
						}elseif ((($row->post)=='lecture')&&(($row->type)=='external')){
							$count_lec_eg=$count_lec_eg+1;
						}
					}
				}
				?>
				<div class="panel panel-default">
					<div class="panel-heading">Number of Accounts</div>
						<div class="panel-body">
							<br/>
							QAC Accounts -	<?php echo $count_qac;?>	 <br/>
							Under Graduate Lectures -	<?php echo $count_lec_ug;?> <br/>
							Post Graduate Lectures -	<?php echo $count_lec_pg;?><br/>
							External Lectures -		<?php echo $count_lec_eg;?> <br/>
							<br/>
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

        load_data();

        function load_data(query)
        {
            $.ajax({
                url:"<?php echo base_url(); ?>live_search/makereport",
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
    });
</script>
