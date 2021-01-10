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
				<h1 class="h2">Add New Book</h1>
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
				Book Title:
				<input placeholder = "Enter Book Title" name = "book_title" class = "form-control" type = "text"><br>
				
				Book author:
				<input placeholder = "Enter Book Author Name" name = "book_author" class = "form-control" type = "text"><br>
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
				Book Content:
				<input type = "file" name = "book_content" accept = "application/pdf,application/doc,application/txt" class = "form-control-file" id = "exampleFormControlFile"><br>
				Book Image:
				<input type = "file" name = "book_image" class = "form-control-file" id = "exampleFormControlFile"><br>
				<input class = "btn btn-info" type = "submit" name = "submit">
			  </form>
			  <?php 
				if(isset($_POST['submit'])){
					$book_title = mysqli_real_escape_string($conn,$_POST['book_title']);
					$book_category = mysqli_real_escape_string($conn,$_POST['book_category']);
					$book_author = mysqli_real_escape_string($conn,$_POST['book_author']);
					//checking for empty fields
					if(empty($book_title) OR empty($book_category) OR empty($book_author)){
						header("Location:newbook.php?message=Empty+Fields");
						exit();
					}
					$file = $_FILES['book_image'];
					$book_content = $_FILES['book_content'];
						$fileName = $file['name'];
						$book_content_Name = $book_content['name'];
						$fileType = $file['type'];
						$book_content_Type = $book_content['type'];
						$fileTmp = $file['tmp_name'];
						$book_content_Tmp = $book_content['tmp_name'];
						$fileErr = $file['error'];
						$book_content_Err = $book_content['error'];
						$fileSize = $file['size'];
						$book_content_Size = $book_content['size'];
						
						$fileEXT = explode('.',$fileName);
						$book_content_EXT = explode('.',$book_content_Name);
						$fileExtension = strtolower(end($fileEXT));
						$book_content_Extension = strtolower(end($book_content_EXT));
						
						$allowedExt = array("jpg", "jpeg", "png", "gif");
						$book_content_allowedExt = array("ppt", "txt", "pdf", "doc");
						
						if((in_array($fileExtension, $allowedExt)) AND (in_array($book_content_Extension, $book_content_allowedExt))){
							if(($fileErr === 0) AND ($book_content_Err === 0)){
								if(($fileSize < 3000000) AND ($book_content_Size < 9000000000)){
									$newFileName = uniqid('',true).'.'.$fileExtension;
									$book_content_newName = uniqid('',true).'.'.$book_content_Extension;
									$destination = "../uploads/$newFileName";
									$book_content_destination = "../uploads/$book_content_newName";
									$dbdestination = "uploads/$newFileName";
									$book_content_dbdestination = "uploads/$book_content_newName";
									move_uploaded_file($fileTmp, $destination);
									move_uploaded_file($book_content_Tmp, $book_content_destination);
									echo "AAAA";
									$sql = "INSERT INTO book (`book_title`,`book_category`,`book_content`, `book_author`, `book_image`) VALUES ('$book_title', '$book_category','$book_content_dbdestination', '$book_author', '$dbdestination');";
									if(mysqli_query($conn, $sql)){
										header("Location: books.php?message=Book+Published");
									}else{
										header("Location: newbook.php?message=Error");
									}
								} else {
									header("Location: newbook.php?message=YOUR+FILE+IS+TOO+BIG+TO+UPLOAD!");
									exit();
								}
							}else{
								header("Location: newbook.php?message=Oops+Error+Uploading+your+file");
								exit();
							}
						}else{
							header("Location: newbook.php?message=YOUR+FILE+IS+TOO+BIG+TO+UPLOAD!");
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

