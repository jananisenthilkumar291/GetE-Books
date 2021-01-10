<?php 

	include_once "includes/connection.php";
?>
			<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
			  <a class="navbar-brand" href="./index.php">CSBooks</a>
			  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			  </button>

			  <div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav mx-auto">
				  <li class="nav-item active">
					<a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
				  </li>
				  <li class="nav-item">
					<a class="nav-link" href="books.php">Books</a>
				  </li>
				  <li class="nav-item">
					<a class="nav-link" href="blogs.php">Blogs</a>
				  </li>
				  <li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" id="navbarDropdown" href = "#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					Categories
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdown">
					<?php 
						$sql = "SELECT * FROM `category`;";
						$result = mysqli_query($conn,$sql);
						while($row = mysqli_fetch_array($result)){
							$category_name = $row['category_name'];
							$category_id = $row['category_id'];
						?>							
						  <a class="dropdown-item" href="category.php?id=<?php echo $category_id;?>"><?php echo $category_name;?></a>
						<?php
							}
						?>
					</div>
				  </li>
				  <?php if(isset($_SESSION['user_role'])){?>
					  <li class="nav-item">
						<a class="nav-link" href="admin/logout.php" >LogOut</a>
					  </li>
					  <li class = "nav-item">
						<h6 style = "color:white;padding:10px;">Welcome! <?php echo $_SESSION['user_name'];?></h6>
					  </li>
					  <?php
				  }else{
					  ?><li class="nav-item">
						<a class="nav-link" href="admin/login.php" >LogIn</a>
					  </li>
					  <li class="nav-item">
						<a class="nav-link" href="admin/signup.php" >SignUp</a>
					  </li><?php
				  }?>
				  
				</ul>
				<form action = "search.php" class="form-inline my-2 my-lg-0">
				  <input name = "s" class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
				  <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
				</form>
			  </div>
			</nav>
			
