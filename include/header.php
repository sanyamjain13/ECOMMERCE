<?php
session_start();
include 'connection.php';
?>
<style>

	.dropdown-menu{
		background: black;
	}
	.dropdown-menu li a{
		color: white;
		font-weight: bold;
		text-align: center;
	}

	#search_bar{
		background: black;
		color: white;
		box-shadow: 0 0 5px white inset;
	}

	#search_icon{
		background: green;
		color: white;
	}

	.search_title_list{
		background:black ;
		color: white;
	}
</style>
<script>
	setInterval(function(){
		var d=new Date();
		document.getElementById('time').innerHTML=d.toLocaleTimeString();
	},1000);
</script>
<script>

	function refresh()
	{
		document.location.reload(true);
	}

	//checking if the registered contact is in database or not
	function check_contact(contact)
	{
		var xmlhttp=new XMLHttpRequest;
		xmlhttp.onreadystatechange=function(){

			if(xmlhttp.readyState==4 && xmlhttp.status==200)
				{
					document.getElementById('check_contact').innerHTML=xmlhttp.responseText;
				}
		}
		xmlhttp.open('GET','update_pass_process.php?contact='+contact,true);
		xmlhttp.send();
	}

	//checking if the current password of the user is correct or not
	function check_current_pass(current_pass)
	{	
		var xmlhttp=new XMLHttpRequest;
		var contact=document.getElementById('contact').value;

		xmlhttp.onreadystatechange=function(){

			if(xmlhttp.readyState==4 && xmlhttp.status==200)
				{
					document.getElementById('current_pass_icon').innerHTML=xmlhttp.responseText;
				}
		}
		xmlhttp.open('GET','update_pass_process.php?current_pass='+current_pass+'&contact_num='+contact,true);
		xmlhttp.send();
	}

	//checking if confirm pass and password entered matches or not
	function check(confirm_pass){

		password=document.getElementById('new_password').value;
		if(password!=confirm_pass && confirm_pass!=" ")
		{
			document.getElementById('new_password').style.color = 'red';
			document.getElementById('confirm_password').style.color = 'red';

			document.getElementById('confirm_pass_icon').style.color = 'red';

			document.getElementById('confirm_pass_icon').className='pull-right glyphicon glyphicon-remove';
		}

		else
		{
			document.getElementById('new_password').style.color = 'green';
			document.getElementById('confirm_password').style.color = 'green';

			document.getElementById('pass_icon').style.color = 'green';
			document.getElementById('confirm_pass_icon').style.color = 'green';

			document.getElementById('pass_icon').className='pull-right glyphicon glyphicon-ok';
			document.getElementById('confirm_pass_icon').className='pull-right glyphicon glyphicon-ok';

		}
	}

	//function for search bar
	function search_title(name){
		var xmlhttp=new XMLHttpRequest();
		xmlhttp.onreadystatechange=function(){

			if(xmlhttp.readyState==4 && xmlhttp.status==200)
				{
					document.getElementById('search_title').innerHTML=xmlhttp.responseText;
				}
		}
		xmlhttp.open('GET','search_title_process.php?title='+name,true);
		xmlhttp.send();
	}

</script>
<nav class="navbar navbar-inverse">
		<div class="container-fluid">
			
			<div class="navbar-header">
				<a  class="navbar-brand">ONLINE ELECTRONICS</a>
				
				<button class="navbar-btn btn-default navbar-toggle pull-left" data-toggle="collapse" data-target="#navs">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>
