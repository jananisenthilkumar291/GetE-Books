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
		<br>
		<div class ="container">
		<div class = "card-columns p-0 shadow" style = "margin:auto;border-radius:70px;background-color:lightgrey;border:10px solid #686F73;">
		<?php 
			$sql = "SELECT * FROM `book` ORDER BY `book_id` DESC";
			$result = mysqli_query($conn,$sql);
			while($row = mysqli_fetch_assoc($result)){
				$book_title = $row['book_title'];
				$book_author = $row['book_author'];
				$book_category = $row['book_category'];
				$book_content = $row['book_content'];
				$book_image = $row['book_image'];
				$book_id = $row['book_id'];
				?>
				<div class="card" style="width:18rem;margin:5%;border-radius:70px;background-color:lightgrey;border:0px;">
				  <img class = "card-img-top p-0 shadow" src = "<?php echo $book_image;?>" style = "border-radius:70px;" alt = "Card image cap">
				  <div class="card-body">
					<h5 class="card-title"><?php echo $book_title;?></h5>
					<h6 class="card-subtitle mb-2 text-muted"><?php echo $book_author?></h6>
					<a href="<?php echo $book_content;?>" class="card-link">Open Book</a>
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