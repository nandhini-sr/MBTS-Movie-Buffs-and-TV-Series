<?php
session_start();

if(isset($_POST['LogIn']))
{
	include_once 'pdoAllusers.php';
	$username = $_POST['username'];
	$password = $_POST['password'];

	//ERROR HANDLERS

    //Check for empty field again
	if(empty($username) || empty($password))
	{
			$_SESSION["emptyChecklog"] = "Please fill in all fields below";
			header("Location: index.php?logIn_error"); 
			return;
	}
	else
	{
		$sql = "SELECT * from users where user_name = :username";
		$result = $pdo->prepare($sql);
		$result->execute(array(
					':username' => $username,
		));
		       
		if($result->rowCount()<1)
		{
			//if there no user with that user id
			$_SESSION["userChecklog"] = "Username not signed up!";
			header("Location: index.php?logIn_error");
			return;
		}
		else
		{
			if($row = $result->fetch(PDO::FETCH_ASSOC))
			{
				$hashedPwdCheck = password_verify($password,$row['password']);
				if($hashedPwdCheck == false)
				{
					$_SESSION["passwordChecklog"] = "Username and Password doesn't match";
					header("Location: index.php?logIn_error");
					return;
				}
				elseif($hashedPwdCheck == true)
				{ 
					
					$_SESSION['user_name'] = $row['user_name'];
					$_SESSION['password'] = $row['password'];
					$_SESSION['email_id'] = $row['email_id'];
					
					header("Location: homepage.php");

				}
			}
		}
	}





}
else
{
	header("Location: index.php?Click_LogIn_only");
	return;
}


?>