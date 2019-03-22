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
<script>
	function check(value){
		password=document.getElementById("signup_password").value;
		confirm_password=value;
		if (password!=confirm_password) {
			document.getElementById("signup_confirm_password").style.color = 'red';
		}
		else{
			document.getElementById("signup_password").style.color = 'green';
			document.getElementById("signup_confirm_password").style.color = 'green';
			document.getElementById("message").innerHTML='PASSWORD MATCHED<br>';
		}
	}
</script>
<style>
	.container-fluid{
	width: 100%;
	height: 635px;
	background:url(images/login_signup.png);
	background-size: cover;}

	.sign_login_box{
		margin-top: 10px;
		box-shadow: 0px 10px 10px white inset;
		padding: 20px;
	}
	.form-element{
		padding-bottom:17px;
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
		<form method="post" id="signup_form" >
			
			<div class="form-element page-header text-center">
				<div class="heading_log_sign"><b>SIGN UP</div>
			</div>
			<div class="form-element">
				<input type="text" name="signup_username" class="form-control text-center" placeholder="USERNAME"   
				 required>
			</div>

			<div class="form-element">
				<input type="email" name="signup_email" class="form-control text-center" placeholder="EMAIL ADDRESS" required>
			</div>

			<div class="form-element">
				<input type="password" name="signup_password" id="signup_password" class="form-control text-center" placeholder="PASSWORD" required>
			</div>

			<div class="form-element">
				<input type="password" name="signup_confirm_password" id="signup_confirm_password" class="form-control text-center" placeholder="CONFIRM PASSWORD" onkeyup="check(this.value);" required>
				<span id="message" class="pull-right"></span>
			</div>

			<div class="form-element">
				<input type="number" name="signup_number" placeholder="CONTACT NUMBER" class="form-control  text-center" required>
			</div>

			<input type="submit" name="signup" value="SIGN UP" class="btn btn-primary btn-lg btn-block">
			<div class="form-element pull-right" style="margin-top: 20px;">
				<a href="customer_login.php" style="color: white;">ALREADY HAVE AN ACCOUNT? LOGIN!</a>
			</div>
			
		</form>
		<?php
			if (isset($_POST['signup'])) 
			{

				$username=$_POST['signup_username'];
				$email=$_POST['signup_email'];
				$password=$_POST['signup_password'];
				$confirm_password=$_POST['signup_confirm_password'];
				$contact=$_POST['signup_number'];
				
				$insert_sql="INSERT INTO customer_signup(username,email,password,confirm_password,contact) 
				VALUES('$username','$email','$password','$confirm_password','$contact')";
				
				if(mysqli_query($conn,$insert_sql)){ ?>
				
				<script>
					window.location='customer_login.php';
				</script>
				
				<?php }

				else { ?> 
					<script>
						window.location='customer_signup.php';
					</script>		
				<?php }	
			}
		?>
	</div>
	
</div>
</body>
</html>