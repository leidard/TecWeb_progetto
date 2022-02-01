<?php
session_start();
if(isset($_SESSION["sessionid"]))
{
	session_destroy();
	header("Location: index.php");
	die();
}
else
{
	header("Location: accedi.php");
	die();
}