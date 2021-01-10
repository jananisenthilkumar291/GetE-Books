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
				<h1 class="h2">Blogs</h1>
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
			  <h1> All Blogs</h1>
			  <a href = "newblog.php"><button class = "btn btn-info">Add New</button></a><br></br>
			  <table class="table">
				  <thead>
					<tr>
					  <th scope="col">Blog Id</th>
					  <th scope="col">Blog Image</th>
					  <th scope="col">Blog Title</th>
					  <th scope="col">Blog Description</th>
					  <th scope="col">Blog category</th>
					  <th scope="col">Action</th>
					</tr>
				  </thead>
			  <tbody>
			  <?php 
				$sql = "SELECT * FROM `blog` ORDER BY `blog_id` DESC";
				$result = mysqli_query($conn,$sql);
				while($row = mysqli_fetch_assoc($result)){
					$blog_title = $row['blog_title'];
					$blog_desc = $row['blog_desc'];
					$blog_category = $row['blog_category'];
					$blog_image = $row['blog_image'];
					$blog_id = $row['blog_id'];
					?>
					<tr>
						<th scope = "row"><?php echo $blog_id;?></th>
						<td scope = "row" ><img src = "../<?php echo $blog_image;?>" width = "50px" height = "50px"></td>
						<td scope = "row"><?php echo $blog_title;?></td>
						<td scope = "row"><?php echo $blog_desc;?></td>
						<td scope = "row"><?php echo $blog_category;?></td>
						<th scope = "row">
							<a href = "deleteblog.php?id=<?php echo $blog_id;?>"><button onclick = "return confirm('Are You Sure?')"class = "btn btn-danger">Delete</button></a>
							<a href = "editblog.php?id=<?php echo $blog_id;?>"><button class = "btn btn-warning">Edit</button></a>
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

