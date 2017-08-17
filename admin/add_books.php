<?php
	session_start();
	include('../includes/db.php');
	include('../includes/function.php');
	authenticate();
	$admin_id=$_SESSION['admin_id'];
	$fetch=fetchAdminDetails($conn, $admin_id);
	extract($fetch);
	$categories=fetchCategories($conn);
	$years=array();

	for ($i=1990; $i<=2017; $i++){ 
		$years[]=$i;
	}

	$error=array();
	$image_error="";
	$success="";
	$nope="";
	if(array_key_exists('submit', $_POST)){
		if(empty($_POST['book_name'])){
			$error['book_name']="Enter a book name";
		}

		if(empty($_POST['book_category'])){
			$error['book_category']="Enter a book category";
		}

		if(empty($_POST['author_name'])){
			$error['author_name']="Enter an author name";
		}

		if(empty($_POST['year'])){
			$error['year']="Select a year";
		}

		if(empty($_POST['book_price'])){
			$error['book_price']="Select a book price";
		}

		if(empty($_FILES['image'])){
			$error['files']="Please select an image";
		}

		$FILE_MAX_SIZE=2097152;
		$allowed_extensions= ['image/JPEG', 'image/jpg', 'image/jpeg', 'image/PNG', 'image/png'];
		$upload_dir="../uploads/";

		if($_FILES['image']['size']>$FILE_MAX_SIZE){
			$error['large_file']="File too large";
		}

		if(! in_array($_FILES['image']['type'], $allowed_extensions)){
			$error['incompatible']="File not compatible";
		}
		#Randomize name
		$random=rand(00000, 99999);
		$filename=$random.'_'.$_FILES['image']['name'];
		#Prepare Destination
		$destination=$upload_dir.$filename;

		if(empty($error)){
			$clean=array_map('trim', $_POST);
			if(!move_uploaded_file($_FILES['image']['tmp_name'], $destination)){
				$image_error=true;
			}

			
			$outcome = addProducts($conn, $clean, $filename);
			if($outcome){
				$success=true;
			}
		}

		else{
			$nope=true;
		}

	}
?>

<!DOCTYPE html>
<html language="en">
<head>
	<meta charset="utf-8">
	<meta ttp-equiv="X-UA-Compatible" content="IE=edge">
   	<meta name="viewport" content="width=device-width, initial-scale=1">
   	<link href="../styles/font awesome/css/font-awesome.min.css" rel="stylesheet">
   	<link href="../styles/bootstrap/css/bootstrap.min.css" rel="stylesheet">
   	<script src="../styles/bootstrap/js/jquery-3.2.1.js"></script>
   	<script src="../styles/bootstrap/js/bootstrap.min.js"> </script>
	<title>Add Books</title>
	<style>

		*{
			margin: 0;
			padding: 0;
		}

		body{
			overflow-x: hidden;
		}

		.nav-container{
			width: 100%;
			background-color: black;
			height: 73px;
		}

		#logo{
			width: 10%;
			position: relative;
			position: relative;
			top: -5px;
		}

		input[type=text]#search{
			padding: 12px 10px;
			position: relative;
			border-radius: 31px;
			width: 25%;
			border: 1px solid white;
			font-family: Montserrat;
			padding-left: 40px;
		}

		input[type=text]#search:focus{
			outline: none;
			color: white;
			transition: 0.6s ease-in-out;
			background-color: #2b2a2a;
			border: 1px solid #2b2a2a;
		}

		.user{
			position: absolute;
			left: 10px;
			font-size: 15px;
			color: black;
			top: calc(50% - 0.5em);
		}

		input:focus + .user{
			color: white;
			transition: 0.7s ease-in-out;
		}

		.name-wrapper{
			position: relative;
			left: 34%;
			top: -120px;
		}

		.iconss{
			font-size: 16px;
		}

		.iconss:hover{
			color: #918e8d;
		}


		ul{
			list-style: none;
		}

		ul li a{
			font-family: Montserrat;
			text-decoration: none;
			color: white;
		}

		li a:hover{
			text-decoration: none;
			color: white;
		}

		li a:focus{
			text-decoration: none;
			color: white;
		}

		.cat:hover{
			border-bottom: 3px solid white;
			padding-bottom: 5px;
			color: white;
		}

		li{
			display: inline;
			position: relative;
			left: 940px;
			top: -155px;
			font-size: 17px;
			margin: 20px;
		}


		.popover{
			width: 900px;
		}

		.popover-title{
			text-align: center;
			font-family: Montserrat;
			font-size: 16px;
			position: relative;
		}

		.popover-content{
			text-align: center;
			font-family: Montserrat;
		}

		.success-text{
			text-align: center;
		}

		p.success-text{
			font-family: helvetica;
			text-align: center;
			margin: 10px;
			color: white;
			padding: 20px 14px;
			background-color: #479449;
			border: 1px solid #479449;
			border-radius: 5px;
			cursor: pointer;
		}

		#modHead{
			text-align: center;
			font-family: Montserrat;
			font-size: 50px;
		}

		p.error-text{
			font-family: helvetica;
			text-align: center;
			margin: 10px;
			color: white;
			padding: 20px 14px;
			background-color: #bc3737;
			border: 1px solid #bc3737;
			border-radius: 5px;
			cursor: pointer;
		}

		.icons{
			position: absolute;
			left: 30px;
			font-size: 16px;
			color: black;
			top: calc(50% - 0.5em);
		}

		.form-wrapper{
			position: relative;
			left: 33%; 
			top: 30px;
		}

		input[type=text]#details, select, input[type=submit]{
			margin: 15px;
			padding: 15px 15px;
			border: 1px solid #2b2a2a;
			width: 28%;
			border-radius: 31px;
			font-family: Montserrat;
		}

		input[type=file]{
			margin: 15px;
		}

		input[type=text]#details, select{
			padding-left: 50px;
		}

		input[type=text]#details:focus, select:focus{
			color: white;
			outline: none;
			color: white;
			transition: 0.6s ease-in-out;
			background-color: #2b2a2a;
			border: 1px solid #2b2a2a;
		}

		input:focus + .icons, select:focus + .icons{
			color: white;
			transition: 0.6s ease-in-out;
		}

		input[type=submit]{
			color: white;
			background-color: #2b2a2a;
			border: 1px solid #2b2a2a;
		}

		input[type=submit]:hover{
			border: 1px solid black;
			background-color: black;
			transition: 0.4s ease-in-out;
		}

		input[type=submit]:focus{
			outline: none;
		}






	</style>
