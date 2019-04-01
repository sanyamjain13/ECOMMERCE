<?php 
include 'include/connection.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>ORDER HISTORY</title>

	<link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="project_css/first.css">
	<link rel="stylesheet" type="text/css" href="../bootstrap/css/lightbox.css">
	<script src="../jquery/js/jquery.js"></script>
	<script src="../jquery/js/jquery-color.js"></script>
	<script src="../jquery/js/bootstrap.js"></script>
	<script src="../jquery/js/lightbox.js"></script>
	
</head>

<style>
	#order_heading{
		transition: transform 1.1s,text-shadow 1.1s;
		font-family: times;
		font-size: 45px;
		font-weight: bold;
		letter-spacing: 8px;
		text-shadow: 10px 0 20px grey;
	}
	#order_heading:hover{
		transform: scale(1,1.2);
		color: white;
		cursor: pointer;
		text-shadow: 4px 0 30px black; 
	}

	th{
		text-align: center;
		font-size: 20px;
		font-family: times;
	}
	td{
		text-align: center;
		font-family: arial black;
		font-size: 15px;
	}
</style>
<body style="background: url(images/order_history.jpg);">
<?php include 'include/header.php'; ?>
<div class="container">

	<div class="panel panel-default">
		<div class="panel-heading">	
			<div class="text-center" id="order_heading">ORDER HISTORY</div>
		</div>

		<div class="panel-body">
			<table class="table table-striped table-hover table-responsive">
				<thead class="text-muted">
					<tr>
						<th>S.NO</th>
						<th>ITEM NAME</th>
						<th>ITEM QUANTITY</th>
						<th>ITEM PRICE</th>
						<th>TOTAL PRICE</th>
						<th>DATE & TIME</th>
					</tr>
				</thead>
				<tbody>
					
				<?php

					$c=1;
					$select_query="SELECT * FROM checkout c JOIN items i ON c.check_item=i.item_id WHERE c.contact_number='$_SESSION[contact_number]'";

					$run_Sql=mysqli_query($conn,$select_query);
					while($row=mysqli_fetch_assoc($run_Sql))
					{
						$discounted_price=$row['item_price']-$row['item_discount'];
						$totalPrice_OfItem=$discounted_price*$row['check_qty'];
						echo "
							<tr>
								<td>$c.</td>
								<td>$row[item_title]</td>
								<td>$row[check_qty]</td>
								<td>&#8377; $discounted_price/-</td>
								<td>&#8377; $totalPrice_OfItem/-</td>
								<td>$row[check_timing]</td>
							</tr>
						";

						$c++;
					}

				?>

				</tbody>
			</table>
		</div>

		<div class="panel-footer">
			
		</div>
	</div>

</div>

</body>
<?php //include 'include/footer.php'; ?>
</html>