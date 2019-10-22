<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Document Settings</title>
    <?php include 'header.php';
    include 'autologout.php';?>
</head>
<body>
<div class="container-fluid">
    <div class="row content">
        <div class="col-sm-2">
            <?php include 'sidenav.php';?>
        </div>
		<div class="col-sm-10" >
			<div class="row">
				<br/>
				<center>
					<div class="btn-group btn-group-justified" style="width: 95%;">
						<a class="btn btn-primary">Under Graduate</a>
						<a href="<?php echo base_url('login_controller/Post_Graduate'); ?>" class="btn btn-info">Post Graduate</a>
						<a href="<?php echo base_url('login_controller/External_Deg'); ?>" class="btn btn-info">External</a>
					</div>
				</center>
			</div>
		</div>
        <div class="col-sm-5">
            <?php
            $count=0;
            if ($fetch_data->num_rows() > 0) {
                foreach ($fetch_data->result() as $row) {
                    $count=$count+1;
                }
            }
            ?>



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
                <span align="right"><b>Total number of Categories - <?php echo $count;?></b></span>
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
                            <form method="post" action="<?php echo base_url();?>login_controller/insertCat">
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

			<!--
            <div class="container" style="margin-left:auto; width: 500px ">
                <div class="row">
                    <div class="col-4 ">
                        <div class="form">
                            <form method="post" action="<?php echo base_url();?>login_controller/add_subject">
                                    <hr>
                                    <span style="color: midnightblue;" >
						              <center><h1>Add Subjects</h1></center>
					                </span>
                                <div class="form-group">
                                    <label for="username">Category</label>
                                    <select class="form-control" name="category">
                                        <option class="text-muted"></option>
                                        <?php
                                        if ($fetch_data->num_rows() > 0) {
                                            foreach ($fetch_data->result() as $row) {
                                                ?>
                                                <option name="category" value="<?php echo $row->category?>"><?php echo strtoupper(str_replace('_', ' ',$row->category ));?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                    <span class="text-danger"><?php echo form_error('category')?></span>
                                </div>
                                <div class="form-group">
                                    <label for="username">Subject Name</label>
                                    <input type="text" class="form-control" id="subject_name" name="subject_name" placeholder="Enter Subject Name"/>
                                    <span class="text-danger"><?php echo form_error('subject_name')?></span>
                                </div>
                                <div class="form-group">
                                    <label for="username">Subject Code</label>
                                    <input type="text" class="form-control" id="subject_code" name="subject_code" placeholder="Enter Subject Code"/>
                                    <span class="text-danger"><?php echo form_error('subject_code')?></span>
                                </div>
                                <div class="form-group">
                                    <label for="username">Year</label>
                                    <select class="form-control" name="year">
                                        <option class="text-muted"></option>
                                        <option name="year" value="1">1st year</option>
                                        <option name="year" value="2">2nd year</option>
                                        <option name="year" value="3">3rd year</option>
                                        <option name="year" value="4">4th year</option>
                                    </select>
                                    <span class="text-danger"><?php echo form_error('year')?></span>
                                </div>
                                <div class="form-group">
                                    <label for="username">Semester</label>
                                    <select class="form-control" name="semester">
                                        <option class="text-muted"></option>
                                        <option name="semester" value="1sem">1st semester</option>
                                        <option name="semester" value="2sem">2nd semester</option>
                                    </select>
                                    <span class="text-danger"><?php echo form_error('semester')?></span>
                                </div>
                                <center><button type="submit" class="btn btn-primary" name="submit" value="submit">Enter</button></center>
                            </form>
                            <hr/>
                        </div>
                    </div>
                </div>
            </div>

			-->
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
                url:"<?php echo base_url(); ?>live_search/fetchCategory",
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