<!-- ------------------------------------------------------------------------------------------------ -->

			<div class="nav navbar-nav navbar-collapse collapse" id="navs">
				<li><a href="home.php">HOME</a></li>
				
				<?php
					
					$cat_sql="SELECT * FROM category";
					$cat_run=mysqli_query($conn,$cat_sql);
					
					while($rows=mysqli_fetch_assoc($cat_run))
					{	
						
						if($rows['cat_slug']==" ")
							{
								$cat_slug=$rows['cat_name'];
							}
						else 
							{
								$cat_slug=$rows['cat_slug'];
							}
						

						print("
							<li><a href='category.php?category=$cat_slug'>$rows[cat_name]</a></li>
							");
					}
				?>
			</div>
<!-- ------------------------------------------------------------------------------------------------ -->
		<!-- RIGHT NAVBAR -->
			
			<!-- date time and welcome user -->			
			<div class="nav navbar-nav navbar-right">
				
				<li><a><span class="glyphicon glyphicon-cloud"></span>    
					<?php
						$date=date('d-M-Y');
						echo $date; 
					?></a></li>

				<li><a id="time"></a></li>
				
				<li><a>    
					WELCOME
					<?php
						echo strtoupper($_SESSION['username']);  
					?></a></li>
				
<!-- ------------------------------------------------------------------------------------------------ -->
				<!-- user icon dropdown -->

				<li class="dropdown bg-primary"><a href="#" data-toggle='dropdown' class="dropdown-toggle">
				<span class="glyphicon glyphicon-user"></span><span class="caret"></span></a>
					
					<ul class="nav nav-pills nav-stacked dropdown-menu ">
						
						<li class="dropdown-header" style="margin-top: 20px; margin-bottom: -20px;">
							
							<!-- SEARCH YOUR ITEM USING AJAX -->
							
							<div class="input-group">
								<input type="text" name="search" id="search_bar" placeholder="SEARCH ITEM" class="form-control" onkeyup="search_title(this.value)">

								<div class=" input-group-addon" id="search_icon">
									<span class="glyphicon glyphicon-search"></span>
								</div>
							</div>

							<!-- ajax request for search title will come here -->
							<span  style="text-align: center;">
								<table class="table table-striped table-hover">
									<thead id="search_title">
										<!-- PROCESS DATA FROM AJAX -->
									</thead>
								</table>
							</span>	
						</li>
						<li class="nav-divider"></li>

<!-- ------------------------------------------------------------------------------------------------ -->
								
						<li class="dropdown-header">
							<a href="#update_pass" data-toggle='modal' data-backdrop='static' data-keyboard='false'>UPDATE PASSWORD</a>
						</li>
						<li class="nav-divider"></li>
<!-- ------------------------------------------------------------------------------------------------ -->

						<li class="dropdown-header">
							<a href="buy.php" class="glyphicon glyphicon-gift"> YOUR CART </a>
						</li>
						<li class="nav-divider"></li>

						<li class="dropdown-header">
							<a href="order_history.php" class="glyphicon glyphicon-briefcase"> ORDER HISTORY</a>
						</li>
						<li class="nav-divider"></li>

<!-- ------------------------------------------------------------------------------------------------ -->

						<li class="dropdown-header">
							<a href="logout.php" class="glyphicon glyphicon-log-out"> LOGOUT</a>
						</li>
					</ul>
					
				</li>

<!-- ------------------------------------------------------------------------------------------------ -->

				<!-- modal for updating password -->
				<div class='modal fade' id="update_pass">
					<div class='modal-dialog'>
						<div class='modal-content'>
							<div class="modal-header bg-success">
								
								<!-- when close button click it will reload the page -->
								<button class="close" data-dismiss='modal' onclick="refresh();">&times;</button>

								<h2 class="text-center" style="word-spacing: 7px; letter-spacing: 7px; font-family:  arial black;"><b>UPDATE PASSWORD <span class="glyphicon glyphicon-edit"></span>
								</b></h2>

							</div>

							<div class='modal-body'>
								<form class="text-center" method="post" id="update_form">
									<div class="form-group">
										<label>CONTACT NUMBER</label>
										<input type="number" name="contact" id="contact" class="form-control text-center" placeholder="REGISTERED CONTACT" onkeyup="check_contact(this.value);" required>
										
										<span id="check_contact" class="pull-right"></span>
									</div>

									<div class="form-group">
										<label>CURRENT PASSWORD</label>
										<input type="password" name="current_password" id="current_password" class="form-control text-center" style="font-size: 25px;" 
										onkeyup="check_current_pass(this.value);" required>

										<span id="current_pass_icon" class="pull-right"></span>

									</div>

									<div class="form-group">
										<label>NEW PASSWORD</label>
										<input type="password" name="new_password" id="new_password" class="form-control text-center" style="font-size: 25px;" required>

										<span id="pass_icon"></span>

									</div>

									<div class="form-group">
										<label>RETYPE PASSWORD</label>
										<input type="password" name="confirm_password" id="confirm_password" class="form-control text-center" style="font-size: 25px;" 
										onkeyup="check(this.value);" placeholder="" required>
										
										<span id="confirm_pass_icon"></span><br>
									</div>

									<div class="form-group">
										<input type="submit" class="btn btn-success btn-block btn-lg" 
										value="UPDATE PASSWORD" name="update">
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
<!-- ------------------------------------------------------------------------------------------------ -->
	
				<?php

					//HERE THE PASSWORD IS UPDATING IN THE DATABASE
					if (isset($_POST['update']) && !empty($_POST['new_password']) ) 
					{
						$number=$_POST['contact'];
						$current_password=$_POST['current_password'];
						$password=$_POST['new_password'];
						$confirm_password=$_POST['confirm_password'];
						$update_query="UPDATE customer_signup SET password='$password',confirm_password='$confirm_password' WHERE contact='$number' AND password='$current_password'";

						if(mysqli_query($conn,$update_query)){?>

							<script>
								window.location='home.php';
								alert("PASSWORD SUCCESSFULLY UPDATED");
							</script>

						<?php }
						else{?>
							
							<script>
								window.location='home.php';
								alert("PASSWORD NOT UPDATED, PLEASE TRY AGAIN");
							</script>

						<?php }
					}

				?>
<!-- ------------------------------------------------------------------------------------------------ -->


			</div>
			
		</div>
</nav>
<?php
session_start();
include 'connection.php';
?>
<style>

	.dropdown-menu{
		background: black;
	}
	.dropdown-menu li a{
		color: white;
		font-weight: bold;
		text-align: center;
	}

	#search_bar{
		background: black;
		color: white;
		box-shadow: 0 0 5px white inset;
	}

	#search_icon{
		background: green;
		color: white;
	}

	.search_title_list{
		background:black ;
		color: white;
	}
