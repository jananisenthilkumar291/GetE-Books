<?php 
include_once "../includes/functions.php";
include_once "../includes/connection.php";
session_start();
if (isset($_SESSION['user_role']) AND $_SESSION['user_role'] == "admin" AND isset($_GET['id'])){
?>
<!doctype html>
<html lang = "en">
	<head>
		<title>Edit Blog</title>
		<link rel = "Stylesheet" href = "../css/bootstrap.min.css">
		<link rel = "stylesheet" href = "../css/customstyle.css">
	</head>
	<body>
		 <nav class="navbar navbar-dark sticky-top bg-dark  p-0 shadow">
		  <a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" href="#">CSBooks</a>		  
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
				<h1 class="h2">Edit Blog</h1>
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
				$blog_id = $_GET['id'];
				$formsql = "SELECT * FROM `blog` WHERE `blog_id` = '$blog_id' ";
				$formresult = mysqli_query($conn,$formsql);
				while($formrow = mysqli_fetch_assoc($formresult)){
					$blog_title = $formrow['blog_title'];
					$blog_content = $formrow['blog_content'];
					$blog_image = $formrow['blog_image'];
					$blog_desc = $formrow['blog_desc'];
			  ?>
			  <form enctype = "multipart/form-data" method = "post">
				Blog Title:
				<input placeholder = "Enter Blog Title" name = "blog_title" class = "form-control" value = "<?php echo $blog_title;?>" type = "text"><br>
				Blog Description:
				<input placeholder = "Enter Blog Description" value = "<?php echo $blog_desc;?>" name = "blog_desc" class = "form-control" type = "text"><br>
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
				<strong>Blog Content:</strong>
				<textarea name="blog_content" class="form-control" id="exampleFormControlTextarea1" rows="3" value = "<?php echo $blog_content;?>" ></textarea><br>
				<strong>Blog Image:</strong><br>
				Existing Image - <br><img width = "150px" height = "150px" src = "../<?php echo $blog_image;?>"><br></br>
				New Image - <input class = "btn btn-warning" type = "file" name = "blog_image" class = "form-control-file" id = "exampleFormControlFile"><br></br>
				<input class = "btn btn-info" type = "submit" name = "update">
			  </form>
		<?php   } ?>
			  <?php 
				if(isset($_POST['update'])){
					$blog_title = mysqli_real_escape_string($conn,$_POST['blog_title']);
					$blog_desc = mysqli_real_escape_string($conn,$_POST['blog_desc']);
					$blog_content = mysqli_real_escape_string($conn,$_POST['blog_content']);
					//checking for empty fields
					if(empty($blog_title) OR empty($blog_desc) OR empty($blog_content)){
						header("Location:editblog.php?message=Empty+Fields");
						exit();
					}
					if(is_uploaded_file($_FILES['blog_image']['tmp_name'])){
						//user wants to update file
						$file = $_FILES['blog_image'];
							$fileName = $file['name'];
							$fileType = $file['type'];
							$fileTmp = $file['tmp_name'];
							$fileErr = $file['error'];
							$fileSize = $file['size'];
							$fileEXT = explode('.',$fileName);
							$fileExtension = strtolower(end($fileEXT));
							$allowedExt = array("jpg", "jpeg", "png", "gif");
							if((in_array($fileExtension, $allowedExt))){
								if(($fileErr === 0)){
									if(($fileSize < 3000000)){
										$newFileName = uniqid('',true).'.'.$fileExtension;
										$destination = "../uploads/$newFileName";
										$dbdestination = "uploads/$newFileName";
										move_uploaded_file($fileTmp, $destination);
										$sql = "UPDATE `blog` SET blog_title = '$blog_title',blog_content = '$blog_content',blog_desc = '$blog_desc',blog_image = '$dbdestination' 	WHERE blog_id = '$blog_id';";
										if(mysqli_query($conn, $sql)){
											header("Location: blogs.php?message=Blog+Updated");
										}else{
											header("Location: editblog.php?message=Error");
										}
									} else {
										header("Location: editblog.php?message=YOUR+FILE+IS+TOO+BIG+TO+UPLOAD!");
										exit();
									}
								}else{
									header("Location: editblog.php?message=Oops+Error+Uploading+your+file");
									exit();
								}
							}else{
								header("Location: editblog.php?message=YOUR+FILE+IS+TOO+BIG+TO+UPLOAD!");
								exit();
							}
					}else{
						//users doesnt want to update
						$sql = "UPDATE `blog` SET blog_title = '$blog_title',blog_content = '$blog_content',blog_desc = '$blog_desc' WHERE blog_id = '$blog_id';";
						if(mysqli_query($conn, $sql)){
							header("Location: blogs.php?message=Blog+Updated");
						}else{
							header("Location: editblog.php?message=Error");
						}
					}
				} ?>
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