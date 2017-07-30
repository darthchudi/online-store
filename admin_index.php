<?php
	session_start();
	ob_start();
	include('includes/function.php');
	include('includes/db.php');
	adminRedirect();
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
	<title>Admin Index</title>
	<style>
		*{
			margin: 0;
			padding: 0;
		}

		body{
			overflow-x: hidden;
		}

		#first{
			background-image: url('images/hehh.jpeg');
			background-size: cover;
			background-repeat: no-repeat;
			background: contain;
			height: 680px;
		}

		#logo{
			width: 14%;
			position: relative;
			top: -50px;
			left: 70px;	
		}

		ul{
			list-style: none;
		}

		li{
			display: inline;
		}

		li a{
			text-decoration: none;
			color: white;
			font-family: Montserrat;
			margin: 15px;
			font-size: 15px;
			position: relative;
			left: 68%;
			top: -245px;
			margin-bottom: 20px;
		}

		a#nav:hover{
			text-decoration: none;
			color: white;
			border-bottom: 2px solid white;
			padding-bottom: 5px;
		}

		a#nav:focus{
			outline: none;
		}

		.reg{
			border: 1px solid white;
			padding: 10px 18px;
			position: relative;
			left: 82%;
			top: -273px;
			border-radius: 31px;
		}

		a.reg:hover{
			color: black;
			text-decoration: none;
			background-color: white;
			transition: 0.6s ease-in-out;
		}

		a.reg:focus{
			outline: none;
			text-decoration: none;
			color: white;
		}

		hr{
			border: none;
			height: 0.6px;
			color: white;
			background-color: white;
			position: relative;	
			top: -180px;
			width: 100%;
		}

		input[type=text]#search{
			padding: 12px 10px;
			position: relative;
			border-radius: 31px;
			width: 25%;
			border: 1px solid white;
			font-family: Montserrat;
		}

		input[type=text]#search:focus{
			outline: none;
			color: white;
			transition: 0.6s ease-in-out;
			background-color: #2b2a2a;
			border: 1px solid #2b2a2a;
		}

		.name-wrapper{
			position: relative;
			left: 34%;
			top: -208px;
		}

		.user{
			position: absolute;
			left: 10px;
			font-size: 15px;
			color: #ccc;
			top: calc(50% - 0.5em);
		}

		input[type=text]#search{
			padding-left: 40px;
		}

		input:focus + .fa{
			color: white;
			transition: 0.7s ease-in-out;
		}

		#loginModal{
			top: 6%;
		}

		#registerModal{
			top: 1%;
		}

		#loginModal .modal-dialog, #registerModal .modal-dialog{
			width: 50%;
		}

		.loginForm, .registerForm{
			position: relative;
		}

		h1#modHead{
			font-family: Montserrat;
			text-align: center;
			font-size: 50px;
		}

		.modal-wrapper{
			position: relative;
			left: 25%;
		}

		input[type=email], input[type=password], .registerForm input[type=text]#names{
			padding: 15px 15px;
			margin: 10px;
			border: 1px solid #ccc;
			border-radius: 31px;
			width: 50%;
			padding-left: 40px;
			font-family: Montserrat;
		}

		input[type=submit]{
			padding: 15px 15px;
			margin: 10px;
			border: 1px solid #2b2a2a;
			background-color: #2b2a2a;
			color: white;
			border-radius: 31px;
			width: 50%;
			font-family: Montserrat;
		}

		input[type=submit]:hover{
			background-color: black;
			transition: 0.3s ease-in-out;
		}

		input[type=submit]:focus{
			outline: none;
		}

		input[type=email]:focus, input[type=password]:focus{
			outline: none;
			border: 1px solid black;
			transition: 0.7s ease-in-out;
		}

		.modalIcons{
			position: absolute;
			left: 23px;
			font-size: 15px;
			color: #545353;
			top: calc(50% - 0.5em);
		}

		input:focus + .modalIcons{
			color: black;
			transition: 0.7s ease-in-out;
		}

		#loginErrror{
			top: 4%;
		}

		#loginError{
			top: 15%;
		}

		#loginError .modal-dialog{
			width: 40%;
		}

		.errors{
			text-align: center;
		}

		p.errors{
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

		input[type=text]#names:focus{
			outline: none;
			border: 1px solid black;
			transition: 0.7s ease-in-out;
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

	</style>
</head>
<body>
	<div class="jumbotron" id="first">
		<img src="icons & logos/tribe-logo-white.png" id="logo">
		<form id="search-form">
			<div class="name-wrapper">
				<input type="text" name="search" placeholder="Search" id="search">
				<label for="searh" class="fa fa-search user"></label>
			</div>
		</form>
		<ul>
			<li><a href="index.php" id="nav">Home</a></li>
			<li><a href="catalogue.php" id="nav">Catalogue</a></li>
		</ul>
		<ul>
			<li><a href="#" class="reg" data-toggle="modal" data-target="#loginModal">Login</a></li>
			<li><a href="#" class="reg" data-toggle="modal" data-target="#registerModal">Register</a></li>
		</ul>
	</div>

	<!--BEGINNING OF MODALS !-->


	<!--Log In Modal !-->
	<div class="modal fade" role="dialog" id="loginModal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h1 class="modal-title" id="modHead">Admin Login</h1>
				</div>
				<div class="modal-body">

					<form class="loginForm" action="" method="post">
						<div class="modal-wrapper">
							<input type="email" name="email" placeholder="Email">
							<label class="fa fa-envelope modalIcons"></label>
						</div>

						<div class="modal-wrapper">
							<input type="password" name="password" placeholder="Password">
							<label class="fa fa-lock modalIcons"></label>
						</div>
						<div class="modal-wrapper">
							<input type="submit" name="login" value="Login">
						</div>

					</form>
				</div>
			</div>
		</div>
	</div>


	<!--Validation For Login Modal!-->
	<?php
		$errorsPresent="";
		$wrongDetails="";
		$keepOpen_log="";
		if(isset($_POST['login'])){
			$keepOpen_log="<script> $('#loginModal').modal('show') </script>";
			echo $keepOpen_log;
		}

		$error=array();
		if(array_key_exists('login', $_POST)){

			if(empty($_POST['email'])){
				$error[]="Enter email";
			}

			if(empty($_POST['password'])){
				$error[]="Enter password";
			}

			if(empty($error)){
				$clean=array_map('trim', $_POST);
				$methHead=login($conn, $clean);
				if($methHead[0]){
					header("Location: admin_home.php");
					$_SESSION['admin_id']=$methHead[1];
				}
				else{
					$wrongDetails=true;
				}	

			}
			else{
				$errorsPresent=true;
			}
		}
	?>

	<!--Login Error Modal !-->
	<div class="modal fade" role="dialog" id="loginError">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h1 id="modHead" class="modal-title">Oops...</h1>
				</div>

				<div class="modal-body">
					<?php
						if($errorsPresent == true ){
							foreach($error as $err){
								echo '<p class="errors">'.$err."</p>";
							}
						}
						
						if($wrongDetails == true){
							$showMsg="Invalid username or password";
							echo '<p class="errors">'.$showMsg.'</p>';
						}
					?>
				</div>
			</div>
		</div>
	</div>

	<!--Script for Login Modal !-->
	<?php
		if($errorsPresent || $wrongDetails){

	?>
	<script>
		$("#loginError").modal("show");
	</script>
	<?php
		}
	?>

	<!--Register Modal !-->
	<div class="modal fade" role="dialog" id="registerModal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h1 class="modal-title" id="modHead">Admin Register</h1>
				</div>
				<div class="modal-body">
					<form class="registerForm" action="" method="post">
						<div class="modal-wrapper">
							<input type="text" name="fname" placeholder="First Name" id="names">
							<label class="fa fa-user-o modalIcons"></label>
						</div>
					
						<div class="modal-wrapper">
							<input type="text" name="lname" placeholder="Last Name" id="names">
							<label for="lname" class="fa fa-user-o modalIcons"></label>
						</div>

						<div class="modal-wrapper">
							<input type="email" name="email" placeholder="Email Address">
							<label for="email" class="fa fa-envelope modalIcons"></label>
						</div>

						<div class="modal-wrapper">
							<input type="password" name="password" placeholder="Password">
							<label for="pword" class="fa fa-lock modalIcons"></label>
						</div>

						<div class="modal-wrapper">
							<input type="password" name="pword" placeholder="Confirm Password">
							<label for="c_pword" class="fa fa-lock modalIcons"></label>
						</div>

						<div class="modal-wrapper">
							<input type="submit" name="register" value="Register">
						</div>	
					</form>
				</div>
			</div>
		</div>
	</div>

	<!--Validation for Register Modal !-->
	<?php
		if(isset($_POST['register'])){
			$keepOpen_reg="<script> $('#registerModal').modal('show'); </script>";
			echo $keepOpen_reg;
		}
		$errorReg=array();
		$created_account="";
		$register_errors="";
		if(array_key_exists('register', $_POST)){
			if(empty($_POST['fname'])){
				$errorReg['fname']="Enter first name";
			}

			if(empty($_POST['lname'])){
				$errorReg['lname']="Enter last name";
			}

			if(empty($_POST['email'])){
				$errorReg['email']="Enter email";
			}

			if(empty($_POST['password'])){
				$errorReg['password']="Enter password";
			}

			if($_POST['password']!=$_POST['pword']){
				$errorReg['wrongP']="Password mismatch";
			}

			if(empty($errorReg)){
				$clean=array_map('trim', $_POST);
				register($conn, $clean);
				$created_account=true;
			}
			else{
				$register_errors=true;
			}
		}
	?>

	<!--Registeration Success Notification Moddal !-->
	<div id="success" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h1 id="modHead" class="modal-title">Success</h1>
				</div>
				<div class="modal-body">
					<p class="success-text">Sucessfully Signed Up</p>
				</div>
			</div>
		</div>
	</div>

	<!-- Registeration Form Error Modal !-->
	<div id="registerErrorModal" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h1 id="modHead" class="modal-title">Oops...</h1>
					</div>
					<div class="modal-body">
						<?php foreach($errorReg as $err){
						echo '<p class="errors">'.$err."</p>";
							}
						?>
					</div>
				</div>
			</div>
		</div>

	<?php
		if($register_errors){
	?>

	<script>
		$("#registerErrorModal").modal('show');
	</script>

	<?php
		}

		if($created_account){
	?>

	<script>
		$("#success").modal('show');
	</script>

	<?php
		}
	?>

	<!--END OF MODALS !-->






</body>
</html>