</style>
<script>
	setInterval(function(){
		var d=new Date();
		document.getElementById('time').innerHTML=d.toLocaleTimeString();
	},1000);
</script>
<script>

	function refresh()
	{
		document.location.reload(true);
	}

	//checking if the registered contact is in database or not
	function check_contact(contact)
	{
		var xmlhttp=new XMLHttpRequest;
		xmlhttp.onreadystatechange=function(){

			if(xmlhttp.readyState==4 && xmlhttp.status==200)
				{
					document.getElementById('check_contact').innerHTML=xmlhttp.responseText;
				}
		}
		xmlhttp.open('GET','update_pass_process.php?contact='+contact,true);
		xmlhttp.send();
	}

	//checking if the current password of the user is correct or not
	function check_current_pass(current_pass)
	{	
		var xmlhttp=new XMLHttpRequest;
		var contact=document.getElementById('contact').value;

		xmlhttp.onreadystatechange=function(){

			if(xmlhttp.readyState==4 && xmlhttp.status==200)
				{
					document.getElementById('current_pass_icon').innerHTML=xmlhttp.responseText;
				}
		}
		xmlhttp.open('GET','update_pass_process.php?current_pass='+current_pass+'&contact_num='+contact,true);
		xmlhttp.send();
	}

	//checking if confirm pass and password entered matches or not
	function check(confirm_pass){

		password=document.getElementById('new_password').value;
		if(password!=confirm_pass && confirm_pass!=" ")
		{
			document.getElementById('new_password').style.color = 'red';
			document.getElementById('confirm_password').style.color = 'red';

			document.getElementById('confirm_pass_icon').style.color = 'red';

			document.getElementById('confirm_pass_icon').className='pull-right glyphicon glyphicon-remove';
		}

		else
		{
			document.getElementById('new_password').style.color = 'green';
			document.getElementById('confirm_password').style.color = 'green';

			document.getElementById('pass_icon').style.color = 'green';
			document.getElementById('confirm_pass_icon').style.color = 'green';

			document.getElementById('pass_icon').className='pull-right glyphicon glyphicon-ok';
			document.getElementById('confirm_pass_icon').className='pull-right glyphicon glyphicon-ok';

		}
	}

	//function for search bar
	function search_title(name){
		var xmlhttp=new XMLHttpRequest();
		xmlhttp.onreadystatechange=function(){

			if(xmlhttp.readyState==4 && xmlhttp.status==200)
				{
					document.getElementById('search_title').innerHTML=xmlhttp.responseText;
				}
		}
		xmlhttp.open('GET','search_title_process.php?title='+name,true);
		xmlhttp.send();
	}

