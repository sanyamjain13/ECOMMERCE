<?php 

include 'include/connection.php';


//FOR CHECKING IF THE CONTACT NUMBER TYPED IS MATCHING THE REGISTERED CONTACT
if (isset($_REQUEST['contact'])) {
	
	$contact=$_REQUEST['contact'];

	$query="SELECT * FROM customer_signup WHERE contact='$contact'";
	$run=mysqli_query($conn,$query);
	
	if (mysqli_num_rows($run)==1) 
	{
		
		$row=mysqli_fetch_assoc($run);
		
		if($row['contact']==$contact)
		{
			echo "<b style='color:green'><span class='glyphicon glyphicon-ok'></span></b>";
				
		}
	}

	else
	{
		echo "<b style='color:red'><span class='glyphicon glyphicon-remove'></span></b>";
	}
}

//HERE CHECKING IF THE CURRENT PASSWORD IS CORRECT OR NOT
if (isset($_REQUEST['contact_num']) || isset($_REQUEST['current_pass'])) {
	
	$password=$_REQUEST['current_pass'];
	$contact_number=$_REQUEST['contact_num'];

	$query="SELECT * FROM customer_signup WHERE contact='$contact_number' AND password='$password'";
	$run=mysqli_query($conn,$query);
	
	if (mysqli_num_rows($run)==1) 
	{
		
		$rows=mysqli_fetch_assoc($run);
		
		if($rows['password']==$_REQUEST['current_pass'])
		{
			echo "<b style='color:green'><span class='glyphicon glyphicon-ok'></span></b>";
				
		}
	}

	else
	{
		echo "<b style='color:red'><span class='glyphicon glyphicon-remove'></span></b>";
	}
}


?>
	