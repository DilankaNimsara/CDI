<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>External Degrees</title>
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
			<div class="row">
				<br/>
				<center>
					<div class="btn-group btn-group-justified" style="width: 95%;">
						<a href="<?php echo base_url('login_controller/Document_Settings'); ?>" class="btn btn-info">Under Graduate</a>
						<a href="<?php echo base_url('login_controller/Post_Graduate'); ?>" class="btn btn-info">Post Graduate</a>
                        <a class="btn btn-primary">External</a>
					</div>
				</center>
			</div>
		</div>
			<br/>
			<br/>

		<div class="col-sm-5">
			<br/>
			<br/>
			<div class="container ">
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon" style="height: 50px;">Search</span>
                        <input type="text" name="search_text" id="search_text" placeholder="Search by category" class="form-control" style="width: 350px;" />
                    </div>
                </div>

                <br/>

                <br/>
                <br/>
                    <div style="width: 600px;" id="result"></div>
            </div>
			<div style="clear:both"></div>

		</div>

        <div class="col-sm-5">

            <div class="container" style="margin-left:auto; width: 500px ">
                <div class="row">
                    <div class="col-4 ">
                        <div class="form">
                            <hr/>
                            <span style="color: midnightblue;" >
						                    <center><h1>Add Categories</h1></center>
                                         </span>
                            <form method="post" action="<?php echo base_url();?>login_controller/insertExternal">
                                <br/>
                                <div class="form-group">
                                    <label for="username">Category</label>
                                    <input type="text" class="form-control" id="category" name="category" placeholder="Ex : Information System / IS"/>
                                    <span class="text-danger"><?php echo form_error('category')?></span>
                                </div>
                                <center><button type="submit" class="btn btn-primary" name="submit" value="submit">Enter</button></center>
                            </form>
							<hr/>
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

        load_data();

        function load_data(query)
        {
            $.ajax({
                url:"<?php echo base_url(); ?>live_search/Fetch_External",
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





