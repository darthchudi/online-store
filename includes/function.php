<?php
	function doesEmailExist($dbconn, $input){
		$result=false;
		$stmt = $dbconn->prepare("SELECT * FROM admin WHERE email=:em");
		$stmt->bindParam(":em", $input);
		$stmt->execute();
		if($stmt->rowCount() > 0){
			$result=true;
		}
		return $result;
	}


	function register($dbconn, $input){
		$hash=password_hash($input['password'], PASSWORD_BCRYPT);
		$stmt=$dbconn->prepare("INSERT INTO admin(firstname, lastname, email, password) VALUES(:fname, :lname, :email, :pword)");
		$data=[":fname"=>$input['fname'], 
				":lname"=>$input['lname'],
				":email"=>$input['email'],
				":pword"=>$hash
			];
		$stmt->execute($data);
	}

	function displayErrors($errors, $field){
		$result="";
		if(isset($errors[$field])){
			$result ='<p>'.$errors[$field]. '</p>';
		}
		return $result;
	}

	function login($dbconn, $input){
		$correct=array();
		$stmt=$dbconn->prepare("SELECT * FROM admin WHERE email=:email");
		$stmt->bindParam(":email", $input['email']);
		$stmt->execute();
		$row=$stmt->fetch(PDO::FETCH_ASSOC);
		if($stmt->rowCount() > 0){
			if(password_verify($input['password'], $row['password'])){
				$correct[]=true;
				$correct[]=$row['admin_id'];
				return $correct;
			}
		}
	}

	function authenticate(){
		if(!isset($_SESSION['admin_id'])){
			header("Location:admin_index.php");
		}
	}

	function userAuthenticate(){
		if(!isset($_SESSION['loginId'])){
			header("Location:index.php");
		}
	}

	function logout(){
		unset($_SESSION['admin_id']);
		header("Location: admin_index.php");
	}

	function logoutCustomer(){
		unset($_SESSION['loginId']);
		header("Location: index.php");
	}

	function adminRedirect(){
		if(isset($_SESSION['admin_id'])){
			header("Location: admin_home.php");
		}
	}

	function customerRedirect(){
		if(isset($_SESSION['loginId'])){
			header("Location: catalogue.php");
		}
	}



	function fetchAdminDetails($dbconn, $admin_id){
		$stmt=$dbconn->prepare("SELECT * FROM admin WHERE admin_id=:id");
		$stmt->bindParam(":id", $admin_id);
		$stmt->execute();
		$rows=$stmt->fetch(PDO::FETCH_ASSOC);
		$admin=array();
		$admin['firstName']=$rows['firstname'];
		$admin['lastName']=$rows['lastname'];
		$admin['email']=$rows['email'];
		$admin['fullName']= $rows['firstname'].' '.$rows['lastname'];
		return $admin;
	}

	function addCategory($dbconn, $admin_id, $input, $fullName){
		$stmt=$dbconn->prepare("SELECT category_name FROM category WHERE category_name=:name_check");
		$stmt->bindParam(":name_check", $input);
		$stmt->execute();
		if($stmt->rowCount() < 1){
		$stmt=$dbconn->prepare("INSERT INTO
		 category(category_name, admin_id, admin_name) 
		 VALUES(:input, :admin_id, :fullName)");
		$data=[":input"=>$input, ":admin_id"=>$admin_id,
				":fullName"=>$fullName];
		$stmt->execute($data);
		$result=true;
		}
		else{
			$result=false;
		}
		return $result;
	}

	function fetchCategories($dbconn){
		$stmt=$dbconn->prepare("SELECT category_name FROM category");
		$stmt->execute();
		$rows=$stmt->fetchAll(PDO::FETCH_COLUMN);	
		return $rows;
	}

	function addProducts($dbconn, $input, $image){
		$stmt=$dbconn->prepare("INSERT INTO books(book_name, book_category, author_name, year_of_release, book_price, book_image) 
			VALUES(:book_name, :book_category, :author_name, :year_of_release, :book_price, :book_image )");
		$data=[":book_name"=>$input['book_name'],
				":book_category"=>$input['book_category'],
				":author_name"=>$input['author_name'],
				":year_of_release"=>$input['year'],
				":book_price"=>$input['book_price'],
				":book_image"=>$image
		];
		$stmt->execute($data);
		return true;
	}

	function addToCart($dbconn, $id, $customer_id, $customerFullName){
		$stmt=$dbconn->prepare("SELECT * FROM books WHERE book_id=:id");
		$stmt->bindParam(":id", $id);
		$stmt->execute();
		$rows=$stmt->fetchAll();


		$stmt=$dbconn->prepare("SELECT book_name, quantity FROM cart WHERE book_id=:book_id AND customer_id=:customer_id");
		$check=[":book_id"=>$id, ":customer_id"=>$customer_id];
		$stmt->execute($check);
		$book_details=$stmt->fetch(PDO::FETCH_ASSOC);

		if($stmt->rowCount() > 0){
			$quantity=$book_details['quantity'];
			$quantity+=1;

			$stmt=$dbconn->prepare("UPDATE cart SET quantity=:quantity WHERE book_name=:book_name AND customer_id=:customer_id");
			$data=[ ":quantity"=>$quantity, ":book_name"=>$rows[0]['book_name'], ":customer_id"=>$customer_id];
			$stmt->execute($data);
			header("Location:catalogue.php");
			return true;
		}

		else{
			$quantity=1;
			$stmt=$dbconn->prepare("INSERT INTO cart(book_name, book_id, author_name, book_category, book_price, quantity, customer_name, customer_id) 
								VALUES(:book_name, :book_id, :author_name, :book_category, :book_price, :quantity,  :customer_name, :customer_id)");
			$data=[":book_name"=>$rows[0]['book_name'],
				":book_id"=>$id,
				":author_name"=>$rows[0]['author_name'],
				":book_category"=>$rows[0]['book_category'],
				":book_price"=>$rows[0]['book_price'],
				":quantity"=>$quantity,
				":customer_name"=>$customerFullName,
				":customer_id"=>$customer_id
			];
			$stmt->execute($data);
			header("Location:catalogue.php");
			return true;
		}

		
	}

	function fetchNumItemsInCart($dbconn, $id){
		$stmt=$dbconn->prepare("SELECT quantity FROM cart WHERE customer_id= :id");
		$stmt->bindParam(":id", $id);
		$stmt->execute();
		$count=$stmt->rowCount()-1;
		$stuff=$stmt->fetchAll(PDO::FETCH_COLUMN);
		$items=0;
		for ($i=0; $i<=$count; $i++){
			$items+=$stuff[$i];
		}
		return $items;
	}

	function customerRegister($dbconn, $input){
		$hash=password_hash($input['password'], PASSWORD_BCRYPT);
		$stmt=$dbconn->prepare("INSERT INTO customer(firstname, lastname, email, password) VALUES(:fname, :lname, :email, :pword)");
		$data=[":fname"=>$input['fname'], 
				":lname"=>$input['lname'],
				":email"=>$input['email'],
				":pword"=>$hash
			];
		$stmt->execute($data);
	}

	function customerLogin($dbconn, $input){
		$correct=array();
		$stmt=$dbconn->prepare("SELECT * FROM customer WHERE email=:email");
		$stmt->bindParam(":email", $input['email']);
		$stmt->execute();
		$row=$stmt->fetch(PDO::FETCH_ASSOC);
		if($stmt->rowCount() > 0){
			if(password_verify($input['password'], $row['password'])){
				$correct[]=true;
				$correct[]=$row['customer_id'];
				return $correct;
			}
		}
	}

	function fetchCustomerDetails($dbconn, $customer_id){
		$stmt=$dbconn->prepare("SELECT * FROM customer WHERE customer_id=:id");
		$stmt->bindParam(":id", $customer_id);
		$stmt->execute();
		$rows=$stmt->fetch(PDO::FETCH_ASSOC);
		$customer=array();
		$customer['firstName']=$rows['firstname'];
		$customer['lastName']=$rows['lastname'];
		$customer['email']=$rows['email'];
		$customer['fullName']= $rows['firstname'].' '.$rows['lastname'];
		return $customer;
	}

	function editCategory($dbconn, $input, $id){
		$stmt=$dbconn->prepare("UPDATE category SET category_name=:ca WHERE category_id=:id");
		$data=[":ca"=>$input,
				":id"=>$id];
		$stmt->execute($data);
		header("Location:view_category.php");
	}

	function deleteFromCart($dbconn, $orderID){
		$stmt=$dbconn->prepare("DELETE FROM cart WHERE order_id=:order_id");
		$stmt->bindParam(":order_id", $orderID);
		$stmt->execute();
		header("Location:view_cart.php");
		return true;
	}

	function checkout($dbconn, $id){
		$stmt=$dbconn->prepare("DELETE FROM cart WHERE customer_id=:customer_id");
		$stmt->bindParam(":customer_id", $id);
		$stmt->execute();
		header("Location: view_cart.php");
		return true;
	}

	function deleteBook($dbconn, $book_id, $book_name){
		$stmt=$dbconn->prepare("DELETE FROM books WHERE book_id=:book_id");
		$stmt->bindParam(":book_id", $book_id);
		$stmt->execute();


		$stmt=$dbconn->prepare("DELETE FROM cart WHERE book_name=:book_name");
		$stmt->bindParam(":book_name", $book_name);
		$stmt->execute();
		header("Location:view_books.php");
	}

	function fetchBookDetails($dbconn, $book_id){
		$stmt=$dbconn->prepare("SELECT * FROM books WHERE book_id=:book_id");
		$stmt->bindParam(":book_id", $book_id);
		$stmt->execute();
		$rows=$stmt->fetch(PDO::FETCH_ASSOC);
		return $rows;
	}

	function editBook($dbconn, $input, $book_id){
		$stmt=$dbconn->prepare("UPDATE books SET book_name=:book_name, book_category=:book_category, author_name=:author_name, year_of_release=:year, book_price=:book_price  
			WHERE book_id=:book_id");
		$data=[":book_name"=>$input['book_name'],
			  	":book_category"=>$input['book_category'],
			  	":author_name"=>$input['author_name'],
			  	":year"=>$input['year'],
			  	":book_price"=>$input['book_price'],
			  	":book_id"=>$book_id
		];
		$stmt->execute($data);
		return true;
	}

	function increaseQuantity($dbconn, $id){
		$stmt=$dbconn->prepare("SELECT quantity FROM cart WHERE order_id=:id");
		$stmt->bindParam(":id", $id);
		$stmt->execute();
		$row=$stmt->fetch(PDO::FETCH_ASSOC);
		$quantity=$row['quantity'];

		$quantity+=1;

		$stmt=$dbconn->prepare("UPDATE cart SET quantity=:quantity WHERE order_id=:order_id");
		$data=[":quantity"=>$quantity, ":order_id"=>$id];
		$stmt->execute($data);

		header("Location:view_cart.php");
	}

	function decreaseQuantity($dbconn, $id){
		$stmt=$dbconn->prepare("SELECT quantity FROM cart WHERE order_id=:id");
		$stmt->bindParam(":id", $id);
		$stmt->execute();
		$row=$stmt->fetch(PDO::FETCH_ASSOC);
		$quantity=$row['quantity'];

		$quantity-=1;

		$stmt=$dbconn->prepare("UPDATE cart SET quantity=:quantity WHERE order_id=:order_id");
		$data=[":quantity"=>$quantity, ":order_id"=>$id];
		$stmt->execute($data);

		header("Location:view_cart.php");
	}

	function emptyBook($dbconn, $customer_id){
		$stmt=$dbconn->prepare("SELECT order_id, quantity FROM cart WHERE customer_id=:customer_id ");
		$stmt->bindParam(":customer_id", $customer_id);
		$stmt->execute();
		$num_of_rows=$stmt->rowCount() -1 ;
		$rows=$stmt->fetchAll();

		for($i=0; $i<=$num_of_rows; $i++){
			if($rows[$i]['quantity'] ==0){
				deleteFromCart($dbconn, $rows[$i]['order_id']);
			}
		}
	}



?>