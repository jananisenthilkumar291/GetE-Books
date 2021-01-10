<?php 
	include_once "../includes/connection.php";
	session_start();
	if(!isset($_POST['submit'])){
		header("Location:category.php");
		exit();
	}else{
		if(!isset($_SESSION['user_role'])){
			header("Location:login.php");			
			exit();
		}else{
			if($_SESSION['user_role'] != "admin"){
				echo "You Cannot Access This Page";
				exit();
			}else if($_SESSION['user_role'] == "admin"){
				$category_name = $_POST['category_name'];
				$sql = "INSERT INTO category ( `category_name`) VALUES ('$category_name');";
				if(mysqli_query($conn,$sql)){
					header("Location:categories.php?message=Added");
					exit();
				}else{
					header("Location:categories.php?message=Error");
					exit();
				}
			}
		}
	}

?>