<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Forum</title>
	<meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="main.css?version=3.2">
    <link href="https://fonts.googleapis.com/css2?family=Varela+Round&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css" >
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
    	$(document).ready(function(){
    		const togglePassword = document.querySelector('#togglePassword');
            const password = document.querySelector('#password');

            togglePassword.addEventListener('click', function (e) {
			    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
			    password.setAttribute('type', type);
			    this.classList.toggle('fa-eye-slash');
			});
    	});
    </script>
</head>
<body>
	<div class="left-1">
	    <div class="content vertical-center">
		  	<div class="welcome">
		  		<h1>Hello !</h1>
		  		<p>Enter your details and start using our platform to discuss</p>
		  	</div>
		  	<div class="button">
		  	    <a href="register.php">Register</a>
		  	</div>
	    </div>
    </div>

	<div class="right-1"> 
        <div class="form vertical-center">
    		<form action="login.php" method="POST">
    			<h2>Welcome Back !</h2>
    			<?php
    			    if(isset($_GET['error']))
    			    { 
	                    if($_GET['error']=='filldetails' || $_GET['error']=='empty')
	                    {
	                    	echo '<p class="valid">Please Fill all Details</p>';
	                    }
	                    else if($_GET['error']=='sqlerror')
	                    {
	                        echo '<p class="valid">Could not connect to Database<br>Refresh or Try again later</p>';
	                    }
	                    else if($_GET['error']=='wrong')
	                    {
	                    	echo '<p class="valid">Please Fill Correct Details</p>';
	                    }
	                    else if($_GET['error']=='wrongpwd')
	                    {
	                    	echo '<p class="valid">Please Enter Correct Password</p>';
	                    }
	                }
    			?>
    			<input type="text" name="username" id="username" placeholder="Username"><br><br>
    			<div class="password-container">
					<input type="password" name="password" id="password" placeholder="Enter Password"><i class="far fa-eye" id="togglePassword"></i>
			    </div>
				<p class="label">Select Account Type</p>
    			<div class="admin">
    				<div>
	    				<input type="radio" id="admin" name="acctype" value="a">
						<label for="admin" class="radio">Admin</label>
					</div>
					<div>
						<input type="radio" id="user" name="acctype" value="u">
					    <label for="user" class="radio">User</label>
					</div>
    			</div>
    			<div class="button">
    			    <button type="submit" name="login">Sign In</button>
    			</div>
    		</form>	
    	</div>    
	</div>
    
	

	
</body>
</html>