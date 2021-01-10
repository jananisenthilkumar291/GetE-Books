<?php 
include_once "../includes/functions.php";
include_once "../includes/connection.php";
session_start();
if (isset($_SESSION['user_role'])){
?>
<!doctype html>
<html lang = "en">
	<head>
		<title>New Book</title>
		<meta name = "viewport" content = "width=device-width,initial-scale=1">
		<link rel = "Stylesheet" href = "../css/bootstrap.min.css">
	</head>
	<body>
		
		 <nav class="navbar navbar-dark sticky-top bg-dark  p-0 shadow">
		  <a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" href="index.php">CSBooks</a>		  
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
				<h1 class="h2">Add New Blog</h1>
				<h6>Howdy  <?php echo $_SESSION['user_name']?>  | You are <?php echo $_SESSION['user_role']?></h6>
			  </div>
			  
			  <?php 
					if(isset($_GET['message'])){
						$msg = $_GET['message'];
						echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
				'.$msg.'
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				  </button>
				</div>';
					}
					
			  ?>
			  
			  <form enctype = "multipart/form-data" method = "post">
				Blog Title:
				<input placeholder = "Enter Blog Title" name = "blog_title" class = "form-control" type = "text"><br>
				Blog Description:
				<input placeholder = "Enter Blog Description" name = "blog_desc" class = "form-control" type = "text"><br>
				Blog Category:
				<select name="blog_category" class="form-control" id="exampleFormControlSelect1">
				<?php 
					$sql = "SELECT * FROM `category`";
					$result = mysqli_query($conn,$sql);
					while($row = mysqli_fetch_assoc($result)){
						?>						
							<option value = "<?php echo $row['category_id']?>"><?php echo $row['category_name'];?></option>
						<?php
					}
				?>
				</select><br>
				Blog Content:
				<textarea name="blog_content" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea><br>
				Blog Image:
				<input type = "file" name = "blog_image" class = "form-control-file" id = "exampleFormControlFile"><br>
				<input class = "btn btn-info" type = "submit" name = "submit">
			  </form>
			  <?php 
				if(isset($_POST['submit'])){
					$blog_title = mysqli_real_escape_string($conn,$_POST['blog_title']);
					$blog_category = mysqli_real_escape_string($conn,$_POST['blog_category']);
					$blog_desc = mysqli_real_escape_string($conn,$_POST['blog_desc']);
					$blog_content = mysqli_real_escape_string($conn,$_POST['blog_content']);
					//checking for empty fields
					if(empty($blog_title) OR empty($blog_category) OR empty($blog_desc)){
						header("Location:newblog.php?message=Empty+Fields");
						exit();
					}
					$file = $_FILES['blog_image'];
						$fileName = $file['name'];
						$fileType = $file['type'];
						$fileTmp = $file['tmp_name'];
						$fileErr = $file['error'];
						$fileSize = $file['size'];
						$fileEXT = explode('.',$fileName);
						$fileExtension = strtolower(end($fileEXT));
						$allowedExt = array("jpg", "jpeg", "png", "gif");
						if(in_array($fileExtension, $allowedExt)){
							if(($fileErr === 0)){
								if($fileSize < 3000000){
									$newFileName = uniqid('',true).'.'.$fileExtension;
									$destination = "../uploads/$newFileName";
									$dbdestination = "uploads/$newFileName";
									move_uploaded_file($fileTmp, $destination);
									$sql = "INSERT INTO blog (`blog_title`,`blog_category`,`blog_content`,  `blog_image`,`blog_desc`) VALUES ('$blog_title', '$blog_category','$blog_content', '$dbdestination','$blog_desc');";
									if(mysqli_query($conn, $sql)){
										header("Location: blogs.php?message=Blog+Published");
									}else{
										header("Location: newblog.php?message=Error");
									}
								} else {
									header("Location: newblog.php?message=YOUR+FILE+IS+TOO+BIG+TO+UPLOAD!");
									exit();
								}
							}else{
								header("Location: newblog.php?message=Oops+Error+Uploading+your+file");
								exit();
							}
						}else{
							header("Location: newblog.php?message=YOUR+FILE+IS+TOO+BIG+TO+UPLOAD!");
							exit();
						}
					}
			  ?>
			</main>
		  </div>
		</div>
		
		<script src = "../js/bootstrap.min.js"></script>
		<script src= "../js/scroll.js"></script>
		<script src= "../js/jquery.js"></script>
		
		<script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=ey5ln3e6qq2sq6u5ka28g3yxtbiyj11zs8l6qyfegao3c0su"></script>

		<script>tinymce.init({ selector:'textarea' });</script>
	</body>
</html>	
<?php
}else{
	header("Location:login.php?message=Please+Login");
}
?>

