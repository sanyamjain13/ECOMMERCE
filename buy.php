<?php 
include "include/connection.php";

//SUBMITTING THE DETAILS OF USER WHO IS BUYING THE ITEM
if(isset($_POST['submit']))
{
	$name=$_POST['name'];
	$email=$_POST['email'];
	$contact=$_POST['contact'];
	$city=$_POST['city'];
	$address=$_POST['address'];

	$insert_sql="INSERT INTO orders(order_name,order_email,order_contact,order_city,order_address,order_checkout_ref,order_total) 
		VALUES('$name','$email','$contact','$city','$address','$_SESSION[ref]','$_SESSION[grandTotal]')";
	mysqli_query($conn,$insert_sql);

}?>

<!DOCTYPE html>
<html>
<head>
	<title>Shopping Cart</title>
	<link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="project_css/first.css">
	<link rel="stylesheet" type="text/css" href="../bootstrap/css/lightbox.css">
	<script src="../jquery/js/jquery.js"></script>
	<script src="../jquery/js/jquery-color.js"></script>
	<script src="../jquery/js/bootstrap.js"></script>
	<script src="../jquery/js/lightbox.js"></script>
	
	<script>

		//IT DISPLAYS THE ORDERS AND ORDER SUMMARY
		function ajax(){
			xmlhttp=new XMLHttpRequest();
			xmlhttp.onreadystatechange=function(){
				if(xmlhttp.readyState==4 && xmlhttp.status==200)
				{
					document.getElementById('get_process_data').innerHTML=xmlhttp.responseText;
				}
			}
			xmlhttp.open('GET','buy_process.php', true);
			xmlhttp.send();
		}

		//DELETE ITEM FROM THE CHECK LIST OR CART
		function del_item(check_item_id){
			//alert(check_item_id);
			xmlhttp.onreadystatechange=function(){
				if(xmlhttp.readyState==4 && xmlhttp.status==200)
				{
					document.getElementById('get_process_data').innerHTML=xmlhttp.responseText;
				}
			}
			xmlhttp.open('GET', 'buy_process.php?chk_id='+check_item_id, true);
			xmlhttp.send();	
		}

		//WHEN QUANTITY IS CHANGED IN ORDER THEN THIS AJAX REQUEST IS PROCESSED
		function check_qty(qty,checkId){
			xmlhttp.onreadystatechange=function(){
				if(xmlhttp.readyState==4 && xmlhttp.status==200)
				{
					document.getElementById('get_process_data').innerHTML=xmlhttp.responseText;
				}
			}
			xmlhttp.open('GET', 'buy_process.php?qty='+qty+'&checkId='+checkId, true);
			xmlhttp.send();	
		}	
	</script>	
</head>

<style>
	#checkout{
		transition: transform 1s,color 0.5s
	}
	#checkout:hover{
		cursor: pointer;
		transform: scale(1,1.3);
		color: white;
		text-shadow: 0 0 30px black;
	}
</style>

<body style="background: silver;" onload="ajax();">

<?php include 'include/header.php';

//HERE WHEN USER CLICKS BUY THEN THE ITEM ID WITH THE USER REF IS STORED IN CHECOUT TABLE
if(isset($_GET['chk_itm_id']))
{
	$date=date("Y-m-d h:i:s");
	$rand_num=mt_rand();
	//if already that users session variable is set then no different session
	if(isset($_SESSION['ref']))
	{}
	else{$_SESSION['ref']=$date.'_'.$rand_num;}

	$check_sql="INSERT INTO checkout(check_item,check_ref,check_timing,check_qty) VALUES('$_GET[chk_itm_id]','$_SESSION[ref]',' $date','1')";
	if(mysqli_query($conn,$check_sql))?>

	<script>
		window.location="buy.php";
	</script>
	
 <?php } ?>



<div class="container" style="background: white;">
	
	<div class="page-header">
		<h1 class="pull-left" id="checkout"><b> <span class=" glyphicon glyphicon-briefcase"></span> CHECKOUT</b></h1>
		
		<div class="pull-right col-md-2"><button class="btn btn-success btn-block btn-lg btn" data-toggle="modal" data-target="#proceed_modal" data-backdrop="false">PROCEED</button></div>
		
		<!-- proceed forms modal -->
		<div class="modal fade" id="proceed_modal">
			<div class="modal-dialog">
				<div class="modal-content">
					
					<div class="modal-header">
						<div class="col-md-4"></div>
						<button class="close" data-dismiss="modal">&times;</button>
						<div class="col-md-3">
							<img src="images/checkout.png" class="img-responsive">
						</div>
					</div>
					
					<div class="modal-body">
						<form method="POST">
							<div class="form-group">
								<label for="name">NAME</label>
								<input type="text" name="name" id="name" placeholder="FULL NAME" class="form-control" required>
							</div>
							<div class="form-group">
								<label for="email">EMAIL</label>
								<input type="email" name="email" id="email" placeholder="YOUR EMAIL" class="form-control" required>
							</div>
							<div class="form-group">
								<label for="contact">CONTACT NUMBER</label>
								<input type="number" name="contact" id="contact" placeholder="+91-XXXXXXXXXX" class="form-control" required>
							</div>
							<div class="form-group">
								<label for="select">SELECT YOUR CITY</label>
								<input list="city" class="form-control" name="city" placeholder="Ex :- NEW DELHI" required>
								<datalist id="city">
									<option>NEW DELHI</option>
									<option>GURUGRAM</option>
									<option>NOIDA</option>
									<option>GHAZIABAD UP</option>
									<option>FARIDABAD</option>
									<option>MEERUT</option>
									<option>ALWAR</option>
									<option>ROHTAK</option>
									<option>CONNAUGHT PLACE</option>
									<option>GREATER NOIDA</option>
									<option>KARNAL</option>
									<option>DWARKA</option>
									<option>PANIPAT</option>
									<option>KAROL BAGH</option>
									<option>SHAHDRA</option>
									<option>CHANAKYAPURI</option>
									<option>DELHI CANTONMENT</option>
									<option>JHAJJAR</option>
									<option>JANAK PURI</option>
									<option>VIKAS PURI</option>
									<option>GREATER KAILASH</option>
									<option>VASANT KUNJ</option>
								</datalist>
							</div>
							<div class="form-group">
								<label>DELIVERY ADDRESS</label>
								<textarea style="resize: none;" rows="2" class="form-control" placeholder="HOUSE NO / FLAT NO, STREET, LANDMARK, DISTRICT, PIN CODE" name="address" required></textarea>
							</div>
							<div class="form-group">
								<input type="submit" name="submit" class="btn btn-success btn-block" value="SUBMIT DETAILS">
							</div>
						</form>
					</div>

					<div class="modal-footer">
						<button class="btn btn-danger btn-lg" data-dismiss="modal">CLOSE</button>
					</div>
				</div>
			</div>
		</div>
		
		<div class="clearfix"></div>
	</div>
	
	<!-- ORDER DETAILS -->
	<div class="panel panel-default">
		<div class="panel-heading"><h4>ORDER DETAILS</h4></div>
		<div class="panel-body">
			<table class="table table-hover table-responsive">
				<thead>
					<tr>
						<th>S.NO</th>
						<th>ITEM</th>
						<th>QUANTITY</th>
						<th>PRICE</th>
						<th>TOTAL</th>
						<th>DELETE ITEM</th>
					</tr>
				</thead>
				<tbody id="get_process_data">
					<!-- here data will come from buy_process.php through AJAX -->
		</div>
	</div>
</div>
</body>
</html>