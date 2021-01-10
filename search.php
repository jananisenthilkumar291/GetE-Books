<?php 
include_once "includes/connection.php";
include_once "includes/functions.php";
session_start();
	if(!isset($_GET['s'])){
		header("Location:index.php");
		exit();
	}else{
		$search = mysqli_real_escape_string($conn,$_GET['s']);
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
		<?php add_jumbotron();?>
		<br>
		<div class ="container">
		<h3>Showing result for search <?php echo $search;?></h3>
			<div class = "card-columns">
			<?php 
				$sql = "SELECT * FROM `book` WHERE `book_title` LIKE '%$search%' OR `book_category` LIKE '%$search%';";
				$result = mysqli_query($conn,$sql);
				if(mysqli_num_rows($result) <= 0){echo "No Results Found";
				}
				while($row = mysqli_fetch_assoc($result)){
					$book_title = $row['book_title'];
					$book_author = $row['book_author'];
					$book_category = $row['book_category'];
					$book_content = $row['book_content'];
					$book_image = $row['book_image'];
					$book_id = $row['book_id'];
					?>
					<div class="card" style="width: 18rem;margin:5%;border-radius:90px;background:transparent;border:0px;">
					  <img class = "card-img-top shadow" src = "<?php echo $book_image;?>" style = "border-radius:90px;" alt = "Card image cap">
					  <div class="card-body">
						<h5 class="card-title"><?php echo $book_title;?></h5>
						<h6 class="card-subtitle " style = "color:black;"><?php echo $book_author?></h6><br>
						<a href="<?php echo $book_content;?>" style = "color:black;background-color:grey;border-radius:5px;
						" class="card-link p-3 shadow">Open Book</a>
					  </div>
					</div>
					<?php
				}
			?>	
			</div>
			<h4>Blogs Related To Your Search:</h4>
			<div class = "card-columns">
			<?php 
				$sqlblog = "SELECT * FROM `blog` WHERE `blog_title` LIKE '%$search%' OR `blog_category` LIKE '%$search%' OR `blog_desc` LIKE '%$search%' OR `blog_content` LIKE '%$search%';";
				$resultblog = mysqli_query($conn,$sqlblog);
				if(mysqli_num_rows($resultblog) <= 0){echo "No Results Found";
				}
				while($row = mysqli_fetch_assoc($resultblog)){
					$blog_title = $row['blog_title'];
					$blog_desc = $row['blog_desc'];
					$blog_category = $row['blog_category'];
					$blog_content = $row['blog_content'];
					$blog_image = $row['blog_image'];
					$blog_id = $row['blog_id'];
					?>
					<div class="card" style="width: 18rem;margin:5%;background:transparent;border:0px;">
					  <img class = "card-img-top shadow" src = "<?php echo $blog_image;?>" alt = "Card image cap">
					  <div class="card-body">
						<h5 class="card-title"><?php echo $blog_title;?></h5>
						<h6 class="card-subtitle " style = "color:black;"><?php echo $blog_desc?></h6><br>
						<a href = "blog.php?id=<?php echo $blog_id;?>"><button class = "btn btn-success">Open Blog</button></a>
					  </div>
					</div>
					<?php
				}
			?>	
			</div>
		</div>
		
		<script src= "js/jquery.js"></script>
		<script src = "js/bootstrap.min.js"></script>
		<script src= "js/scroll.js"></script>
	</body>
</html>		
		<?php
	}

?>