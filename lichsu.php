<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title> FASHION</title>
	<link type="text/css" rel="stylesheet" href="CSS/CSS1.css"/>
	<link type="text/css" rel="stylesheet" href="CSS/admin.css"/>
	<script src="JS/jquery.min.js"></script>
</head>

<body class="wrapper">
<?php
	session_start();
	if(isset($_SESSION['admin'])) header('Location: index.php');
	require("database.php");
	include("header.php");
	include("lichsumuahang.php");
	include("footer.php");
?>
</body>
</html>