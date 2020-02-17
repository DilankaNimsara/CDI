<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>User Guide</title>
	<?php include 'header.php';
	include 'autologout.php'; ?>
</head>
<body>


<div class="container-fluid">
	<div class="row content">
		<div class="col-sm-2">
			<?php
			if ($this->session->userdata('username') != '') {
				include 'sidenav.php';
			} else { ?>
				<?php
			} ?>
		</div>
		<br/>
		<div class="col-sm-10">
			<div class="well well-lg tx;">
			<div class="ex33forguid">
				<div style="color: whitesmoke;">
					<h1><center>User Guide</center></h1>
					<h1><center>Mr.Doc - Document Management System</center></h1>
					<h3>Introduction</h3>

					<p>Mr. Doc is a document management system that we are developing mainly for a university regarding the yearly evaluations. So basically there are a lot of finalized documents gather in a year regarding the evaluation of the lectures and the subjects. So this will be the place to store those data according to subject vise, lecturer vise and in the relevant years.
					So here this will help to search the relevant reports from the system, store reports and the reports will annotate the relevant parts regarding what we are looking for.
					</p>

					<h3>Key features of the system</h3>

					<p>So here the features of the system are personalized according to their role. So here basically the access privilege is given according to an hierarchical manner.
					</p>

					<h3>QAC and QAC staff</h3>
					<ul>
						<li>Create accounts.</li>
						<li>Upload documents.</li>
						<li>View documents.</li>
						<li>Manage accounts.</li>
						<li>Manage users.</li>
						<li>Download documents.</li>
						<li>Send messages.</li>
						<li>Make comments.</li>
						<li>Delete documents.</li>
						<li>Update document details.</li>
						<li>Make system changes.</li>
					</ul>

					<h3>Head of Institute</h3>
					<ul>
						<li>Have access to all documents.</li>
						<li>Make comments.</li>
						<li>Download documents.</li>
						<li>Send message(nortifications)to all users.</li>
					</ul>

					<h3>Head of Courses</h3>
					<ul>
						<li>All documents of relevant degree program can be viewed(eg: Undergraduate)</li>
						<li>Download documents.</li>
						<li>Send messages(notifications) to all users of the relevant degree program.</li>
					</ul>

					<h3>Course coordinators</h3>
					<ul>
						<li>All documents of relevant courses.</li>
						<li>Make comments in the documents.</li>
						<li>Send messages(notifications) to all users of course.</li>
					</ul>

					<h3>Lecturers</h3>
					<ul>
						<li>View documents.</li>
						<li>Download documents.</li>
						<li>Add comments.</li>
					</ul>

					<h3>Minimum pc requirements</h3>
					<ul>
						<li>The machine should be connected to the wifi.</li>
					</ul>

					<h3>Get Started…</h3>

					<p>So here at the very beginning of the application athe admin account should be created and create the database.
					So first with the code of <b>locallhost/CDI/config.php</b> it can create the database.
						This is done by the Admin</p>

					<center><img width="75%" src="<?php echo base_url();?>/public/img/img1.PNG"></center>

					<h3>Create accounts</h3>

					<p>Here the admin can create the user accounts. So here when creating the accounts it should give the relevant post to give the access privilege to the users.
					When the account is created the password is auto generated and send an e mail to the user.
						So here the create accounts can be done by the<b> Head of QAC and Staff.</b></p>

					<center><img width="75%" src="<?php echo base_url();?>/public/img/img2.PNG"></center>

					<h3>Uploading Documents</h3>

					<p>To upload documents it should create the subjects and categories in the document settings. Once you create the categories and relevant subjects in those categories it can upload the documents to the system.
					So here the categories and subjects should add in Undergraduate, Postgraduate and External degree programs.
					</p>

					<center><img width="75%" src="<?php echo base_url();?>/public/img/img3.PNG"></center><br/>
					<center><img width="75%" src="<?php echo base_url();?>/public/img/img4.PNG"></center>

					<p>So after adding the subjects it can upload the documents to the system easily. So here the document upload can be done by the Head of QAC and Staff.
					</p>

					<h3>View Documents</h3>

					<p>Here all the actors in the system can view their documents. So here according to the relevant access privileges everyone can view documents.
					</p>

					<center><img width="75%" src="<?php echo base_url();?>/public/img/img5.PNG"></center>

					<h3>Sending messages.</h3>

					<p>So here Heads of the course, QAC, Course coordinators can send messages, important notices to the lectures and the members of the QAC staff.
					</p>

					<center><img width="75%" src="<?php echo base_url();?>/public/img/img6.PNG"></center>




				</div>
			</div>
		</div>
	</div>
</div>
</div>
<?php include 'footer.php'; ?>
</body>
</html>


