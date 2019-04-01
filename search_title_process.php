<?php
include 'include/connection.php';
if (isset($_REQUEST['title'])) 
{	
	$min_len=1;

	if(strlen($_REQUEST['title']) >= $min_len)
	{
		$title_name=htmlspecialchars($_REQUEST['title']);
		$title_name=mysqli_real_escape_string($conn,$title_name);
		$title_name=strtoupper($title_name);
		
		$sql="SELECT * FROM items WHERE item_title LIKE '%".$title_name."%'";
		$run=mysqli_query($conn,$sql);

		if(mysqli_num_rows($run)){

			while($row=mysqli_fetch_assoc($run)){

				// echo "
				// <div class='list-group'>
				// 	<a href='item.php?id=$row[item_id]&title=$row[item_title]' style='color:black;'>
				// 		<div class='list-group-item search_title_list'>
				// 		<b>$row[item_title]</b>
				// 		</div>
				// 	</a>
				// </div>";	

				echo "
					<tr>
						<th class='text-center'>
						<a href='item.php?id=$row[item_id]&title=$row[item_title]' class='search_title_list'>
						$row[item_title]</a>
						</th>
					</tr>
					</a>
				";		
			}
		}

		else{

			echo "
				<tr>
					<th class='text-center' style='color:white;'>NO RESULT FOUND <span class='glyphicon glyphicon-remove'></span></th>
				</tr>
				";
			
		}
	}
}

?>