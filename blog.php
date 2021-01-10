<?php
	include_once "includes/connection.php";
	include_once "includes/functions.php";
	if(!isset($_GET['id'])){
		header("Location:blogs.php?message=Not+Found");
		exit();
	}else{
		$id = mysqli_real_escape_string($conn,$_GET['id']);
		if(!is_numeric($id)){
			header("Location:blogs.php?numerr");
		}else{
			$sql = "SELECT * FROM `blog` WHERE blog_id = '$id'";
			$result = mysqli_query($conn,$sql);
			if(mysqli_num_rows($result) <= 0){
				header("Location:blogs.php?noresult");
			}else{
				while($row = mysqli_fetch_assoc($result)){
					$blog_title = $row['blog_title'];
					$blog_desc = $row['blog_desc'];
					$blog_category = $row['blog_category'];
					$blog_content = $row['blog_content'];
					$blog_image = $row['blog_image'];
					?>
					<?php 
include_once "includes/functions.php";
include_once "includes/connection.php";
session_start();
?>

<!doctype html>
<html lang = "en">
	<head>
		<title>CSBooks</title>
		<meta name = "viewport" content = "width=device-width,initial-scale=1">
		<link rel = "Stylesheet" href = "css/bootstrap.min.css">
	</head>
	<body>
		<!-- 	including NAVBAR	-->
		<?php include_once "includes/navigation.php";?>
		<!-- 	NAVBAR	 -->
		<div class="jumbotron jumbotron-fluid" style = background-color:lightgrey;>
			  <div class="container">
				<h1 class="display-4"><?php getSettingValue("home_jumbo_title")?></h1>
				<p class="lead"><?php getSettingValue("home_jumbo_desc")?></p>
			  </div>
		<br>
		</div><br></br>
		<div class = "container" style = "width:50%;">
			<img src = "<?php echo $blog_image;?>">
		</div>
		<div class = "container" style = "width:50%;">
			<h2><?php echo $blog_title;?></h2>
			<h4 style = "color:darkgrey;"><?php echo $blog_desc;?></h4>
			<p style = "color:grey;"><?php echo $blog_content;?></p>
		</div>
		
		<script src= "js/jquery.js"></script>
		<script src = "js/bootstrap.min.js"></script>
		<script src= "js/scroll.js"></script>
	</body>
</html>
					<?php
				}
			}
			
		}
		
	}
?>