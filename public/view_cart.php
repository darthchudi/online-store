<?php
	session_start();
	ob_start();
	include('../includes/db.php');
	include('../includes/function.php');
	userAuthenticate();
	$customer_id=$_SESSION['loginId'];
	$stmt=$conn->prepare("SELECT * FROM cart WHERE customer_id=:id");
	$stmt->bindParam(":id", $customer_id);
	$stmt->execute();
	$rows=$stmt->fetchAll();
	$num_of_rows=$stmt->rowCount() - 1;
	$customer_info=fetchCustomerDetails($conn, $customer_id);
	$customerFullName=$customer_info['firstName'].' '.$customer_info['lastName'];
	$cartItems="";
	$cartItems=fetchNumItemsInCart($conn, $customer_id);

	emptyBook($conn, $customer_id);

	if(isset($_GET['delete'])){
			$deleteID=$_GET['delete'];
			deleteFromCart($conn, $deleteID);
	}

	if(isset($_GET['increase'])){
		$increaseID=$_GET['increase'];
		increaseQuantity($conn, $increaseID);
	}

	if(isset($_GET['decrease'])){
		$decreaseID=$_GET['decrease'];
		decreaseQuantity($conn, $decreaseID);
	}

	if(array_key_exists('checkout', $_POST)){
		checkout($conn, $customer_id);
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
	<title>View Cart</title>
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

	input[type=submit]{
		display: inline;
	}

	.table{
		position: relative;
		top: 20px;
		font-family: Montserrat;
		cursor: pointer;
		padding: 50px 10px;	
	}

	.table a{
		color: black;
		border: 1px solid black;
		padding: 10px 15px;
		border-radius: 28px;
		text-decoration: none;
	}

	.table a:hover{
		background-color: black;
		color: white;
		transition: 0.3s ease-in-out;
	}

	th{
		font-size: 23px;
	}

	.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
	    padding: 16px;
	    line-height: 1.42857143;
	    vertical-align: top;
	    border-top: 1px solid #ddd;
	}

	.table>caption+thead>tr:first-child>td, .table>caption+thead>tr:first-child>th, .table>colgroup+thead>tr:first-child>td, .table>colgroup+thead>tr:first-child>th, .table>thead:first-child>tr:first-child>td, .table>thead:first-child>tr:first-child>th {
			border-top: 0;
	    	background-color: #0d0d0d;
	    	color: white;
	    	position: relative;
	    	top: 4px;
	}

	.formBox{
		text-align: center;
	}

	input[type=submit]{
		margin-top: 50px;
		text-align: center;
		padding: 14px 14px;
		border-radius: 31px;
		width: 50%;
		background-color: #3db451;
		border: 1px solid #3db451;
		font-family: Montserrat;
		color: white;
		font-size: 20px;
	}

	input[type=submit]:hover, input[type=submit]:focus{
		outline: none;
		border: 1px solid #388545;
		background-color: #388545	;
		transition: 0.3s ease-in-out;
	}


	.quantity{
		width: 9%;
		border: none;
	}

	a.quanLink{
		border: none;
	}

	</style>
</head>
<body>
	<div class="nav-container">
		<a href="catalogue.php"> <img src="../styles/icons & logos/tribe-logo-white.png" id="logo"> </a>
		<form id="search-form">
			<div class="name-wrapper">
				<input type="text" name="search" placeholder="Search" id="search">
				<label for="searh" class="fa fa-search user"></label>
			</div>
		</form>
		<ul>
			<li><a href="catalogue.php" class="cat">View Catalogue</a></li>
			<li>
				<a href="view_cart.php">
					<span class="fa fa-shopping-cart icons"></span>
					<label class="badge" id="cartBadge"><?php echo $cartItems ?></label>
				</a>
			</li>
			<li>
				<a href="#" data-toggle="popover" title="User Details" data-content="Logged in as: <?php echo $customerFullName ?>" data-placement="bottom" data-trigger="focus">
					<span class="fa fa-user-circle icons"></span>
				</a>
			</li>
			<li><a href="Catalogue.php?logout"><span class="fa fa-power-off icons"></span></a></li>
		</ul>
	</div>

	<table class="table table-hover">
		<thead>
			<tr>
				<th>Book Name</th>
				<th>Author</th>
				<th>Category</th>
				<th>Book Price</th>
				<th>Quantity</th>
				<th>Increase</th>
				<th>Decrease</th>
				<th>Remove</th>
			</tr>
		</thead>

		<tbody>
			<tr>
				<?php
					for ($i=0; $i<=$num_of_rows; $i++){
				?>

				<td> <?php echo $rows[$i]['book_name'] ?> </td>
				<td> <?php echo $rows[$i]['author_name'] ?> </td>
				<td> <?php echo $rows[$i]['book_category'] ?></td>
				<td>  <?php echo $rows[$i]['book_price'] ?></td>
				<td>  <?php echo $rows[$i]['quantity'] ?></td>
				<td><a href="view_cart.php?increase=<?php echo $rows[$i]['order_id'] ?>"  class="quanLink"><img src="icons & logos/increase.png" class="quantity"></a></td>
				<td><a href="view_cart.php?decrease=<?php echo $rows[$i]['order_id'] ?>" class="quanLink"><img src="icons & logos/decrease.png" class="quantity"></a></td>
				<td><a href="view_cart.php?delete=<?php echo $rows[$i]['order_id'] ?>"> Delete </a></td>
				
			</tr>

				<?php
					}
				?>
		</tbody>
	</table>

	<?php
		if($cartItems>0){
	?>

	<div class="formBox">
		<form action="" method="post">
			<input type="submit" name="checkout" value="Checkout">
		</form>
	</div>

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