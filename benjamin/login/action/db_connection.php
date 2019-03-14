<?php 
	$mysqli = @mysqli_connect('localhost','root','', 'login');
	if (!$mysqli) {
	   die("Connection failed: " . mysqli_connect_error());
	}
	else { 
		echo "Connected successful!";
	}
?>