</script>
<nav class="navbar navbar-inverse">
		<div class="container-fluid">
			
			<div class="navbar-header">
				<a  class="navbar-brand">ONLINE ELECTRONICS</a>
				
				<button class="navbar-btn btn-default navbar-toggle pull-left" data-toggle="collapse" data-target="#navs">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>
<!-- ------------------------------------------------------------------------------------------------ -->

			<div class="nav navbar-nav navbar-collapse collapse" id="navs">
				<li><a href="home.php">HOME</a></li>
				
				<?php
					
					$cat_sql="SELECT * FROM category";
					$cat_run=mysqli_query($conn,$cat_sql);
					
					while($rows=mysqli_fetch_assoc($cat_run))
					{	
						
						if($rows['cat_slug']==" ")
							{
								$cat_slug=$rows['cat_name'];
							}
						else 
							{
								$cat_slug=$rows['cat_slug'];
							}
						

						print("
							<li><a href='category.php?category=$cat_slug'>$rows[cat_name]</a></li>
							");
					}
				?>
			</div>
<!-- ------------------------------------------------------------------------------------------------ -->
		<!-- RIGHT NAVBAR -->
			
			<!-- date time and welcome user -->			
			<div class="nav navbar-nav navbar-right">
				
				<li><a><span class="glyphicon glyphicon-cloud"></span>    
					<?php
						$date=date('d-M-Y');
						echo $date; 
					?></a></li>

				<li><a id="time"></a></li>
				
				<li><a>    
					WELCOME
					<?php
						echo strtoupper($_SESSION['username']);  
					?></a></li>
				
<!-- ------------------------------------------------------------------------------------------------ -->
				<!-- user icon dropdown -->

				<li class="dropdown bg-primary"><a href="#" data-toggle='dropdown' class="dropdown-toggle">
				<span class="glyphicon glyphicon-user"></span><span class="caret"></span></a>
					
					<ul class="nav nav-pills nav-stacked dropdown-menu ">
						
						<li class="dropdown-header" style="margin-top: 20px; margin-bottom: -20px;">
							
							<!-- SEARCH YOUR ITEM USING AJAX -->
							
							<div class="input-group">
								<input type="text" name="search" id="search_bar" placeholder="SEARCH ITEM" class="form-control" onkeyup="search_title(this.value)">

								<div class=" input-group-addon" id="search_icon">
									<span class="glyphicon glyphicon-search"></span>
								</div>
							</div>

							<!-- ajax request for search title will come here -->
							<span  style="text-align: center;">
								<table class="table table-striped table-hover">
									<thead id="search_title">
										<!-- PROCESS DATA FROM AJAX -->
									</thead>
								</table>
							</span>	
						</li>
						<li class="nav-divider"></li>

<!-- ------------------------------------------------------------------------------------------------ -->
								
						<li class="dropdown-header">
							<a href="#update_pass" data-toggle='modal' data-backdrop='static' data-keyboard='false'>UPDATE PASSWORD</a>
						</li>
						<li class="nav-divider"></li>
<!-- ------------------------------------------------------------------------------------------------ -->

						<li class="dropdown-header">
							<a href="buy.php" class="glyphicon glyphicon-gift"> YOUR CART </a>
						</li>
						<li class="nav-divider"></li>

						<li class="dropdown-header">
							<a href="order_history.php" class="glyphicon glyphicon-briefcase"> ORDER HISTORY</a>
						</li>
						<li class="nav-divider"></li>

<!-- ------------------------------------------------------------------------------------------------ -->

						<li class="dropdown-header">
							<a href="logout.php" class="glyphicon glyphicon-log-out"> LOGOUT</a>
						</li>
					</ul>
					
				</li>

<!-- ------------------------------------------------------------------------------------------------ -->

				<!-- modal for updating password -->
				<div class='modal fade' id="update_pass">
					<div class='modal-dialog'>
						<div class='modal-content'>
							<div class="modal-header bg-success">
								
								<!-- when close button click it will reload the page -->
								<button class="close" data-dismiss='modal' onclick="refresh();">&times;</button>

								<h2 class="text-center" style="word-spacing: 7px; letter-spacing: 7px; font-family:  arial black;"><b>UPDATE PASSWORD <span class="glyphicon glyphicon-edit"></span>
								</b></h2>

							</div>

							<div class='modal-body'>
								<form class="text-center" method="post" id="update_form">
									<div class="form-group">
										<label>CONTACT NUMBER</label>
										<input type="number" name="contact" id="contact" class="form-control text-center" placeholder="REGISTERED CONTACT" onkeyup="check_contact(this.value);" required>
										
										<span id="check_contact" class="pull-right"></span>
									</div>

									<div class="form-group">
										<label>CURRENT PASSWORD</label>
										<input type="password" name="current_password" id="current_password" class="form-control text-center" style="font-size: 25px;" 
										onkeyup="check_current_pass(this.value);" required>

										<span id="current_pass_icon" class="pull-right"></span>

									</div>

									<div class="form-group">
										<label>NEW PASSWORD</label>
										<input type="password" name="new_password" id="new_password" class="form-control text-center" style="font-size: 25px;" required>

										<span id="pass_icon"></span>

									</div>

									<div class="form-group">
										<label>RETYPE PASSWORD</label>
										<input type="password" name="confirm_password" id="confirm_password" class="form-control text-center" style="font-size: 25px;" 
										onkeyup="check(this.value);" placeholder="" required>
										
										<span id="confirm_pass_icon"></span><br>
									</div>

									<div class="form-group">
										<input type="submit" class="btn btn-success btn-block btn-lg" 
										value="UPDATE PASSWORD" name="update">
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
<!-- ------------------------------------------------------------------------------------------------ -->
	
				<?php

					//HERE THE PASSWORD IS UPDATING IN THE DATABASE
					if (isset($_POST['update']) && !empty($_POST['new_password']) ) 
					{
						$number=$_POST['contact'];
						$current_password=$_POST['current_password'];
						$password=$_POST['new_password'];
						$confirm_password=$_POST['confirm_password'];
						$update_query="UPDATE customer_signup SET password='$password',confirm_password='$confirm_password' WHERE contact='$number' AND password='$current_password'";

						if(mysqli_query($conn,$update_query)){?>

							<script>
								window.location='home.php';
								alert("PASSWORD SUCCESSFULLY UPDATED");
							</script>

						<?php }
						else{?>
							
							<script>
								window.location='home.php';
								alert("PASSWORD NOT UPDATED, PLEASE TRY AGAIN");
							</script>

						<?php }
					}

				?>
<!-- ------------------------------------------------------------------------------------------------ -->


			</div>
			
		</div>
</nav>
<?php
session_start();
include 'connection.php';
?>
<style>

	.dropdown-menu{
		background: black;
	}
	.dropdown-menu li a{
		color: white;
		font-weight: bold;
		text-align: center;
	}

	#search_bar{
		background: black;
		color: white;
		box-shadow: 0 0 5px white inset;
	}

	#search_icon{
		background: green;
		color: white;
	}

	.search_title_list{
		background:black ;
		color: white;
	}
