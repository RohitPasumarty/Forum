<?php
$server="localhost";
$connecter="root";
$dpassword="";
$database="brainstorm";
$conn = mysqli_connect($server,$connecter,$dpassword,$database);

if(!$conn)
{
	echo 'Could Not Connect To DataBase ';
}
?>