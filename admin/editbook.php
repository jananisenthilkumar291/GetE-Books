<?php 
include_once "../includes/functions.php";
include_once "../includes/connection.php";
session_start();
if (isset($_SESSION['user_role']) AND $_SESSION['user_role'] == "admin" AND isset($_GET['id'])){
?>
<!doctype html>
<html lang = "en">
	<head>
		<title>New Book</title>
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
				<h1 class="h2">Edit Book</h1>
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
				$book_id = $_GET['id'];
				$formsql = "SELECT * FROM `book` WHERE `book_id` = '$book_id' ";
				$formresult = mysqli_query($conn,$formsql);
				while($formrow = mysqli_fetch_assoc($formresult)){
					$book_title = $formrow['book_title'];
					$book_content = $formrow['book_content'];
					$book_image = $formrow['book_image'];
					$book_author = $formrow['book_author'];
			  ?>
			  <form enctype = "multipart/form-data" method = "post">
				Book Title:
				<input placeholder = "Enter Book Title" name = "book_title" class = "form-control" value = "<?php echo $book_title;?>" type = "text"><br>
				Book author:
				<input placeholder = "Enter Book Author Name" value = "<?php echo $book_author;?>" name = "book_author" class = "form-control" type = "text"><br>
				Book Category:
				<select name="book_category" class="form-control" id="exampleFormControlSelect1">
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
				<strong>Book Content:</strong>
				Existing Content - 
				<button class = "btn btn-info"><a style = "color:white"  href = "../<?php echo $book_content;?>">Content</a></button><br></br>
				New Content - <input class = "btn btn-warning" type = "file" name = "book_content" value = "<?php echo $book_content;?>" class = "form-control-file" id = "exampleFormControlFile"><br>
				<strong>Book Image:</strong><br>
				Existing Image - <br><img width = "150px" height = "150px" src = "../<?php echo $book_image;?>"><br></br>
				New Image - <input class = "btn btn-warning" type = "file" name = "book_image" class = "form-control-file" id = "exampleFormControlFile"><br></br>
				<input class = "btn btn-info" type = "submit" name = "update">
			  </form>
		<?php   } ?>
			  <?php 
				if(isset($_POST['update'])){
					$book_title = mysqli_real_escape_string($conn,$_POST['book_title']);
					$book_author = mysqli_real_escape_string($conn,$_POST['book_author']);
					//checking for empty fields
					if(empty($book_title) OR empty($book_author)){
						header("Location:newbook.php?message=Empty+Fields");
						exit();
					}
					if(is_uploaded_file($_FILES['book_image']['tmp_name'])){
						//user wants to update file
						$file = $_FILES['book_image'];
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
										$sql = "UPDATE `book` SET book_title = '$book_title',book_author = '$book_author',book_image = '$dbdestination' 	WHERE book_id = '$book_id';";
										if(mysqli_query($conn, $sql)){
											header("Location: books.php?message=Book+Updated");
										}else{
											header("Location: editbook.php?message=Error");
										}
									} else {
										header("Location: editbook.php?message=YOUR+FILE+IS+TOO+BIG+TO+UPLOAD!");
										exit();
									}
								}else{
									header("Location: editbook.php?message=Oops+Error+Uploading+your+file");
									exit();
								}
							}else{
								header("Location: editbook.php?message=YOUR+FILE+IS+TOO+BIG+TO+UPLOAD!");
								exit();
							}
					}
				
					else if(is_uploaded_file($_FILES['book_content']['tmp_name'])){
						$book_content = $_FILES['book_content'];
						$book_content_Name = $book_content['name'];
						$book_content_Type = $book_content['type'];
						$book_content_Tmp = $book_content['tmp_name'];
						$book_content_Err = $book_content['error'];
						$book_content_Size = $book_content['size'];
						$book_content_EXT = explode('.',$book_content_Name);
						$book_content_Extension = strtolower(end($book_content_EXT));
						$book_content_allowedExt = array("ppt", "txt", "pdf", "doc");
						if(in_array($book_content_Extension, $book_content_allowedExt)){
							if($book_content_Err === 0){
								if($book_content_Size < 300000000){			
									$book_content_newName = uniqid('',true).'.'.$book_content_Extension;
									$book_content_destination = "../uploads/$book_content_newName";
									$book_content_dbdestination = "uploads/$book_content_newName";
									move_uploaded_file($book_content_Tmp, $book_content_destination);
									$sql = "UPDATE `book` SET book_title = '$book_title',book_author = '$book_author',book_content = '$book_content_dbdestination' WHERE book_id = '$book_id';";
									if(mysqli_query($conn, $sql)){
										header("Location: books.php?message=Book+Updated");
									}else{
										header("Location: editbook.php?message=Error");
									}
								} else {
									header("Location: editbook.php?message=YOUR+FILE+IS+TOO+BIG+TO+UPLOAD!");
									exit();
								}
							}else{
								header("Location: editbook.php?message=Oops+Error+Uploading+your+file");
								exit();
							}
						}else{
							header("Location: editbook.php?message=YOUR+FILE+IS+TOO+BIG+TO+UPLOAD!");
							exit();
						}
					}else{
						//users doesnt want to update
						$sql = "UPDATE `book` SET book_title = '$book_title',book_author = '$book_author' WHERE book_id = '$book_id';";
						if(mysqli_query($conn, $sql)){
							header("Location: books.php?message=Book+Updated");
						}else{
							header("Location: editbook.php?message=Error");
						}
					}
				} ?>
			</main>
		  </div>
		</div>
		<script src = "../js/bootstrap.min.js"></script>
		<script src= "../js/scroll.js"></script>
		<script src= "../js/jquery.js"></script>
		
		<!--<script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=ey5ln3e6qq2sq6u5ka28g3yxtbiyj11zs8l6qyfegao3c0su"></script>

		<script>tinymce.init({ selector:'textarea' });</script>-->
	</body>
</html>	
<?php
}else{
	header("Location:login.php?message=Please+Login");
}
?>