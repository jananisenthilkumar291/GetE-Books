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
		<div class="jumbotron jumbotron-fluid">
			  <div class="container">
				<h1 class="display-4"><?php getSettingValue("home_jumbo_title")?></h1>
				<p class="lead"><?php getSettingValue("home_jumbo_desc")?></p>
			  </div>
		<br>
		</div>
		<div class ="container">
		<?php 
			//pagination
			$sqlpg = "SELECT * FROM `book`;";
			$resultpg = mysqli_query($conn,$sqlpg);
			$totalbooks = mysqli_num_rows($resultpg);
			$totalbookpages = ceil($totalbooks/6);
		?>
		<?php 
			//pagination get
			if(isset($_GET['p'])){
				$pageid = $_GET['p'];
				$start = ($pageid * 6) - 6;
				$sql = "SELECT * FROM `book` ORDER BY `book_id` DESC LIMIT $start,6";
			}else{
				$sql = "SELECT * FROM `book` ORDER BY `book_id` DESC LIMIT 0,6";
			}
		?>
			<div class = "card-columns">
			<?php 
				$result = mysqli_query($conn,$sql);
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
			<?php 
				echo '<center>';
				for($i = 1;$i <= $totalbookpages;$i++){
					?>
						<a href = "?p=<?php echo $i;?>"><button class = "btn btn-info"><?php  echo $i; ?></button></a>&nbsp;
					<?php
				}
				echo '</center>';
			?>
		</div>
		<hr>
		<div class ="container">
		<?php 
			//pagination
			$sqlpgblog = "SELECT * FROM `blog`;";
			$resultpgblog = mysqli_query($conn,$sqlpgblog);
			$totalblogs = mysqli_num_rows($resultpgblog);
			$totalblogpages = ceil($totalblogs/6);
		?>
		<?php 
			//pagination get
			if(isset($_GET['pp'])){
				$pageidblog = $_GET['pp'];
				$startblog = ($pageidblog * 6) - 6;
				$sqlblog = "SELECT * FROM `blog` ORDER BY `blog_id` DESC LIMIT $startblog,6";
			}else{
				$sqlblog = "SELECT * FROM `blog` ORDER BY `blog_id` DESC LIMIT 0,6";
			}
		?>
			<div class = "card-columns">
			<?php 
				$resultblog = mysqli_query($conn,$sqlblog);
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
						<a href = "blog.php?id=<?php echo $blog_id;?>"><button class = "btn btn-info">Open Blog</button></a>
					  </div>
					</div>
					<?php
				}
			?>
				
			</div>
			<?php 
				echo '<center>';
				for($i = 1;$i <= $totalblogpages;$i++){
					?>
						<a href = "?p=<?php echo $i;?>"><button class = "btn btn-info"><?php  echo $i; ?></button></a>&nbsp;
					<?php
				}
				echo '</center>';
			?>
		</div>
		
		<script src= "js/jquery.js"></script>
		<script src = "js/bootstrap.min.js"></script>
		<script src= "js/scroll.js"></script>
	</body>
</html>