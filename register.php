<?php

$title = 'Register';
include("db.php");

//check if register button is clicked
if(isset($_POST['register'])){

	$error = [];
	
	//validate email
	$email = $_POST['email'];
	
	if(empty($_POST['email'])){
		$error['email'] = "Please input email";
		}elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		$error['email'] = "Invalid email format";
			}
		
			//validate password
	if(empty($_POST['password'])){
		$error['password'] ="Please enter password";		
		}
	if(empty($_POST['confirm'])){
		$error['confirm'] ="Please enter confirm password";
		}elseif($_POST['password'] != $_POST['confirm']){
			$error['confirm'] ="Password Mismatch";
			}

			//check if there's error
	if(empty($error)){
		
		
		//if no error, proceed to check if email exist
		$stmtt = $conn->prepare("SELECT email FROM admin WHERE email=:em");
		$stmtt->bindParam(":em",$_POST['email']);
		$stmtt->execute();
		$row = $stmtt->fetch(PDO::FETCH_BOTH);
		
		if($stmtt->rowCount > 0 || $email = $row['email']){
			$error['email'] = "Email already exist";
			}else{
			 
				//if email does not exist proceed to input user data into database
		$hash = password_hash($_POST['password'],PASSWORD_BCRYPT);
		
		$stmt = $conn->prepare("INSERT INTO admin VALUES(NULL,:em,:pass,NOW(),NOW())");
  		$stmt->bindParam(":em",$_POST['email']);
  		$stmt->bindParam(":pass",$hash);
  		$stmt->execute();
		
		//after inputing data in database goto dashboard
		header("Location:dashboard.php");
		}
		
		}
	}
	
	
?> 

<html>
<head>
<title></title>
</head>

<body>

<main class="container"> 
<h1>User Registration</h1> 
<form method="post" > 
<fieldset class="form-group"> 
<label for="email" class="col-md-2">Email:</label> 
<p><?php 
if(isset($error['email'])){
	echo $error['email'];
	}
?></p>
<input name="email" id="email"  placeholder="" /> 
</fieldset> 
<fieldset class="form-group">
 <label for="password" class="col-md-2">Password:</label> 
<p><?php 
if(isset($error['password'])){
	echo $error['password'];
	}
?></p>
<input type="password" name="password" id="password" placeholder="******" />
 </fieldset> 
<fieldset class="form-group"> 
<label for="confirm" class="col-md-2">Confirm Password:</label>
<p><?php 
if(isset($error['confirm'])){
	echo $error['confirm'];
	}
?></p>
 <input type="password" name="confirm" id="confirm"  placeholder="*****"/> 
</fieldset> 
<div class="offset-md-2"> 
<input type="submit" value="Register" class="btn btn-info"  name="register"/>
 </div> 
</form>

<p>If you already have an account <a href="login.php">Login</a> | <a href="register.php">Register</a></p> 
</main> 

<?php

//require_once 'footer.php';

?>

</body>

</html>