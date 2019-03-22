<?php include '../include/connection.php';

//ENTERING NEW ITEMS IN THE DATABASE
if(isset($_POST['submit_new_item']))
{
	$title= strtoupper($_POST['item_name']);
	$category= strtoupper($_POST['item_category']);
	$description= strtoupper($_POST['item_desc']);
	$qty= $_POST['item_qty'];
	$cost= $_POST['item_cost'];
	$price= $_POST['item_price'];
	$discount= $_POST['item_discount'];
	$delivery= $_POST['item_delivery'];

	if(isset($_FILES['item_file']['name']))
	{
		$fileName= $_FILES['item_file']['name']; //The original name of the file on the client machine.
		$path_Address="../images/items/$fileName"; //where we need to save the file
		$path_Address_db="images/items/$fileName"; //the address need to be stored in db
		$img_confirm=1;
		$file_type=pathinfo($_FILES['item_file']['name'],PATHINFO_EXTENSION); //it tells the filetype(jpg,png,etc)

		if($_FILES['item_file']['size']>200000)
		{
			$img_confirm=0;
		?> <script>alert('FILE SIZE IS BIGGER!!!!!');</script>
		
		<?php	
		}
		if($file_type!='jpg' && $file_type!='png' && $file_type!='jpeg' && $file_type!='gif')
		{
			$img_confirm=0;?>
			<script>alert('FILE TYPE IS NOT CORRECT!!!');</script>

		<?php
		}
		if($img_confirm==0){}
		else{
			//The temporary filename of the file in which the uploaded file was stored on the server.
			if(move_uploaded_file($_FILES['item_file']['tmp_name'], $path_Address) )
			{
				$item_insert="INSERT INTO 
				items(item_img,item_title,item_cat,item_description,item_qty,item_cost,item_price,item_discount,item_delivery)
				VALUES('$path_Address_db','$title','$category','$description','$qty','$cost','$price','$discount','$delivery')";

				$item_insert_run=mysqli_query($conn,$item_insert);
			}
		}
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>ADMIN'S ITEM LIST</title>
	<link rel="stylesheet" type="text/css" href="../../bootstrap/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="../../bootstrap/css/lightbox.css">
	<script src="../../jquery/js/jquery.js"></script>
	<script src="../../jquery/js/jquery-color.js"></script>
	<script src="../../jquery/js/bootstrap.js"></script>
	<script src="../../jquery/js/lightbox.js"></script>
	
	<!-- tinymce is a text-editor when we apply textarea in form it gives a editor -->
	<script src="https://cloud.tinymce.com/5/tinymce.min.js?apiKey=javuqifs3k9eihr7e656zxyfqdrz8n7kdhk0r456fp1u5jh1"></script>
 	<script>tinymce.init({ selector:'textarea' });</script>

	<script>
		function get_item_data()
		{
		xmlhttp=new XMLHttpRequest();
		xmlhttp.onreadystatechange=function(){
			if(xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				document.getElementById('get_item_data').innerHTML=xmlhttp.responseText;
			}
		}
		xmlhttp.open('GET', 'item_list_process.php', true);
		xmlhttp.send();
		}


		function delete_item(item_id)
		{
		xmlhttp=new XMLHttpRequest();
		xmlhttp.onreadystatechange=function(){
			if(xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				document.getElementById('get_item_data').innerHTML=xmlhttp.responseText;
			}
		}
		xmlhttp.open('GET', 'item_list_process.php?item_id='+item_id, true);
		xmlhttp.send();
		}
		
		

		function edit_item()
		{
		id=document.getElementById("edit_item_id").value;
		title=document.getElementById("edit_item_name").value;
		cat=document.getElementById("edit_item_category").value;
		desc=document.getElementById("edit_item_desc").value;
		qty=document.getElementById("edit_item_qty").value;
		cost=document.getElementById("edit_item_cost").value;
		price=document.getElementById("edit_item_price").value;
		discount=document.getElementById("edit_item_discount").value;
		delivery=document.getElementById("edit_item_delivery").value;

		xmlhttp.open('GET', 'item_list_process.php?edit_item_id='+id+'&item_title='+title+'&item_cat='+cat+'&item_desc='+desc+'&item_qty='+qty+'&item_cost='+cost+'&item_price='+price+'&item_disct='+discount+'&item_del='+delivery, true);
		xmlhttp.send();

		}
	</script>

	<style>
		#add_item_heading{
			font-family: arial black;
			font-size: 30px;
		}
	</style>
</head>

<body  onload="get_item_data();">
<?php include "include/header.php"?>

<div class="container-fluid">
	<button class="btn btn-danger btn-lg" data-toggle="modal" data-target="#add_new_item">ADD NEW ITEM</button>
		<div id="add_new_item" class="modal fade" data-backdrop="false">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header label-info">
						<div class="close" data-dismiss="modal">&times;</div>
						<div class="col-md-4 col-md-offset-4"><img src="images/add_item.png" title="ADD YOUR ITEM" class="img-rounded img-responsive"></div>
					</div>
					
					<div class="modal-body">
						<form method="POST" enctype="multipart/form-data">
							<div class="form-group">
								<label>ITEM IMAGE</label>
								<input type="file" name="item_file" class="form-control" required>
							</div>
							<div class="form-group">
								<label>ITEM NAME</label>
								<input type="text" name="item_name" class="form-control" required>
							</div>
							<div class="form-group">
								<label>ITEM CATEGORY</label>
								<select class="form-control" name="item_category" required>
									<option>SELECT CATEGORY</option>
									<?php
										$query="SELECT * FROM category";
										$run_query=mysqli_query($conn,$query);
										while ($rows=mysqli_fetch_assoc($run_query)) 
										{
										  echo "<option value='$rows[cat_name]'>$rows[cat_name]</option>";   
										}	
									?>
								</select>

							</div>
							<div class="form-group">
								<label>ITEM DESCRIPTION</label>
								<textarea class="form-control" style="resize: none;" rows="5" name="item_desc" required></textarea>
							</div>
							<div class="form-group">
								<label>ITEM QUANTITY</label>
								<input type="number" min="1" name="item_qty" class="form-control" required>
							</div>
							<div class="form-group">
								<label>ITEM COST</label>
								<input type="number" name="item_cost" class="form-control" required>
							</div>
							<div class="form-group">
								<label>ITEM PRICE</label>
								<input type="number" name="item_price" class="form-control" required>
							</div>
							<div class="form-group">
								<label>ITEM DISCOUNT</label>
								<input type="number" name="item_discount" class="form-control" required>
							</div>
							<div class="form-group">
								<label>ITEM DELIVERY CHARGES</label>
								<input type="number" name="item_delivery" class="form-control" min="0">
							</div>
							<div class="form-group">
								<input type="submit" name="submit_new_item" class="btn btn-success btn-lg btn-block">
							</div>
						</form>
					</div>
					
					<div class="modal-footer label-info">
						<button class="btn btn-danger pull-right" data-dismiss='modal'>CLOSE</button>
					</div>
				</div>
			</div>
		</div>
	
	<div id="get_item_data">
		<!-- GETTING THE TABLE OF ITEMS THROUGH AJAX -->
	</div>
</div>

<?php include "include/footer.php"?>
</body>
</html>













