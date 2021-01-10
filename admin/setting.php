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
				<h1 class="h2"><strong>Settings</strong></h1>
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
			  <h1> All Settings</h1><br><hr>
				<form method = "post">
				Home Page Jumbotron Title
					<input type = "text" name = "home_jumbo_title" class = "form-control" placeholder = "Jumbotron Title Name" value = "<?php getSettingValue('home_jumbo_title')?>"><br>
				Home Page Jumbotron Description
					<input type = "text" name = "home_jumbo_desc" class = "form-control" placeholder = "Jumbotron Title Description" value = "<?php getSettingValue('home_jumbo_desc')?>"><br>
					<button class = "btn btn-success" name = "submit">UpdateSettings</button>
				</form><br>
				<?php 
				
					if(isset($_POST['submit'])){
						$jumboTitle = mysqli_real_escape_string($conn,$_POST['home_jumbo_title']);
						$jumboDesc = mysqli_real_escape_string($conn,$_POST['home_jumbo_desc']);
						setSettingValue("home_jumbo_title",$jumboTitle);
						setSettingValue("home_jumbo_desc",$jumboDesc);
						header("Location:setting.php?message=Settings+Updated");
					}
				?>
			  </div>
			</main>
		  </div>
		</div>	
		<script src= "../js/jquery.js"></script>
		<script src = "../js/bootstrap.min.js"></script>
		<script src= "../js/scroll.js"></script>
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

