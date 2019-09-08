<?php

session_start();

if(isset($_POST['SignUp']))
{
	include_once 'pdoAllusers.php';
	$username = $_POST['username'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$confirm = $_POST['confirm'];
     
    //ERROR HANDLERS

    //Check for empty field again
	if(empty($email) || empty($username) || empty($password) || empty($confirm))
	{
			$_SESSION["emptyCheck"] = "Please fill in all fields below";
			header("Location: index.php?signup_error"); 
			return;
	}
	else
	{
			//check email
			if(!filter_var($email, FILTER_VALIDATE_EMAIL))
			{
				$_SESSION["emailCheck"] = "Please enter valid email-id";
                header("Location: index.php?signup_error");
                return;
			}

			else
			{
				if($password!=$confirm)
				{
					$_SESSION["confirmCheck"] = "Confirm password doesn't match";
					header("Location: index.php?signup_error");
					return;
				}

				else
				{
                //check for same username
               		$sql = "SELECT * from users where user_name = :user_name";
			   		$result = $pdo->prepare($sql);
			   		$result->execute(array(
						':user_name' => $username
					));
			   		if($result->rowCount()>0)
					{
						//unique username always
						$_SESSION["usertaken"] = "Your username is taken! Enter an unique username ";
						header("Location: index.php?signup_error");
						return;
					}
					else
					{
						//HASHING PASSWORD
						$hashedPwd = password_hash($password, PASSWORD_DEFAULT);
						//insert the user into the database
						$sql = " INSERT INTO users (user_name,password,email_id) VALUES (:user_name,:pass_word,:email_id);";
					
						$stmt = $pdo->prepare($sql);
						$stmt->execute(array(
							':user_name'=>$username,
							':pass_word'=>$hashedPwd,
							':email_id'=>$email
						));

                        $_SESSION['newUser'] = "Sign Up successful!<br>Log In now!";                
						header("Location: index.php");
						return;
					}
				}
			}
	}
}
else
{
	header("Location: index.php?Click_signup_only");
	return;
}

?>