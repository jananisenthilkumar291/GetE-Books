<?php 
include_once "../includes/functions.php";
include_once "../includes/connection.php";
session_start();
if (isset($_SESSION['user_role']) AND $_SESSION['user_role'] == "admin"){
	if($_SESSION['user_role'] == "admin"){
		?>
			<!doctype html>
<html lang = "en">
	<head>
		<title>Admin Panel</title>
		<meta name = "viewport" content = "width=device-width,initial-scale=1">
		<link rel = "Stylesheet" href = "../css/bootstrap.min.css">
	</head>
	<body>
		 <nav class="navbar navbar-dark sticky-top bg-dark  p-0 shadow">
		  <a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" href="#">CSBooks</a>
		  <ul class = "navbar-nav px-3">
			<li class="nav-item text-nowrap">
			  <a class="nav-link" href="logout.php">Log out</a>
			</li>
		  </ul>
		</nav>
		
		
		<div class="container-fluid">
		  <div class="row">
			<?php include_once "nav.inc.php";?>
			<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
			  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
				<h1 class="h2">Books</h1>
				<h6>Howdy  <?php echo $_SESSION['user_name']?>  | You are <?php echo $_SESSION['user_role']?></h6>
			  </div>
			  
			  <?php 
					if(isset($_GET['message'])){
						$msg = $_GET['message'];
						echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
								  <strong>'.$msg.'</strong>
								  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								  </button>
								</div>';
					}
					
			  ?>
			  
			  <div id = "admin-index-form">
			  <h1> All Books</h1>
			  <a href = "newbook.php"><button class = "btn btn-info">Add New</button></a><br></br>
			  <table class="table">
				  <thead>
					<tr>
					  <th scope="col">book Id</th>
					  <th scope="col">Book Image</th>
					  <th scope="col">Book Title</th>
					  <th scope="col">Book Author</th>
					  <th scope="col">Book category</th>
					  <th scope="col">Book content</th>
					  <th scope="col">Action</th>
					</tr>
				  </thead>
			  <tbody>
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
					<tr>
						<th scope = "row"><?php echo $book_id;?></th>
						<td scope = "row" ><img src = "../<?php echo $book_image;?>" width = "50px" height = "50px"></td>
						<td scope = "row"><?php echo $book_title;?></td>
						<td scope = "row"><?php echo $book_author;?></td>
						<td scope = "row"><?php echo $book_category;?></td>
						<th scope = "row"><a href = "<?php echo $book_content;?>"><button class = "btn btn-info">Content</button></a></th>
						<th scope = "row">
							<a href = "deletebook.php?id=<?php echo $book_id;?>"><button onclick = "return confirm('Are You Sure?')"class = "btn btn-danger">Delete</button></a>
							<a href = "editbook.php?id=<?php echo $book_id;?>"><button class = "btn btn-warning">Edit</button></a>
						</th>
					</tr>
					<?php
				}
			  ?>				
				</tbody>
			  </table>
			  </div>
			</main>
		  </div>
		</div>
		
		<script src = "../js/bootstrap.min.js"></script>
		<script src= "../js/scroll.js"></script>
		<script src= "../js/jquery.js"></script>
	</body>
</html>	

		
		<?php
	}
?>	
<?php
}else{
	header("Location:login.php?message=Please+Login");
}
?>

