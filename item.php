<?php
include 'include/connection.php';
?>
<!DOCTYPE html>
<html>
<head>

	<link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="../bootstrap/css/lightbox.css">
	<script src="../jquery/js/jquery.js"></script>
	<script src="../jquery/js/jquery-color.js"></script>
	<script src="../jquery/js/bootstrap.js"></script>
	<script src="../jquery/js/lightbox.js"></script>
	
	<link rel="stylesheet" type="text/css" href="project_css/first.css">

	<title>PRODUCT PAGE</title>
</head>
<style>
	
	body{
		background: url('images/background/bg1.jpg');
		background-size: cover;
	}

	.panel-heading{
		font-size:25px;
		text-align: center;
	}
	.panel-body p{
		font-size: 20px;
		word-spacing: 2px;
		font-weight: bold;
		line-height: 30px;
		font-style: italic;
		font-family: times;
	}
		
	.panel-body ul li{
		margin-top: 5px;
		font-size: 17px;
		text-shadow: 0 0 7px silver;
	}
	.list-group-item{
		font-size: 20px;
		font-family: times;
		margin-bottom: 8px;
		padding: 21px;
	}
	.list-group-item:hover{
		background: #f1f1f1;
		color: maroon;
		cursor: pointer;
	}		
	.top{
		height: 240px;
	}
	.bottom{
		height: 140px;
		background: #f1f1f1;
		color: black;

	}
		.bottom a:visited{
			color: black;
		}
		.bottom a:hover{
			color: red;
		}

</style>
<body>
	
	<?php include 'include/header.php'?>

	<div class="container" style="background:white; opacity: 0.9;">
		
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="home.php">HOME</a></li>
				<?php

					if(isset($_GET['id']))
					{
						$select="SELECT * FROM items WHERE item_id='$_GET[id]' ";
						$run=mysqli_query($conn,$select);
						while($rows=mysqli_fetch_assoc($run))
							{
								print("
										<li><a href='category.php?category=$rows[item_cat]'>$rows[item_cat]</a></li>
										<li class='active'>$rows[item_title]</li>
									");					

				?>
				
			</ol>
		</div>
		<div class="row">
			<?php  
					print("

						<div class='col-md-8'> 
							<h3 class='pp-title'>$_GET[title]</h3><br>
							<img src=$rows[item_img] class='img-responsive' style='height: 400px;''>
							<br>
							<div class='col-md-10'>
								<div class='panel panel-primary'>

									<div class='panel-heading'>DESCRIPTION</div>
									
									<div class='panel-body'>$rows[item_description]</div>
								</div>
							</div>
						</div> ");
					}
				}
			?>
		
			<aside class="col-md-4">
				<!-- BUY BUTTON -->
				<a href="buy.php?chk_itm_id=<?php echo "$_GET[id]"?>" class="btn btn-success btn-block btn-lg">BUY</a>
				
				<BR>

				<ul class="list-group">	
					<li class="list-group-item">
						<div class="row">
							<div class="col-md-2 glyphicon glyphicon-briefcase"></div>
							<div class="col-md-10">DELIVERY WITHIN 5 DAYS</div>
						</div>
					</li>
					
					
					<li class="list-group-item">
						<div class="row">
							<div class="col-md-2 glyphicon glyphicon-refresh"></div>
							<div class="col-md-10">EASY RETURN IN 7 DAYS</div>
						</div>
					</li>

					
					<li class="list-group-item">
						<div class="row">
							<div class="col-md-2 glyphicon glyphicon-phone"></div>
							<div class="col-md-10">CALL US AT 011-64569311</div>
						</div>
					</li>
				</ul>
				<?php
					$carousel_query="SELECT * FROM carousel  WHERE item_title='$_GET[title]'";
					$run_carousel=mysqli_query($conn,$carousel_query);
					while($rows=mysqli_fetch_assoc($run_carousel))
					{	
						echo
						"<div class='carousel slide' id='car-1' data-ride='carousel' data-interval='3000' data-pause='hover'>
								
								<div class='carousel-inner'>
									<div class='item active'>
										<img src=$rows[img1] class='img-responsive'>
									</div>
									<div class='item'>
										<img src=$rows[img2] class='img-responsive'>
									</div>
									<div class='item'>
										<img src=$rows[img3] class='img-responsive'>
									</div>
								</div>
						</div>";
					}
				?>
			</aside>
		</div>
		
		<div class="page-header col-md-4" style="font-family: times;">
			<h1><b>RELATED ITEMS</b></h1>
		</div>
		
		<div class="clearfix"></div>
		<section class="row">
			<?php
				$sql_select="SELECT * FROM items ORDER BY rand() LIMIT 4";
				$run=mysqli_query($conn,$sql_select);
				while($rows=mysqli_fetch_assoc($run))
				{	
					$disct_price=$rows['item_price']-$rows['item_discount'];
					print("
						<div class='col-md-3'>
							<div class='col-md-12 single-item' style='padding: 0;'>
								<div class='top'>
									<img src=$rows[item_img]>
								</div>
								
								<div class='bottom'>
									<h3 class='item-title'><a href='item.php?title=$rows[item_title]&id=$rows[item_id]'>$rows[item_title]</a></h3>
									<div class='pull-right cutted-price'><del>&#8377;$rows[item_price]/-</del></div>
									<div class='clearfix'></div>
									<div class='pull-right discounted-price'>&#8377;$disct_price/-</div>
								</div>
							</div>
						</div>
					");
				}
			?>
		
		</section>

	</div>
</body><br>

<?php include 'include/footer.php'; ?>
</html>