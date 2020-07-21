<?php
if(isset($_POST['login']))
{
	require 'connect.php';
	if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['acctype']))
	{
		$username = $_POST['username'];
	    $password = $_POST['password'];
	    $acctype = $_POST['acctype'];

	    if(!empty($username) && !empty($password) && !empty($acctype))
	    {
            $sql = "SELECT * FROM user WHERE username = ? AND acctype = ?";
	        $stmt = mysqli_stmt_init($conn);
	        if(!mysqli_stmt_prepare($stmt,$sql))
	        {
	            header('location: index.php?error=sqlerror');
	            exit();
	        }
	        else
	        {
	            mysqli_stmt_bind_param($stmt , "ss" ,$username,$acctype);
	            mysqli_stmt_execute($stmt);
	            $result = mysqli_stmt_get_result($stmt);
	            if($row = mysqli_fetch_assoc($result))
	            {
                    $check = password_verify($password, $row['password']);
                    if($check)
                    {
                        session_start();
                        $_SESSION['id'] = $row['id'];
                        $_SESSION['firstname'] = $row['firstname'];
                        $_SESSION['username'] = $row['username'];
                        $_SESSION['lastname'] = $row['lastname'];
                        $_SESSION['acctype'] = $row['acctype'];
                        header('Location: home.php');
                    }
                    else
                    {
                    	header('location: index.php?error=wrongpwd');
		                exit();
                    }
	            }
	            else
	            {
	            	header('location: index.php?error=wrong');
		            exit();
	            }
	            
	        }
			mysqli_stmt_close($stmt);
			mysqli_close($conn);
	
	    }
	    else
	    {
	    	header('location: index.php?error=empty');
		    exit();
	    }
	}
	else
	{
		header('location: index.php?error=filldetails');
		exit();
	}
}
else
{
	header('Location: index.php');
	exit();
}
?>