<?php
	session_start();
	ob_start();
	include('includes/function.php');
	include('includes/db.php');
	authenticate();
	$admin_id=$_SESSION['admin_id'];
	$fetch=fetchAdminDetails($conn, $admin_id);
	extract($fetch);

	if(isset($_GET['logout'])){
		logout();
	}
	
?>

<!DOCTYPE html>
<html language="en">
<head>
	<meta charset="utf-8">
	<meta ttp-equiv="X-UA-Compatible" content="IE=edge">
   	<meta name="viewport" content="width=device-width, initial-scale=1">
   	<link href="../font awesome/css/font-awesome.min.css" rel="stylesheet">
   	<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
   	<script src="../bootstrap/js/jquery-3.2.1.js"></script>
   	<script src="../bootstrap/js/bootstrap.min.js"> </script>
	<title>Admin Home</title>
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

		.directory{
			text-align: center;
		}


		.dir{
			font-size: 60px;
			color: white;
		}

		h1{
			font-family: Montserrat;
			color: white;
			font-size: 18px;
		}

		.dir-box{
			display: inline-block;
			margin: 60px 90px;
			text-align: center;
			border: 2px solid black;
			padding: 30px 80px;
			border-radius: 31px;
			background-color: black;
		}

		.dir-box:hover{
			background-color: white;
			transition: 0.4s ease-in-out;
			cursor: pointer;
		} 

		.dir-box:hover h1, .dir-box:hover .dir{
			color: black;
		}

		.dir-box a, .dir-box a:hover{
			text-decoration: none;
		}
	</style>
</head>
<body>
	<div class="nav-container">
		<a href="admin_home.php"> <img src="icons & logos/tribe-logo-white.png" id="logo"> </a>
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

	<div class="directory">
		<div class="dir-box">
			<a href="add_books.php"><i class="fa fa-book dir"></i></a>
			<a href="add_books.php"><h1>Add Book</h1></a>
		</div>

		<div class="dir-box">
			<a href="add_category.php"><i class="fa fa-tags dir"></i></a>
			<a href="add_category.php"><h1>Add Category</h1></a>
		</div>

		<br>
		<div class="dir-box">
			<a href="view_books.php"><i class="fa fa-eye dir"></i></a>
			<a href="view_books.php"><h1>View Books</h1></a>
		</div>

		<div class="dir-box">
			<a href="view_category.php"><i class="fa fa-eye dir"></i></a>
			<a href="view_category.php"><h1>View Categories </h1></a>
		</div>
		
		
	</div>



	
	

	<script>
		$(document).ready(function(){
    		$('[data-toggle="popover"]').popover(); 
		});
</script>
	
</body>
</html>