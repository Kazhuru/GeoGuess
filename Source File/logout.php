<?php
	session_start();
	include("funciones.php");
	conectarBD();

	session_destroy();
	header("location:http://localhost/CRUD/Mainpage.php");
?>

