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
	
	<title>ECOMMERCE</title>

</head>
<style>
	.bottom{
		height: 150px;
	}
</style>

<body style="background: black;" >
	<?php 
		include 'include/header.php';
	?>

	<div class="container">

		<div class="row">
			<?php

				$select="SELECT * FROM items where item_cat='$_GET[category]'";
				$run=mysqli_query($conn,$select);
				while($rows=mysqli_fetch_assoc($run))
				{

				$disct_price=$rows['item_price']-$rows['item_discount'];
				
				echo "
				<div class='col-md-3'>
					<div class='col-md-12 single-item' style='padding: 0;'>
						
						<div class='top'>
							<img src=$rows[item_img]>
						</div>

						<div class='bottom'>
							<h3 class='item-title'><a href='item.php?title=$rows[item_title]&id=$rows[item_id]'> $rows[item_title] </a></h3>
							<div class='pull-right cutted-price'><del>&#8377;$rows[item_price]/-</del></div>
							<div class='clearfix'></div>
							<div class='pull-right discounted-price'> &#8377;$disct_price/- </div>
						</div>
					</div>
				</div>";
				}

			?>
		</div>
	</div>	
</body>
<?php 
	include 'include/footer.php' 
?>
</html>
