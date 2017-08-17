<?php
	session_start();
	ob_start();
	include('../includes/function.php');
	include('../includes/db.php');
	authenticate();
	$stmt=$conn->prepare("SELECT * FROM books");
	$stmt->execute();
	$rows=$stmt->fetchAll();
	$num_of_rows=$stmt->rowCount() - 1;	
	$admin_id=$_SESSION['admin_id'];
	$fetch=fetchAdminDetails($conn, $admin_id);
	extract($fetch);

	if(isset($_GET['deleteID'])){
		$deleteID=$_GET['deleteID'];
		$book_data=fetchBookDetails($conn, $deleteID);
		deleteBook($conn, $deleteID, $book_data['book_name']);
	}




	if(isset($_GET['logout'])){
		logoutCustomer();
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
	<title>View Books</title>
	<style>

		*{
			margin: 0;
			padding: 0;
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

		#cartBadge{
			background-color: red;
			vertical-align: top;
			position: relative;
			left: -3px;
			top: -2px;
			width: 27px;
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

		.image{
			margin: auto;
			display: block;
			width: 40%;
			position: relative;
			top: 10px;
		}

		.main-container{
			background-color: #f0f0f0;
			height: 2500px;
		}

		.book-container{
			display: inline-block;
			margin: 20px; 
			width: 20%;
			border: 1px solid #e4e3e3;
			border-radius: 20px;
			background-color: white;
			position: relative;
			top: 20px;
			left: 10px;
			height: 510px;
			text-align: center;
			vertical-align: top;
		}


		.image{
			width: 65%;
		}

		h3, h4{
			font-family: Montserrat;
		}

		h3{
			margin-top: 30px;
			margin-bottom: 15px;
		}

		.iconz{	
			font-size: 19px;
			color: white;
		}

		.functions {
			text-decoration: none;
			font-family: Montserrat;
			color: white;
			margin: 19px;
			font-size: 14px;	
			position: relative;
			top: 25px;
			border: 1px solid #2b2a2a;
			padding: 13px 13px;
			background-color: #2b2a2a;
			border-radius: 31px;
			cursor: pointer;
		}

		a.functions:hover{
			text-decoration: none;
			color: white;
		}

		.functions:hover, a.functions:hover{
			background-color: black;
			transition: 0.4s ease-in-out;
			border: 1px solid black;
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
			<li><a href="#" class="cat">View Books</a></li>
			<li>
				<a href="#" data-toggle="popover" title="Admin Details" data-content="Logged in as: <?php echo $fullName ?>" data-placement="bottom" data-trigger="focus">
					<span class="fa fa-user-circle iconss"></span>
				</a>
			</li>
			<li><a href="admin_home.php?logout"><span class="fa fa-power-off iconss"></span></a></li>
		</ul>
	</div>

	<div class="main-container">
		<?php
			for ($i=0; $i<=$num_of_rows; $i++){
			$book_image='../uploads/'.$rows[$i]['book_image'];
		?>
		<div class="book-container">
			<img src="<?php echo $book_image ?>" class="image">
			<h3> <?php echo $rows[$i]['book_name'] ?> </h3>
			<h4> By <?php echo $rows[$i]['author_name'] ?></h4>
			<h4> Category: <?php echo $rows[$i]['book_category'] ?></h4>
			<h4> <?php echo 'Year of release: '.$rows[$i]['year_of_release'] ?></h4>
			<h4> <?php echo 'N'.$rows[$i]['book_price'] ?></h4>
			<a href="edit_books.php?editID=<?php echo $rows[$i]['book_id'] ?>" class="functions"><span class="fa fa-pencil-square-o iconz"></span>    Edit</a>
			<a href="view_books.php?deleteID=<?php echo $rows[$i]['book_id'] ?>" class="functions"><span class="fa fa-trash-o iconz"></span>   Delete</a>
		</div>
		<?php
			}
		?>

	</div>


	

	<script>
		$(document).ready(function(){
    		$('[data-toggle="popover"]').popover(); 
		});
	</script>
	
</body>
</html>