<?php
	session_start();
	include('../includes/db.php');
	include('../includes/function.php');
	authenticate();
	$admin_id=$_SESSION['admin_id'];
	$fetch=fetchAdminDetails($conn, $admin_id);
	extract($fetch);

	$error=array();
	$success="";
	$nope="";
	$existsAlready="";
	if(array_key_exists('add', $_POST)){
		if(empty($_POST['category_name'])){
			$error['category_name']="Enter catgeory name";
		}

		if(empty($error)){
			$clean=array_map('trim', $_POST);
			$clean_cat=$clean['category_name'];
			
			$outcome=addCategory($conn, $admin_id, $clean_cat, $fullName);
			if($outcome){
				$success=true;
			}
			else{
				$existsAlready=true;
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
	<title>Add Category</title>
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

		.icons{
			font-size: 16px;
		}

		.icons:hover{
			color: #918e8d;
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

		#form{
			text-align: center;
			position: relative;
			top: 80px;
		}

		input[type=text]#cat{
			padding: 25px 20px;
			border: 2px solid #7f7f7f;
			border-radius: 15px;
			font-family: Montserrat;
			color: black;
			width: 25%;
		}

		input[type=text]#cat:focus{
			border: 2px solid #2b2a2a;
			background-color: #2b2a2a;
			color: white;
			transition: 0.5s ease-in-out;
			outline: none;
		}

		input[type=submit]{
			padding: 20px 10px;
			width: 25%;
			position: relative;
			top: 55px;
			font-family: Montserrat;
			color: white;
			background-color: #2b2a2a;
			border: 2px solid #2b2a2a;
			border-radius: 31px;
		}

		input[type=submit]:hover, input[type=submit]:focus{
			background-color: black;
			border: 2px solid black;
			transition: 0.4s ease-in-out;
			outline: none;
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
					<span class="fa fa-user-circle icons"></span>
				</a>
			</li>
			<li><a href="admin_home.php?logout"><span class="fa fa-power-off icons"></span></a></li>
		</ul>
	</div>

	<div>
		<form action="" method="post" id="form">
			<div class="name-wrap">
				<p><input type="text" name="category_name" placeholder="Catgeory Name" id="cat"></p>
			</div>
			<p><input type="submit" name="add" value="Submit"></p>
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
					<p class="success-text">Sucessfully Added Category</p>
				</div>
			</div>
		</div>
	</div>


	<!--No Input Error Notification Moddal !-->
	<div id="error" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h1 id="modHead" class="modal-title">Oops...</h1>
				</div>
				<div class="modal-body">
					<p class="error-text">Enter category name</p>
				</div>
			</div>
		</div>
	</div>

	<!--Category Exists already Error Notification Moddal !-->
	<div id="catExists" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h1 id="modHead" class="modal-title">Oops...</h1>
				</div>
				<div class="modal-body">
					<p class="error-text">Category exists already</p>
				</div>
			</div>
		</div>
	</div>

	<?php
		if($success){
	?>

	<script>
		$("#success").modal('show');
	</script>

	<?php
		}

		if($nope){
	?>

	<script>
		$("#error").modal('show');
	</script>

	<?php
		}

		if($existsAlready){
	?>

	<script>
		$("#catExists").modal('show');
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