<?php
session_start();

include"db.php";

$email=$_SESSION["email"];
if(!isset($_SESSION["email"])){
	header("Location:login.php?error=Login required");
}

$id= $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM admin WHERE id=:id");
	$stmt->bindParam(":id",$id);
	$stmt->execute();
	$row = $stmt->fetch(PDO::FETCH_BOTH);
	
	if(isset($_POST['edit'])){
		$error=[];
		
		if(empty($_POST['email'])){
		$error['email'] = "Please input email";
		}elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		$error['email'] = "Invalid email format";
			}
	
	if(empty($error)){
		
		$stmtt = $conn->prepare("UPDATE admin SET email=:em WHERE id=:id ");
		$stmtt->bindParam(":id",$id);
		$stmtt->bindParam(":em",$_POST['email']);
		$stmtt->execute();
		
		
	$stmt = $conn->prepare("SELECT * FROM admin WHERE id=:id");
	$stmt->bindParam(":id",$id);
	$stmt->execute();
	$roww = $stmt->fetch(PDO::FETCH_BOTH);
		
		$success="You have successfully changed your email address to ".$roww['email'];
		
		}
	}
?>


<html>
<head>
	<title></title>
</head>
	<body>
	<form method="post">
		<p>Edit User Data</p>
		
		<p><?php if(isset($success)){
			echo $success;
			}?></p>
		<p>Email</p>
		<input name="email" value="<?php if(isset($roww['email'])){echo $roww['email'];
			}else{ echo $row['email'];}
			?>">
		<input type="submit" value="Edit" name="edit">
	</form>
	</body>
</html>