<?php
include 'include/connection.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>CUSTOMER LOGIN-SIGNUP</title>
	<link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="../bootstrap/css/lightbox.css">
	<script src="../jquery/js/jquery.js"></script>
	<script src="../jquery/js/jquery-color.js"></script>
	<script src="../jquery/js/bootstrap.js"></script>
	<script src="../jquery/js/lightbox.js"></script>
	<link rel="stylesheet" type="text/css" href="project_css/signup_login.css">

</head>
<style>
	.container-fluid{
	width: 100%;
	height: 635px;
	background:url(images/login_signup.png);
	background-size: cover;}

	.sign_login_box{
		margin-top: 70px;
		box-shadow: 0px 10px 10px silver inset;
		padding: 20px;
	}
	.form-element{
		padding-bottom:20px;
		color: white; 
	}
	.form-element input{
		background:black;
		border: none;
		outline: none;
		color: white;
		font-size: 19px;
		height: 50px;
		background:rgb(0,0,0,0.4);
	}
	.heading_log_sign{
		font-size: 40px;
		letter-spacing: 7px;
		opacity: 0.7;
		text-shadow: 10px 10px 10px black;
	}

</style>
<body>
<div class="container-fluid">
	
	<div class="col-md-5 col-md-offset-4 sign_login_box">
		<form method="post" id="login_form" onsubmit="check();">

			<div class="form-element page-header text-center">
				<div class="heading_log_sign"><b>LOGIN USER</div>
				<span id="message"></span><br>
			</div>
						
			<div class="form-element">
				<input type="email" name="login_email" id="login_email" class="form-control text-center" placeholder="EMAIL ADDRESS"><span id="message_email" class="pull-right" style="font-style: italic;"></span>
			</div>

			<div class="form-element">
				<input type="password" name="login_password" id="login_password" class="form-control text-center" placeholder="PASSWORD"><span id="message_pass" class="pull-right" style="font-style: italic;"></span>
			</div>

			<div class="form-element">
				<input type="number" name="login_number" id="login_number" placeholder="CONTACT NUMBER" class="form-control  text-center"><span id="message_number" class="pull-right" style="font-style: italic;"></span>
			</div>

			<input type="submit" name="login" value="LOGIN" class="btn btn-success btn-lg btn-block">
			
			<div class="form-element pull-right" style="margin-top: 20px;">
				<a href="customer_signup.php" style="color: white;">DONT HAVE AN ACCOUNT? SIGN UP!</a>
			</div>
		</form>
		
		<?php

			if (isset($_POST['login'])) {
				
				$email=$_POST['login_email'];
				$password=$_POST['login_password'];
				$contact=$_POST['login_number'];
				$sel_sql="SELECT * FROM customer_signup WHERE contact='$contact'";
				$run_sql=mysqli_query($conn,$sel_sql);
				
				$date=date("Y-m-d h:i:s");
				$rand_num=mt_rand();
				
				while($rows=mysqli_fetch_assoc($run_sql))
				{
					if(empty($email) || empty($password) || empty($contact))
					{?>
						<script>
							document.getElementById('message').innerHTML='FIELDS  ARE  EMPTY !!';
							document.getElementById('message').style.color = 'red';
							document.getElementById('message').style.align = 'center';
							document.getElementById('message').style.letterSpacing = '5px';
							document.getElementById('message').style.wordSpacing = '6px';
							document.getElementById('message').style.fontStyle = 'italic';
						</script>

					<?php }

					elseif($rows['email']!=$email && $rows['password']!=$password && $rows['contact']!=$contact){?>
					
						<script>
							document.getElementById('message_email').innerHTML='EMAIL IS INCORRECT';
							document.getElementById('message_number').innerHTML='NUMBER IS INCORRECT';
							document.getElementById('message_pass').innerHTML='PASSWORD IS INCORRECT';

						</script>


					<?php }

					elseif($rows['email']!=$email)
					{
						echo "<script>
							document.getElementById('message_email').innerHTML='EMAIL IS INCORRECT';
							document.getElementById('message_email').style.color = 'red';
							</script>";	
					}
					elseif($rows['password']!=$password)
					{
						echo "<script>
							document.getElementById('message_pass').innerHTML='PASSWORD IS INCORRECT';
							document.getElementById('message_pass').style.color = 'red';
							</script>";	
					}

					elseif($rows['contact']!=$contact)
					{
						echo "<script>
							document.getElementById('message_number').innerHTML='CONTACT IS INCORRECT';
							document.getElementById('message_number').style.color = 'red';
							</script>";	
					}
					else {
						session_start();
						$_SESSION['username']="$rows[username]";
						$_SESSION['ref']=$date.'_'.$rand_num;
						header("location: home.php");
						
					}

				}	
			}

		?>

	</div>
	
</div>
</body>
</html>
