<?php include '../include/connection.php';?>

<!DOCTYPE html>
<html>
<head>
	<title>CUSTOMER ORDERS</title>
	<link rel="stylesheet" type="text/css" href="../../bootstrap/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="../../bootstrap/css/lightbox.css">
	<script src="../../jquery/js/jquery.js"></script>
	<script src="../../jquery/js/jquery-color.js"></script>
	<script src="../../jquery/js/bootstrap.js"></script>
	<script src="../../jquery/js/lightbox.js"></script>

	<script>
		function order_list()
		{
		xmlhttp=new XMLHttpRequest();
		xmlhttp.onreadystatechange=function(){
			if(xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				document.getElementById('order_list').innerHTML=xmlhttp.responseText;
			}
		}
		xmlhttp.open('GET', 'customer_orders_process.php', true);
		xmlhttp.send();
		}

		function order_status(statusId,orderId)
		{	
			if(statusId==0){
				statusId=1; //if status is pending and we click on it , it will become to sent
			} 
			else
			{
				statusId=0; //if it is sent it will become pending
			}

			xmlhttp.onreadystatechange=function(){
				if(xmlhttp.readyState==4 && xmlhttp.status==200)
				{
					document.getElementById('order_list').innerHTML=xmlhttp.responseText;
				}
			}
			
			xmlhttp.open('GET', 'customer_orders_process.php?order_status='+statusId+'&order_id='+orderId, true);
			xmlhttp.send();
		}

		function return_status(Return_Status_Id,orderId)
		{	
			if(Return_Status_Id==0){
				Return_Status_Id=1; //if status is pending and we click on it , it will become to sent
			} 
			else
			{
				Return_Status_Id=0; //if it is sent it will become pending
			}

			xmlhttp.onreadystatechange=function(){
				if(xmlhttp.readyState==4 && xmlhttp.status==200)
				{
					document.getElementById('order_list').innerHTML=xmlhttp.responseText;
				}
			}
			
			xmlhttp.open('GET', 'customer_orders_process.php?return_status='+Return_Status_Id+'&order_id='+orderId, true);
			xmlhttp.send();
		}
	</script>
</head>
<body onload="order_list();">
	<?php include "include/header.php";?>
	<div class="container-fluid">
		
		<div class="panel panel-default">
			
			<div class="panel-heading" >
				<div class="text-center" style="font-size: 50px; font-weight: bold; text-shadow: 5px 5px 6px silver;">CUSTOMER ORDERS</div>
			</div>
			
			<div class="panel-body" id="order_list">
				<!-- we are getting the order list through ajax -->
			</div>
			
			<div class="panel-footer"></div>
		</div>
	
	</div>

</body>
<?php include "include/footer.php";?>
</html>