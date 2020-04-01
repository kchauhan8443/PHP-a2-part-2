<?php
session_start();

include"db.php";

$email=$_SESSION["email"];
if(!isset($_SESSION["email"])){
	header("Location:login.php?error=Login required");
}

$id=$_GET['id'];

	$statement = $conn->prepare("SELECT * FROM admin WHERE id=:id");
	$statement->bindParam(":id",$id);
	$statement->execute();
	$row = $statement->fetch(PDO::FETCH_BOTH);
	
	if(isset($_POST['no'])){
		header("Location:dashboard.php");
		}
	if(isset($_POST['yes'])){
		
	$stmt = $conn->prepare("DELETE FROM admin WHERE id=:id");
	$stmt->bindParam(":id",$id);
	$stmt->execute();
		
	header("Location:dashboard.php?delete=Delete was successful");
		}
?>

<p>Do you want to delete user with email: <?php echo $row['email']?>
<form method="post">
<input type="submit" value="Yes" name="yes">

<input type="submit" value="No" name="no">
</form>