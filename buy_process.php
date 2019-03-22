<?php 
	session_start();
	include 'include/connection.php';
	
	//DELETING THE ITEM FROM CHECKOUT TABLE USING AJAX
	if(isset($_REQUEST['chk_id']))
	{
		$del_chk_item="DELETE FROM checkout WHERE check_id='$_REQUEST[chk_id]'";
		$run_query=mysqli_query($conn,$del_chk_item);
	}

	//UPDATING THE QTY OF PRODUCT TO BE BUYED
	if(isset($_REQUEST['qty']))
	{
		$update_chk_qty="UPDATE checkout SET check_qty='$_REQUEST[qty]' WHERE check_id='$_REQUEST[checkId]'";
		$run_query=mysqli_query($conn,$update_chk_qty);
	}

	
	//AJAX REQUEST FOR THE DETAILS OF THE PRODUCT BUYED BY THE USER
	$c=1;
	$check_sel_sql="SELECT * FROM checkout c JOIN items i ON c.check_item=i.item_id WHERE c.check_ref='$_SESSION[ref]'";
	$run_sql=mysqli_query($conn,$check_sel_sql);
	$total=0;
	$delivery_charges=0;
	while ($rows=mysqli_fetch_Assoc($run_sql)) 
	{	
		$discounted_price=$rows['item_price']-$rows['item_discount'];
		$totalPrice_OfItem=$discounted_price*$rows['check_qty'];
		$total+=$totalPrice_OfItem;
		$delivery_charges+=$rows['item_delivery'];
 		print("
			<tr>
				<td>$c.</td>
				<td style='font-family: arial black;'>$rows[item_title]</td>");
				
				?>
				
				<td><input type='number' min="1" onblur="check_qty(this.value, '<?php echo $rows['check_id'];?>') ;" style='width:60px; text-align: center; font-weight: bold;' value='<?php echo $rows['check_qty'] ;?>'></td>
				
				<?php 

				print("
				<td>&#8377; $discounted_price/-</td>
				<td><b>&#8377; $totalPrice_OfItem/-</b></td>");
				
				?>
				
				<td><button class='btn btn-danger' onclick="del_item(<?php echo"$rows[check_id]"; ?>);">DELETE</button></td>
			
			<?php 

			print
			("
			</tr>				
 			
 			");
 			$c++;
 		}
 		
 		$_SESSION['grandTotal']=$total+$delivery_charges;
 		echo "
 		</tbody>
		</table>	
		<table class='table'>
			<thead>
				<tr style='background:#e6e6e6;'>
					<th colspan='6' style='font-family:times; font-size:20px;'>ORDER SUMMARY</th>
				</tr>
			</thead>
			<tbody >
				<tr>
					<td style='color:darkgreen; font-family:arial black;'>SUBTOTAL</td>
					<td></td>
					<td></td>
					<td></td>
					<td class='text-left'colspan='5'><u><b>&#8377; $total/- </b></u></td>
				</tr>
				<tr>
					<td style='color:darkgreen; font-family:arial black;'>DELIVERY CHARGES</td>
					<td></td>
					<td></td>
					<td></td>
					<td class='text-left' colspan='5'><u><b> &#8377; $delivery_charges/- </u></b></td>
				</tr>
				<tr>
					<td style='color:darkgreen; font-family:arial black;'>GRAND TOTAL</td>
					<td></td>
					<td></td>
					<td></td>
					<td class='text-left' colspan='5'><u><b><mark>&#8377; $_SESSION[grandTotal]/-</mark></u></b></td>
				</tr>
			</tbody>	
		</table>
 		";	  
?>





