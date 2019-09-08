<?php
    session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Spider Task 3</title>
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<link rel="stylesheet" type="text/css" href="css/style.index.css">
	<!--<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>-->
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>
	<h2 id="heading">MBTS - Movie Buffs and TV series</h2>
<div class="login-reg-panel">
		<div class="login-info-box">
			<h2>Have an account?</h2>
			<p>LOG IN now to stay tuned with new updates</p>
			<label id="label-register" for="log-reg-show">Login</label>
			<input type="radio" name="active-log-panel" id="log-reg-show"  checked="checked">
		</div>
							
		<div class="register-info-box">
			<h2>Don't have an account?</h2>
			<p>Don't delay! Keep track of all movie buffs and TV series</p>
			<label id="label-login" for="log-login-show">Register</label>
			<input type="radio" name="active-log-panel" id="log-login-show">
			<?php
			 if ( isset($_SESSION["confirmCheck"]) || isset($_SESSION["usertaken"]) || isset($_SESSION["emailCheck"]))
			 {
			 	echo("<p style='color:black;font-size:120%;'><b>Registration failed. <br>Try Again!</b></p>\n");
			 }
	         elseif ( isset($_SESSION["newUser"]) ) {
	          echo('<p style="color:black;font-size:120%;"><b>'.$_SESSION["newUser"]."</b></p>\n");
	          unset($_SESSION["newUser"]);
	         }
	            
			?>
		</div>
							
		<div class="white-panel">
			<div class="login-show">
				<h2>LOGIN</h2>
				<form action="login.inc.php" method="POST">
				<input type="text" placeholder="Username" name="username" required>
				<?php
				if ( isset($_SESSION["userChecklog"]) ) 
				{
	             echo('<p style="color:red;font-size:70%;float:right; margin-top:-17px; margin-right: 300px;"><b>'.$_SESSION["userChecklog"]."</b></p>\n");
	             unset($_SESSION["userChecklog"]);
	             }
             	?>
				<input type="password" placeholder="Password" name="password" required>
				<?php
				if ( isset($_SESSION["passwordChecklog"]) ) 
				{
	             echo('<p style="color:red;font-size:70%;float:right; margin-top:-17px; margin-right: 230px;"><b>'.$_SESSION["passwordChecklog"]."</b></p>\n");
	             unset($_SESSION["passwordChecklog"]);
             	}
				?>
				<input type="submit" value="LogIn" name="LogIn" id="LogIn">
			    </form>
			</div>
			<div class="register-show">
				<h2>REGISTER</h2>
				<form action="signup.inc.php" method="POST">
				<input type="text" placeholder="Username" name="username" id="username" required>
				<?php
	            if ( isset($_SESSION["usertaken"]) ) {
	             echo('<p style="color:red;font-size:70%;"><b>'.$_SESSION["usertaken"]."</b></p>\n");
	             unset($_SESSION["usertaken"]);
	             }
	            ?>
				<input type="email" placeholder="Email" name="email" id="email" required>
				<?php
	            if ( isset($_SESSION["emailCheck"]) ) {
	             echo('<p style="color:red;font-size:70%;"><b>'.$_SESSION["emailCheck"]."</b></p>\n");
	             unset($_SESSION["emailCheck"]);
	             }
            	?>
				<input type="password" placeholder="Password" name="password" id="password" required>
				<input type="password" placeholder="Confirm Password" name="confirm" id="confirm" required>
				<?php
	            if ( isset($_SESSION["confirmCheck"]) ) {
	             echo('<p style="color:red;font-size:70%;"><b>'.$_SESSION["confirmCheck"]."</b></p>\n");
	             unset($_SESSION["confirmCheck"]);
	             }
	            ?>
				<input type="submit" value="Register" name="SignUp" id="SignUp">
				</form>
			</div>
		</div>
	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="jquery/jquery.index.js"></script>
	

</body>
</html>