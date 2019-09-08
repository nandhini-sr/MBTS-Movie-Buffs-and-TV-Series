<?php
if(isset($_POST['LogOut']))
{
    session_start();   
   	session_unset();
	//session_destroy();
	header("Location: index.php");
	return;
}

?>