</style>
<script>
	setInterval(function(){
		var d=new Date();
		document.getElementById('time').innerHTML=d.toLocaleTimeString();
	},1000);
</script>
<script>

	function refresh()
	{
		document.location.reload(true);
	}

	//checking if the registered contact is in database or not
	function check_contact(contact)
	{
		var xmlhttp=new XMLHttpRequest;
		xmlhttp.onreadystatechange=function(){

			if(xmlhttp.readyState==4 && xmlhttp.status==200)
				{
					document.getElementById('check_contact').innerHTML=xmlhttp.responseText;
				}
		}
		xmlhttp.open('GET','update_pass_process.php?contact='+contact,true);
		xmlhttp.send();
	}

	//checking if the current password of the user is correct or not
	function check_current_pass(current_pass)
	{	
		var xmlhttp=new XMLHttpRequest;
		var contact=document.getElementById('contact').value;

		xmlhttp.onreadystatechange=function(){

			if(xmlhttp.readyState==4 && xmlhttp.status==200)
				{
					document.getElementById('current_pass_icon').innerHTML=xmlhttp.responseText;
				}
		}
		xmlhttp.open('GET','update_pass_process.php?current_pass='+current_pass+'&contact_num='+contact,true);
		xmlhttp.send();
	}

	//checking if confirm pass and password entered matches or not
	function check(confirm_pass){

		password=document.getElementById('new_password').value;
		if(password!=confirm_pass && confirm_pass!=" ")
		{
			document.getElementById('new_password').style.color = 'red';
			document.getElementById('confirm_password').style.color = 'red';

			document.getElementById('confirm_pass_icon').style.color = 'red';

			document.getElementById('confirm_pass_icon').className='pull-right glyphicon glyphicon-remove';
		}

		else
		{
			document.getElementById('new_password').style.color = 'green';
			document.getElementById('confirm_password').style.color = 'green';

			document.getElementById('pass_icon').style.color = 'green';
			document.getElementById('confirm_pass_icon').style.color = 'green';

			document.getElementById('pass_icon').className='pull-right glyphicon glyphicon-ok';
			document.getElementById('confirm_pass_icon').className='pull-right glyphicon glyphicon-ok';

		}
	}

	//function for search bar
	function search_title(name){
		var xmlhttp=new XMLHttpRequest();
		xmlhttp.onreadystatechange=function(){

			if(xmlhttp.readyState==4 && xmlhttp.status==200)
				{
					document.getElementById('search_title').innerHTML=xmlhttp.responseText;
				}
		}
		xmlhttp.open('GET','search_title_process.php?title='+name,true);
		xmlhttp.send();
	}

