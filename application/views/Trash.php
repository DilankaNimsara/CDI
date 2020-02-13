<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Trash</title>
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

			<div class="container ">
				<div class="form-group">
					<div class="input-group">
						<span class="input-group-addon" style="height: 50px;">Search</span>
						<input type="text" name="search_text" id="search_text" placeholder="Search..." class="form-control" style="width: 350px;" />
					</div>
				</div>
				<br/>
				<div style="font-size: 13px;" id="result"></div>
			</div>
			<div style="clear:both"></div>


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
                url:"<?php echo base_url(); ?>live_search/Fetch_Trash",
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
