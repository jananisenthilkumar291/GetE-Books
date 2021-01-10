<?php 
include "../includes/connection.php";
session_start();
if(!isset($_GET['id'])){
	header("Location:blogs.php");
}else{
	if(!isset($_SESSION['user_role'])){
		header("Location:login.php?message=Please+Log+In");
	}else{
		if($_SESSION['user_role'] != 'admin'){
			echo "You Can Not ACCESS!";
			exit();
		}else if($_SESSION['user_role'] == 'admin'){
			$id = $_GET['id'];
			
			$sqlcheck = "SELECT * FROM `blog` WHERE blog_id = '$id';";
			$result = mysqli_query($conn,$sql);
			if(mysqli_num_rows($result) <= 0){
				header("Location:blogs.php?message=No+Such+File");
				exit();
			}
			$sql = "DELETE FROM `blog` WHERE blog_id = '$id'";
			if(mysqli_query($conn,$sql)){
				header("Location:blogs.php?message=Succesfully+Deleted");
			}else{
				header("Location:blogs.php?message=Could+Not+Delete");
			}
		}
	}
}
?>