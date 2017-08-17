<?php
	session_start();
	ob_start();
	include('../includes/db.php');
	include('../includes/function.php');
	authenticate();
	$id=$_SESSION['admin_id'];
	$stmt=$conn->prepare("SELECT * FROM category");
	$stmt->bindParam(":id", $id);
	$stmt->execute();
	$rows=$stmt->fetchAll();
	$num_of_rows=$stmt->rowCount() - 1;
	$admin_id=$_SESSION['admin_id'];
	$fetch=fetchAdminDetails($conn, $admin_id);
	extract($fetch);


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
	<title>View Categories</title>
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

		.yuge{
			font-family: Montserrat;
			text-align: center;
			font-size: 100px;
			margin-bottom: 40px;
			color: black;
		}

		.table{
			position: relative;
			top: 25px;
			font-family: Montserrat;
			cursor: pointer;
			padding: 50px 10px;	
		}

		th{
			font-size: 23px;
		}

		.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
		    padding: 16px;
		    line-height: 1.42857143;
		    vertical-align: top;
		    border-top: 1px solid #ddd;
		    text-align: center;
		}

		.table>caption+thead>tr:first-child>td, .table>caption+thead>tr:first-child>th, .table>colgroup+thead>tr:first-child>td, .table>colgroup+thead>tr:first-child>th, .table>thead:first-child>tr:first-child>td, .table>thead:first-child>tr:first-child>th {
    			border-top: 0;
		    	background-color: #0d0d0d;
		    	color: white;
		    	position: relative;
		    	top: 4px;
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
	
	<table class="table table-hover">
		<thead>
			<tr>
				<th>Category ID</th>
				<th>Category Name</th>
			</tr>
		</thead>

		<tbody>
			<tr>
				<?php
					for ($i=0; $i<=$num_of_rows; $i++){
				?>

				<td> <?php echo $rows[$i]['category_id'] ?> </td>
				<td> <?php echo $rows[$i]['category_name'] ?> </td>
			</tr>

				<?php
					}
				?>
		</tbody>
	</table>

	<script>
		$(document).ready(function(){
    		$('[data-toggle="popover"]').popover(); 
		});
	</script>
</body>
</html>