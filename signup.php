<?php

if(isset($_POST['signup']) && isset($_POST['acctype']))
{
	require 'connect.php';
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$username = $_POST['username'];
	$password = $_POST['password'];
	$cpassword = $_POST['cpassword'];
	$dob = $_POST['birthday'];
	$acctype = $_POST['acctype'];
	$email = $_POST['email'];

	if(empty($firstname) || !preg_match("/^[a-zA-Z]*$/",$firstname))
	{
        header('Location: register.php?error=emptyfv');
        exit();
	}
	else if(empty($lastname) || !preg_match("/^[a-zA-Z]*$/",$lastname))
	{
        header('Location: register.php?error=emptyfv');
        exit();
	}
	else if(empty($username))
	{
        header('Location: register.php?error=emptyf');
        exit();
	}
	else if(empty($password))
	{
        header('Location: register.php?error=emptyf');
        exit();
	}
	else if(empty($cpassword))
	{
        header('Location: register.php?error=emptyf');
        exit();
	}
	else if($password !== $cpassword)
	{
		header('Location: register.php?error=pwrong');
        exit();
	}
	else if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL))
	{
		header('Location: register.php?error=invmail');
        exit();
	}
	else if(empty($dob))
	{
		header('Location: register.php?error=emptyf');
        exit();
	}
	else
	{
        $sql = "SELECT username FROM user WHERE username = ?";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt,$sql))
        {
            header('Location: register.php?error=sqlerror');
            exit();
        }
        else
        {
            mysqli_stmt_bind_param($stmt , "s" ,$username);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $num = mysqli_stmt_num_rows($stmt);
            if($num > 0)
            {
            	header('Location: register.php?error=ucopy');
                exit();
            }
            else
            {
            	$hash = password_hash($password, PASSWORD_DEFAULT);
            	$sql = "INSERT INTO user (firstname,lastname,username,password,acctype,dob,email) VALUES (?,?,?,?,?,?,?)";
		        $stmt = mysqli_stmt_init($conn);
		        if(!mysqli_stmt_prepare($stmt,$sql))
		        {
		            header('Location: register.php?error=sqlerror');
		            exit();
		        }
		        else
		        {
		            mysqli_stmt_bind_param($stmt , "sssssss" ,$firstname,$lastname,$username,$hash,$acctype,$dob,$email);
		            mysqli_stmt_execute($stmt);
		            header('Location: register.php?signup=success');
		            exit();
		        }
            }
        }
	}
	mysqli_stmt_close($stmt);
	mysqli_close($conn);
	

}
else
{
    header('Location: register.php');
    exit();
}

?>