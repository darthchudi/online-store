<?php
/*	if(array_key_exists('submit', $_POST)){
		$errors=[];
		if(empty($_POST['fname'])){
			$error[]="Enter first name";
		}

		if(empty($_POST['email'])){
			$error[]="Please enter email";
		}
	} 

	if(empty($errors)){
		$clean=array_map("trim", $_POST);
	}	
	*/

	function plural($item){
		return $item."z";
	}

	$data=["james", "mark", "hope"];
	$newArray=array_map("plural", $data);

	var_dump($newArray);

	function saymyName($name, $cb){
		echo $name.$cb();
	}

	/*$message= function (){
		return " loves respecting women";
	};*/

	$myName="<br> Chudi";
	saymyName($myName, function(){
		return " loves respecting ladies";
	});

	saymyName($myName, function(){
		return " is actually a drunk turtle";
	});

	function fetchCategories($cb){
		#Assuming the data has arrived
		$data=["Java", "Ruby", "Javascript", "PHP", "Elm", "R"];
		$cb($data);
	}

	fetchCategories(function($resultSet){
		echo "<br>";
		echo "<select>";
		foreach ($resultSet as $key => $value) {
			echo '<option value="'.$key.'">'.$value. '</option>';
		}
		echo "</select>";
	});

	fetchCategories(function($resultSet){
		echo "<br>";
		echo "<ul>";
		foreach ($resultSet as $key => $value) {
			echo '<li value="'.$key.'">'.$value.'</li>';
		}
		echo "</ul>";
	});

	if(array_key_exists('submit', $_POST)){
		$errors=[];
		echo "<hr/>";
	#	echo $_FILES['image']['type'];
		$FILE_MAX_SIZE=2097152;
		$allowed_extensions=["image/JPEG", "image/jpeg", "image/jpg", "image/PNG", "image/png"];
		$upload_dir="uploads/";

		if($_FILES['image']['size']>$FILE_MAX_SIZE){
			$errors[]= "File too large";
		}

		if(! in_array($_FILES['image']['type'], $allowed_extensions)){
			$errors[]="Wrong file sah";
		}	

		#Rename Files
		$random=rand(00000, 99999);
		$filename= $random.$_FILES['image']['name'];

		#prepare destination
		#Destination is usually upload directory + the name of the file
		$destination = $upload_dir.$filename;

		#Upload File
		if(! move_uploaded_file($_FILES['image']['tmp_name'], $destination)){
			$errors[]="Could not upload";
		}

		if(isset($errors)){
			echo "<br>";
			print_r($errors);
		}
		else{
			echo "Uploaded!";
		}
	}
?>


<!DOCTYPE html>
<html>
<head>
	<title>Test</title>
	<style>
		
	</style>
</head>
<body>
	<form method="post" action="">
		<p><input type="text" name="fname" placeholder="name"></p>
		<p><input type="text" name="email" placeholder="email"></p>
		<input type="submit" name="submit" value="register">
	</form>

	<br>
	<br>
	<br>

	<form method="post" action="" enctype="multipart/form-data">
		<input type="file" name="image">
		<input type="submit" name="submit" value="upload">
	</form>
</body>
</html>