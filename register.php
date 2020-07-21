
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

			const ctogglePassword = document.querySelector('#ctogglePassword');
            const cpassword = document.querySelector('#cpassword');

            ctogglePassword.addEventListener('click', function (e) {
			    const type = cpassword.getAttribute('type') === 'password' ? 'text' : 'password';
			    cpassword.setAttribute('type', type);
			    this.classList.toggle('fa-eye-slash');
			});
    	});
    </script>
</head>
<body>
	<div class="left-2">
    	<div class="content vertical-center">
		  	<div class="welcome">
		  		<h1>Welcome Back!</h1>
		  		<p>Sign In to continue</p>
		  	</div>
		  	<div class="button">
		  		<div><a href="index.php">Sign In</a></div>
		  	</div>
	    </div>
	</div>
	<div class="right-2">
	    <div class="form2 vertical-center">
			<form action="signup.php" method="POST">
		        <h2>Welcome</h2>
		        <h3>Register Here</h3>
		        <p class="valid1"><span style="color: red;">*</span> All Fields are Mandatory</p>
		        <?php
		            if(isset($_GET['error']))
		            {
			            if($_GET['error']=='emptyf')
			            {
			            	echo '<p class="valid">Please Fill All Details</p>';
			            }
			            else if($_GET['error']=='emptyfv')
			            {
			            	echo '<p class="valid">Please Enter Correct Name</p>';
			            }
			            else if($_GET['error']=='pwrong')
			            {
			            	echo '<p class="valid">Passwords are not Matching</p>';
			            }
			            else if($_GET['error']=='invmail')
			            {
			            	echo '<p class="valid">Please Enter Correct Email</p>';
			            }
			            else if($_GET['error']=='sqlerror')
			            {
			            	echo '<p class="valid">Could not connect to Database<br>Refresh or Try again later</p>';
			            }
			            else if($_GET['error']=='ucopy')
			            {
			            	echo '<p class="valid">Username already exists</p>';
			            }
                    }
                    else if(isset($_GET['signup']))
		            {
		            	if($_GET['signup']=='success')
		            	{
			            	echo '<p class="valid"><span style="color:green">Account Created Successfully<br>Please Login Now</span></p>';
			            }
		            }
		        ?>
				<input type="text" name="firstname" placeholder="First Name"><br><br>
				<input type="text" name="lastname" placeholder="Last Name"><br><br>
				<input type="text" name="username" placeholder="Username"><br><br>
				<div class="password-container">
					<input type="password" name="password" id="password" placeholder="Password"><i class="far fa-eye" id="togglePassword"></i>
			    </div><br>
				<div class="password-container">
					<input type="password" name="cpassword" id="cpassword" placeholder="Confirm Password"><i class="far fa-eye" id="ctogglePassword"></i>
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
				<label for="birthday" class="label">Birthday&nbsp&nbsp&nbsp</label>
                <input type="date" id="birthday" name="birthday"><br><br>
                <input type="email" name="email" placeholder="Email Id"><br><br>
				<div class="button">
				    <button type="submit" name="signup">Sign Up</button>
				</div>
				<div class="button">
				    <button type="reset">Reset</button>
				</div>
			</form>	
		</div>      
	</div>
</body>

</html>