</script>
<nav class="navbar navbar-inverse">
		<div class="container-fluid">
			
			<div class="navbar-header">
				<a  class="navbar-brand">ONLINE ELECTRONICS</a>
				
				<button class="navbar-btn btn-default navbar-toggle pull-left" data-toggle="collapse" data-target="#navs">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>
<!-- ------------------------------------------------------------------------------------------------ -->

			<div class="nav navbar-nav navbar-collapse collapse" id="navs">
				<li><a href="home.php">HOME</a></li>
				
				<?php
					
					$cat_sql="SELECT * FROM category";
					$cat_run=mysqli_query($conn,$cat_sql);
					
					while($rows=mysqli_fetch_assoc($cat_run))
					{	
						
						if($rows['cat_slug']==" ")
							{
								$cat_slug=$rows['cat_name'];
							}
						else 
							{
								$cat_slug=$rows['cat_slug'];
							}
						

						print("
							<li><a href='category.php?category=$cat_slug'>$rows[cat_name]</a></li>
							");
					}
				?>
			</div>
<!-- ------------------------------------------------------------------------------------------------ -->
		<!-- RIGHT NAVBAR -->
			
			<!-- date time and welcome user -->			
			<div class="nav navbar-nav navbar-right">
				
				<li><a><span class="glyphicon glyphicon-cloud"></span>    
					<?php
						$date=date('d-M-Y');
						echo $date; 
					?></a></li>

				<li><a id="time"></a></li>
				
				<li><a>    
					WELCOME
					<?php
						echo strtoupper($_SESSION['username']);  
					?></a></li>
				
<!-- ------------------------------------------------------------------------------------------------ -->
				<!-- user icon dropdown -->

				<li class="dropdown bg-primary"><a href="#" data-toggle='dropdown' class="dropdown-toggle">
				<span class="glyphicon glyphicon-user"></span><span class="caret"></span></a>
					
					<ul class="nav nav-pills nav-stacked dropdown-menu ">
						
						<li class="dropdown-header" style="margin-top: 20px; margin-bottom: -20px;">
							
							<!-- SEARCH YOUR ITEM USING AJAX -->
							
							<div class="input-group">
								<input type="text" name="search" id="search_bar" placeholder="SEARCH ITEM" class="form-control" onkeyup="search_title(this.value)">

								<div class=" input-group-addon" id="search_icon">
									<span class="glyphicon glyphicon-search"></span>
								</div>
							</div>

							<!-- ajax request for search title will come here -->
							<span  style="text-align: center;">
								<table class="table table-striped table-hover">
									<thead id="search_title">
										<!-- PROCESS DATA FROM AJAX -->
									</thead>
								</table>
							</span>	
						</li>
						<li class="nav-divider"></li>

<!-- ------------------------------------------------------------------------------------------------ -->
								
						<li class="dropdown-header">
							<a href="#update_pass" data-toggle='modal' data-backdrop='static' data-keyboard='false'>UPDATE PASSWORD</a>
						</li>
						<li class="nav-divider"></li>
<!-- ------------------------------------------------------------------------------------------------ -->

						<li class="dropdown-header">
							<a href="buy.php" class="glyphicon glyphicon-gift"> YOUR CART </a>
						</li>
						<li class="nav-divider"></li>

						<li class="dropdown-header">
							<a href="order_history.php" class="glyphicon glyphicon-briefcase"> ORDER HISTORY</a>
						</li>
						<li class="nav-divider"></li>

<!-- ------------------------------------------------------------------------------------------------ -->

						<li class="dropdown-header">
							<a href="logout.php" class="glyphicon glyphicon-log-out"> LOGOUT</a>
						</li>
					</ul>
					
				</li>

<!-- ------------------------------------------------------------------------------------------------ -->

				<!-- modal for updating password -->
				<div class='modal fade' id="update_pass">
					<div class='modal-dialog'>
						<div class='modal-content'>
							<div class="modal-header bg-success">
								
								<!-- when close button click it will reload the page -->
								<button class="close" data-dismiss='modal' onclick="refresh();">&times;</button>

								<h2 class="text-center" style="word-spacing: 7px; letter-spacing: 7px; font-family:  arial black;"><b>UPDATE PASSWORD <span class="glyphicon glyphicon-edit"></span>
								</b></h2>

							</div>

							<div class='modal-body'>
								<form class="text-center" method="post" id="update_form">
									<div class="form-group">
										<label>CONTACT NUMBER</label>
										<input type="number" name="contact" id="contact" class="form-control text-center" placeholder="REGISTERED CONTACT" onkeyup="check_contact(this.value);" required>
										
										<span id="check_contact" class="pull-right"></span>
									</div>

									<div class="form-group">
										<label>CURRENT PASSWORD</label>
										<input type="password" name="current_password" id="current_password" class="form-control text-center" style="font-size: 25px;" 
										onkeyup="check_current_pass(this.value);" required>

										<span id="current_pass_icon" class="pull-right"></span>

									</div>

									<div class="form-group">
										<label>NEW PASSWORD</label>
										<input type="password" name="new_password" id="new_password" class="form-control text-center" style="font-size: 25px;" required>

										<span id="pass_icon"></span>

									</div>

									<div class="form-group">
										<label>RETYPE PASSWORD</label>
										<input type="password" name="confirm_password" id="confirm_password" class="form-control text-center" style="font-size: 25px;" 
										onkeyup="check(this.value);" placeholder="" required>
										
										<span id="confirm_pass_icon"></span><br>
									</div>

									<div class="form-group">
										<input type="submit" class="btn btn-success btn-block btn-lg" 
										value="UPDATE PASSWORD" name="update">
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
<!-- ------------------------------------------------------------------------------------------------ -->
	
				<?php

					//HERE THE PASSWORD IS UPDATING IN THE DATABASE
					if (isset($_POST['update']) && !empty($_POST['new_password']) ) 
					{
						$number=$_POST['contact'];
						$current_password=$_POST['current_password'];
						$password=$_POST['new_password'];
						$confirm_password=$_POST['confirm_password'];
						$update_query="UPDATE customer_signup SET password='$password',confirm_password='$confirm_password' WHERE contact='$number' AND password='$current_password'";

						if(mysqli_query($conn,$update_query)){?>

							<script>
								window.location='home.php';
								alert("PASSWORD SUCCESSFULLY UPDATED");
							</script>

						<?php }
						else{?>
							
							<script>
								window.location='home.php';
								alert("PASSWORD NOT UPDATED, PLEASE TRY AGAIN");
							</script>

						<?php }
					}

				?>
<!-- ------------------------------------------------------------------------------------------------ -->


			</div>
			
		</div>
</nav>
