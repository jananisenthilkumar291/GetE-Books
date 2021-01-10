<?php 
	include_once "includes/functions.php";
	include_once "includes/connection.php";
	session_start();
	if(!isset($_GET['id'])){
		header("Location:index.php?geterr");
		exit();
	}
	else{
		$id = mysqli_real_escape_string($conn,$_GET['id']);
		if(!is_numeric($id)){
			header("Location:index.php?numerr");
			exit();
		}else{
			$sql = "SELECT * FROM `category` WHERE `category_id` = '$id'";
			$result = mysqli_query($conn,$sql);
			if(mysqli_num_rows($result) <= 0){
				header("Location:index.php?noresulttt");
				exit();
			}else{
				?>
<!doctype html>
<html lang = "en">
	<head>
		<title>Category</title>
		<meta name = "viewport" content = "width=device-width,initial-scale=1">
		<link rel = "Stylesheet" href = "css/bootstrap.min.css">
	</head>
	</body>
		<!-- 	including NAVBAR	-->
		<?php include_once "includes/navigation.php";?>
		<!-- 	NAVBAR	 -->
		<div class = "container">
			<h4>Showing all books and blogs of category : <?php getCategoryName($id);?></h4><br></br>
			<div class = "card-columns">
				<?php 
					$sql = "SELECT * FROM `book` WHERE `book_category` = '$id' ORDER BY book_id DESC";
					$result = mysqli_query($conn,$sql);
					while($row = mysqli_fetch_assoc($result)){
						$book_title = $row['book_title'];
						$book_image = $row['book_image'];
						$book_author = $row['book_author'];
						$book_category = $row['book_category'];
						$book_content = $row['book_content'];
						$book_id = $row['book_id'];
						?>
							<div class = "card" style = "width:18rem;">
								<img class="card-img-top" src="<?php echo $book_image; ?>" alt="Card image cap">
								<div class="card-body">
								<h5 class="card-title"><?php echo $book_title; ?></h5>
								<h6 class="card-subtitle mb-2 text-muted"><?php echo $book_author;?></h6>
								<button class = "btn btn-info"><a style = "color:white"  href = "<?php echo $book_content;?>">Content</a></button><br></br>
								</div>
							</div>
							<?php
					}
				?>
				
			</div>
			<div class = "card-columns">
				<?php 
					$sqlblog = "SELECT * FROM `blog` WHERE `blog_category` = '$id' ORDER BY blog_id DESC";
					$resultblog = mysqli_query($conn,$sqlblog);
					while($row = mysqli_fetch_assoc($resultblog)){
						$blog_title = $row['blog_title'];
						$blog_image = $row['blog_image'];
						$blog_desc = $row['blog_desc'];
						$blog_category = $row['blog_category'];
						$blog_content = $row['blog_content'];
						$blog_id = $row['blog_id'];
						?>
							<div class = "card" style = "width:18rem;">
								<img class="card-img-top" src="<?php echo $blog_image; ?>" alt="Card image cap">
								<div class="card-body">
								<h5 class="card-title"><?php echo $blog_title; ?></h5>
								<h6 class="card-subtitle mb-2 text-muted"><?php echo $blog_desc;?></h6>
								<a href = "blog.php?id=<?php echo $blog_id;?>"><button class = "btn btn-success">Open Blog</button></a><br></br>
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
		}
	}
?>