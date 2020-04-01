<?php
session_start();

include"db.php";


//check if login button is clicked
if(isset($_POST['login'])){
	
	//create an error array which will collect all error
	$error=[];
	
	//validate email
	if(empty($_POST['email'])){
		
		$error['email']="Please enter email";
	}elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
  $error['email'] = "Invalid email format"; 
} 

//validate password
if(empty($_POST['pass'])){
	$error['pass']="Please enter password";
	
}else{
	$pass=$_POST['pass'];
}

	
		//check if there's no error
		if(empty($error)){
			
			//if no error proceed
		$statement = $conn->prepare("SELECT * FROM admin WHERE email=:em");
		$statement->bindParam(":em",$_POST['email']);
		$statement->execute();
		$row = $statement->fetch(PDO::FETCH_BOTH);
		
		//if user data not availabe goto login.php with error message
		if($statement->rowCount() < 1 || !password_verify($pass,$row['password']) ){
			header("Location:login.php?error=Either Email or Password is Incorrect");
			
		}else{
			
			//create sessions and goto dashboard
			$_SESSION["id"] = $row['id'];
			$_SESSION["email"] = $row["email"];
			header("Location:dashboard.php");
		}
		
	}
	
	
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login V3</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	

<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100" style="background-image: url('ugh1.jpg');">
			<div class="wrap-login100">
				<form class="login100-form validate-form" method="post">
					<span class="login100-form-logo">
						
					</span>

					<span class="login100-form-title p-b-34 p-t-27">
						Log in
					</span>
					<p><?php 
					if(isset($_GET['error'])){
						echo $_GET['error'];
						}
					?></p>

					<div class="wrap-input100 validate-input" data-validate = "Enter email">
						<input class="input100" type="text" name="email" placeholder="<?php 
						if(isset($error['email'])){
							echo $error['email'];
						}else{
							echo "Email";
						}
						?>">

					</div>

					<div class="wrap-input100 validate-input" data-validate="Enter password">
						<input class="input100" type="password" name="pass" placeholder="<?php
						if(isset($error['pass'])){
							echo $error['pass'];
						}else{
						echo "Password";}
						?>">
					</div>

					<div class="contact100-form-checkbox">
						<input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
						<label class="label-checkbox100" for="ckb1">
							Remember me
						</label>
					</div>

					<div class="container-login100-form-btn">
						<button class="login100-form-btn" name="login">
							Login
						</button>
					</div>

					<div class="text-center p-t-90">
							Don't have an account?  <a class="txt1" href="register.php"> Register
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	

	

</body>
</html>