<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>

	<?php
session_start();
if (!isset($_SESSION['user'])) {
 header("Location: index.php");
} else if(isset($_SESSION['user'])!="") {
 header("Location: home.php");
}

if (isset($_GET['logout'])) {
 unset($_SESSION['user']);
 session_unset();
 session_destroy();
 header("Location: index.php");
 exit;
}
?>

</body>
</html>