</head>
<body>
	<div class="nav-container">
		<a href="admin_home.php"> <img src="../styles/icons & logos/tribe-logo-white.png" id="logo"> </a>
		<form id="search-form">
			<div class="name-wrapper">
				<input type="text" name="search" placeholder="Search" id="search">
				<label for="searh" class="fa fa-search user"></label>
			</div>
		</form>
		<ul>
			<li><a href="add_books.php" class="cat">Add Books</a></li>
			<li><a href="view_books.php" class="cat">View Books</a></li>
			<li>
				<a href="#" data-toggle="popover" title="Admin Details" data-content="Logged in as: <?php echo $fullName ?>" data-placement="bottom" data-trigger="focus">
					<span class="fa fa-user-circle iconss"></span>
				</a>
			</li>
			<li><a href="admin_home.php?logout"><span class="fa fa-power-off iconss"></span></a></li>
		</ul>
	</div>



	<div>
		<form action="" method="post" enctype="multipart/form-data" id="form">
			<div class="form-wrapper">
				<input type="text" name="book_name" placeholder="Book Name" id="details">
				<label for="bookName" class="fa fa-book icons"></label>
			</div>

			<div class="form-wrapper">
				<select name="book_category" id="details">
					<option value="">Select Book category</option>
					<?php
						foreach ($categories as $key => $value) {
					?>
					<option value="<?php echo $value ?>"> <?php echo $value; ?> </option>
					<?php
						}
					?>
				</select>
				<label for="bookName" class="fa fa-tag icons"></label>
			</div>

			<div class="form-wrapper">
				<input type="text" name="author_name" placeholder="Author Name" id="details">
				<label for="author" class="fa fa-user icons"></label>
			</div>

			<div class="form-wrapper">
				<select name="year" id="details">
					<option value="">Year of Release</option>
					<?php
						foreach ($years as $key => $value) {
					?>
					<option value="<?php echo $value ?>"> <?php echo $value ?> </option>
					<?php
						}
					?>
				</select>
				<label for="author" class="fa fa-calendar icons"></label>
			</div>

			<div class="form-wrapper">
				<input type="text" name="book_price" placeholder="Book Price" id="details">
				<label for="author" class="fa fa-money icons"></label>
			</div>

			<div class="form-wrapper">
				<input type="file" name="image" id="details"/>
			</div>
			
			<div class="form-wrapper">
				<p><input type="submit" name="submit" value="Add Book" id="details"></p>
			</div>
		</form>
	</div>



	<!--Add Category Success Notification Moddal !-->
	<div id="success" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h1 id="modHead" class="modal-title">Success</h1>
				</div>
				<div class="modal-body">
					<p class="success-text">Sucessfully Added Book</p>
				</div>
			</div>
		</div>
	</div>


	<!--Error Notification Moddal !-->
	<div id="error" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h1 id="modHead" class="modal-title">Oops...</h1>
				</div>
				<div class="modal-body">
					<?php
						foreach ($error as $key => $value) {
					?>
					<p class="error-text"><?php echo $value ?></p>

					<?php
						}
					?>
				</div>
			</div>
		</div>
	</div>

	<!--Image Error Notification Moddal !-->
	<div id="imageError" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h1 id="modHead" class="modal-title">Oops...</h1>
				</div>
				<div class="modal-body">
					<p class="error-text"> Error Uploading Error </p>
				</div>
			</div>
		</div>
	</div>

	

	<?php
		if($nope){
	?>

	<script>
		$("#error").modal('show');
	</script>

	<?php
		}

		if($success){
	?>

	<script>
		$("#success").modal('show');
	</script>

	<?php
		}

		if($image_error){
	?>

	<script>
		$("#imageError").modal('show');
	</script>

	<?php
		}
	?>







	<script>
		$(document).ready(function(){
    		$('[data-toggle="popover"]').popover(); 
		});
	</script>
	
</body>
</html>