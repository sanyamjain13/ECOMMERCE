<?php
session_start();
include 'connection.php';
?>
<nav class="navbar navbar-inverse">
		<div class="container-fluid">
			
			<div class="navbar-header">
				<a href="#" class="navbar-brand">ONLINE ELECTRONICS</a>
				
				<button class="navbar-btn btn-default navbar-toggle pull-left" data-toggle="collapse" data-target="#navs">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>

			<div class="nav navbar-nav" id="navs">
				<li><a href="home.php">HOME</a></li>
				
				<?php
					
					$cat_sql="SELECT * FROM category";
					$cat_run=mysqli_query($conn,$cat_sql);
					
					while($rows=mysqli_fetch_assoc($cat_run))
					{	
						
						if($rows['cat_slug']==" ")
							{
								$cat_slug=$rows['cat_name'];
							}
						else 
							{
								$cat_slug=$rows['cat_slug'];
							}
						

						print("
							<li><a href='category.php?category=$cat_slug'>$rows[cat_name]</a></li>
							");
					}
				?>
			</div>
						
			<div class="nav navbar-nav navbar-right">
				<li><a><span class="glyphicon glyphicon-cloud"></span>    
					<?php
						$date=date('d-M-Y');
						echo $date; 
					?></a></li>

				<li><a><span class="glyphicon glyphicon-user"></span>    
					WELCOME
					<?php
						echo strtoupper($_SESSION['username']);  
					?></a></li>

				<li><a href="customer_login.php" class="glyphicon glyphicon-log-out"> LOGOUT 
				</a></li>
			</div>
			
		</div>
</nav>
