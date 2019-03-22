<?php include '../include/connection.php'?>

<table class="table table-striped table-bordered table-responsive table-hover">
	<thead>
		<tr class="label-default" style="color: white;">
			<th>S.NO</th>
			<th>IMAGE</th>
			<th>TITLE</th>
			<th>DESCRIPTION</th>
			<th>CATEGORY</th>
			<th>QUANTITY</th>
			<th>COST</th>
			<th>DISCOUNT</th>
			<th>PRICE</th>
			<th>DELIVERY CHARGE</th>
			<th>ACTIONS</th>
		</tr>
	</thead>
	<tbody>
	<?php

		if(isset($_REQUEST['item_id']))
		{
			$del_sql="DELETE FROM items WHERE item_id='$_REQUEST[item_id]'";
			$run_del_sql=mysqli_query($conn,$del_sql);
		}

		if(isset($_REQUEST['edit_item_id']))
		{	
			$edit_id=$_REQUEST['edit_item_id'];
			$title= strtoupper($_REQUEST['item_title']);
			$category= strtoupper($_REQUEST['item_cat']);
			$description= strtoupper($_REQUEST['item_desc']);
			$qty= $_REQUEST['item_qty'];
			$cost= $_REQUEST['item_cost'];
			$price= $_REQUEST['item_price'];
			$discount= $_REQUEST['item_disct'];
			$delivery= $_REQUEST['item_del'];

			$update_sql="UPDATE items SET item_title='$title',item_cat='$category',item_description='$description',item_qty='$qty',item_cost='$cost',item_price='$price',item_discount='$discount',item_delivery='$delivery' WHERE item_id='$edit_id' ";
			$run_query=mysqli_query($conn,$update_sql);
			}


		$c=1;
		$select_sql="SELECT * FROM items";
		$run_sql=mysqli_query($conn,$select_sql);
		while ($rows=mysqli_fetch_assoc($run_sql)) {
			$discounted_price=$rows['item_price']-$rows['item_discount'];
			echo "
				<tr style='font-weight:bold; text-align:center;'>
					<td>$c.</td>
					<td><img src='../$rows[item_img]' style='width:75px;'></td>
					<td>$rows[item_title]</td>
					<td>"; echo strip_tags($rows['item_description']); echo"</td>
					<td>$rows[item_cat]</td>
					<td>$rows[item_qty]</td>
					<td>&#8377;$rows[item_cost]</td>
					<td>&#8377;$rows[item_discount]</td>
					<td>&#8377;$rows[item_price]($discounted_price)</td>
					<td>&#8377;$rows[item_delivery]</td>
					<td>
						<div class='dropdown'>
							<button class='btn btn-success btn-block dropdown-toggle' data-toggle='dropdown'>ACTIONS <span class='caret'></span></button>
							<ul class='dropdown-menu dropdown-menu-right '>";?>
								<li><a href="#edit_item" data-toggle="modal" class='label-info text-center'><b>EDIT</b></a></li>
								<li><a href='javascript:;' onclick="delete_item(<?php echo "$rows[item_id]";?>);" class='label-danger text-center'><b>DELETE</b></a></li>
							
							<?php echo"</ul>
						</div> 
						

						<div id='edit_item' class='modal fade' data-backdrop='false'>				
							<div class='modal-dialog'>								
								<div class='modal-content'>									
									
									<div class='modal-header label-info'>
										<div class='close' data-dismiss='modal'>&times;</div>
									</div>
									
									<div class='modal-body'>										
										<div class='text-left'>
											<div class='form-group'>
												<label>ITEM NAME</label>
												<input type='text' id='edit_item_name' value='$rows[item_title]' class='form-control' required>
											</div>
											
											<div class='form-group'>
												<label>ITEM CATEGORY</label>
												<select class='form-control' id='edit_item_category'>
													<option>SELECT CATEGORY</option>";?>
													<?php
														$query='SELECT * FROM category';
														$run_query=mysqli_query($conn,$query);
														while ($cat_rows=mysqli_fetch_assoc($run_query)) 
														{
															if($cat_rows['cat_slug']==""){
																$cat_slug=$cat_rows['cat_name'];	
															}
															else
															{
																$cat_slug=$cat_rows['cat_slug'];
															}

															if($cat_slug==$rows['item_cat'])
															{
														  	echo "<option selected value='$cat_slug'>$cat_rows[cat_name]</option>";   
															}
															else {
														  	echo "<option value='$cat_slug'>$cat_rows[cat_name]</option>";   			
															}

														}?>
														<?php	
													echo"
												</select>

											</div>
											<div class='form-group'>
												<label>ITEM DESCRIPTION</label>
												<textarea value='$rows[item_description]' class='form-control' style='resize: none;' id='edit_item_desc' required></textarea>
											</div>
											<div class='form-group'>
												<label>ITEM QUANTITY</label>
												<input type='number' min='1' id='edit_item_qty' class='form-control' value='$rows[item_qty]' required>
											</div>
											<div class='form-group'>
												<label>ITEM COST</label>
												<input type='number' id='edit_item_cost' class='form-control' value='$rows[item_cost]' required>
											</div>
											<div class='form-group'>
												<label>ITEM PRICE</label>
												<input type='number' id='edit_item_price' class='form-control' value='$rows[item_price]' required>
											</div>
											<div class='form-group'>
												<label>ITEM DISCOUNT</label>
												<input type='number' id='edit_item_discount' class='form-control' value='$rows[item_discount]' required>
											</div>
											<div class='form-group'>
												<label>ITEM DELIVERY CHARGES</label>
												<input type='number' id='edit_item_delivery' class='form-control' value='$rows[item_delivery]' min='0'>
											</div>
											<div class='form-group'>
												<input type='hidden' id='edit_item_id' value='$rows[item_id]'>
												<button id='submit_new_item' onclick='edit_item();' class='btn btn-success btn-lg btn-block'>UPDATE DATA</button>
											</div>
										
										</div>
									</div>
									<div class='modal-footer label-info'>
										<button class='btn btn-danger pull-right' data-dismiss='modal'>CLOSE</button>
									</div>
								</div>
							</div>
						</div>
			
					</td>
				</tr>
			";
			$c++;  
		}
	?>
	</tbody>
	</table>