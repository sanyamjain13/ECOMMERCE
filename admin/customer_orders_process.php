<?php include '../include/connection.php';

//when order is SENT and When delivery is still PENDING
if(isset($_REQUEST['order_status']))
{
	$update_order_status="UPDATE orders SET status='$_REQUEST[order_status]' WHERE order_id='$_REQUEST[order_id]'";
	$run_update_query=mysqli_query($conn,$update_order_status);
}

//if order is returned by the customer then ORDER RETURNED else ORDER ACCEPTED
if(isset($_REQUEST['return_status']))
{
	$update_return_status="UPDATE orders SET return_status='$_REQUEST[return_status]' WHERE order_id='$_REQUEST[order_id]'";
	$run_update_query=mysqli_query($conn,$update_return_status);
}

?>

<table class="table table-bordered table-hover table-responsive">
	<thead>
		<tr>
			<th>S.NO</th>
			<th>NAME</th>
			<th>EMAIL</th>
			<th>CONTACT</th>
			<th>CITY</th>
			<th>ADDRESS</th>
			<th>ORDER REFERENCE</th>
			<th>TOTAL PAYMENT</th>
			<th>ORDER STATUS</th>
			<th>RETURN STATUS</th>
		</tr>
	</thead>

	<tbody>
		
		<?php
		$select_orders="SELECT * FROM orders";
		$run_query=mysqli_query($conn,$select_orders);
		$c=1;
		while ($rows=mysqli_fetch_assoc($run_query)) 
			{	
				if($rows['status']==0)
				{	//if ststus is pending
					$btn_class="btn-warning";
					$btn_value="PENDING";
				}
				else
				{	//if status is success
					$btn_class="btn-success";
					$btn_value="SENT";
				}

				if($rows['return_status']==0)
				{
					$btn_return_class="btn-danger";
					$btn_return_value="ORDER RETURNED";
				}
				else{

					$btn_return_class="btn-success";
					$btn_return_value="ORDER ACCEPTED";	
				}

				echo "
					<tr>
						<td>$c.</td>
						<td>$rows[order_name]</td>
						<td>$rows[order_email]</td>
						<td>$rows[order_contact]</td>
						<td>$rows[order_city]</td>
						<td>$rows[order_address]</td>
						<td><button class='btn btn-primary' data-toggle='modal' data-target='#order_check_modal$rows[order_id]'>$rows[order_checkout_ref]</button>
						

						<div class='modal fade' id='order_check_modal$rows[order_id]'>
							<div class='modal-dialog'>
								<div class='modal-content'>
									<div class='modal-header'></div>
									<div class='modal-body'>
										<table class='table table-striped table-hover'>
											<thead>
												<tr>
													<th>S.NO</th>
													<th>ITEM</th>
													<th>QUANTITY</th>
													<th class='text-right'>PRICE</th>
													<th class='text-right'>SUB-TOTAL</th>
												</tr>
											</thead>
											<tbody>";

											$check_sql="SELECT * FROM checkout c JOIN items i ON 
											c.check_item=i.item_id WHERE c.check_ref='$rows[order_checkout_ref]'";

											$check_run=mysqli_query($conn,$check_sql);
											$s=1;

											while($row_check=mysqli_fetch_assoc($check_run))
												{	
													$discounted_price=$row_check['item_price']-$row_check['item_discount'];
													$totalPrice_OfItem=$discounted_price*$row_check['check_qty'];
													echo"
													<td>$c</td>
													<td>$row_check[item_title]</td>
													<td>$row_check[check_qty]</td>
													<td class='text-right'>$discounted_price</td>
													<td class='text-right'>$totalPrice_OfItem</td>
													";
												}
												
											echo"
											</tbody>
											}
												}
										</table>
										<table class='table'>
											<thead>
												<tr>
													<th colspan=3 class='text-center'>ORDER SUMMARY</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>GRAND TOTAL</td>
													<td class='text-right'>000</td>
												</tr>
											</tbody>
										</table>	
									</div>
									<div class='modal-footer'></div>
								</div>
							</div>
						</div>
						</td>

						<td class='text-right'>&#8377; $rows[order_total]/-</td>";?>
						
						<!-- sending order status and id through order_status() fn -->
						<td class='text-center'><button onclick="order_status(<?php echo $rows['status'].','.$rows['order_id']?>);" class='btn btn-block btn-sm <?php echo $btn_class?>'>
							<?php echo $btn_value;?>
							</button>
						</td>

						<td><button onclick="return_status(<?php echo $rows['return_status'].','.$rows['order_id']?>);" class='btn btn-block btn-sm <?php echo $btn_return_class?>'>
							<?php echo $btn_return_value;?>
							</button>
						</td>
					</tr>
				<?php
				$c++;    
			}
		?>

	</tbody>
</table>