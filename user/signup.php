<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (isset($_POST['submit'])) {
	$errors = array();

	// Check if fields are empty
	if (empty($_POST['fname'])) {
		$errors[] = "Name is required";
	} else {
		$fname = $_POST['fname'];
	}

	if (empty($_POST['mobno'])) {
		$errors[] = "Mobile number is required";
	} else {
		$mobno = $_POST['mobno'];
	}

	if (empty($_POST['email'])) {
		$errors[] = "Email is required";
	} else {
		$email = $_POST['email'];
	}

	if (empty($_POST['password'])) {
		$errors[] = "Password is required";
	} else {
		$password = md5($_POST['password']);
	}

	// If there are no errors, proceed with database operations
	if (empty($errors)) {
		$ret = "SELECT email FROM tblpatients WHERE email=:email";
		$query = $dbh->prepare($ret);
		$query->bindParam(':email', $email, PDO::PARAM_STR);
		$query->execute();
		$results = $query->fetchAll(PDO::FETCH_OBJ);

		if ($query->rowCount() == 0) {
			$sql = "INSERT INTO tblpatients(name, phoneNO, email, password) VALUES(:fname, :mobno, :email, :password)";
			$query = $dbh->prepare($sql);
			$query->bindParam(':fname', $fname, PDO::PARAM_STR);
			$query->bindParam(':email', $email, PDO::PARAM_STR);
			$query->bindParam(':mobno', $mobno, PDO::PARAM_INT);
			$query->bindParam(':password', $password, PDO::PARAM_STR);
			$query->execute();
			$lastInsertId = $dbh->lastInsertId();

			if ($lastInsertId) {
				echo "<script>alert('You have signed up successfully');</script>";
			} else {
				echo "<script>alert('Something went wrong. Please try again');</script>";
			}
		} else {
			echo "<script>alert('Email ID already exists. Please try again');</script>";
		}
	} else {
		// If there are errors, display them
		foreach ($errors as $error) {
			echo "<script>alert('$error');</script>";
		}
	}
}
?>



?>
<!doctype html>
<!DOCTYPE html>
<html lang="en">

<head>

	<title>ABC Laboratories - Login Page</title>


	<link rel="stylesheet" href="libs/bower/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="libs/bower/material-design-iconic-font/dist/css/material-design-iconic-font.min.css">
	<link rel="stylesheet" href="libs/bower/animate.css/animate.min.css">
	<link rel="stylesheet" href="assets/css/bootstrap.css">
	<link rel="stylesheet" href="assets/css/core.css">
	<link rel="stylesheet" href="assets/css/misc-pages.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:400,500,600,700,800,900,300">
</head>

<body class="simple-page">
	<div id="back-to-home">
		<a href="../index.php" class="btn btn-outline btn-default"><i class="fa fa-home animated zoomIn"></i></a>
	</div>
	<div class="simple-page-wrap">
		<div class="simple-page-logo animated swing">

			<span style="color: white"><i class="fa fa-gg"></i></span>
			<span style="color: white">ABC Laboratories</span>

		</div><!-- logo -->
		<div class="simple-page-form animated flipInY" id="login-form">
			<h4 class="form-title m-b-xl text-center">Sign Up With Your ABC Laboratories Account</h4>
			<form action="" method="post">
				<div class="form-group">
					<input id="fname" type="text" class="form-control" placeholder="Full Name" name="fname" required="true">
				</div>

				<div class="form-group">
					<input id="email" type="email" class="form-control" placeholder="email" name="email" required="true">
				</div>
				<div class="form-group">
					<input id="mobno" type="text" class="form-control" placeholder="Mobile" name="mobno" maxlength="10" pattern="[0-9]+" required="true">
				</div>

				<div class="form-group">
					<input id="password" type="password" class="form-control" placeholder="password" name="password" required="true">
				</div>

				<input type="submit" class="btn btn-primary" value="Register" name="submit">
			</form>
		</div><!-- #login-form -->

		<div class="simple-page-footer">
			<p>
				<small>Do you have an account ?</small>
				<a href="login.php">SIGN IN</a>
			</p>
		</div>


	</div><!-- .simple-page-wrap -->
</body>

</html>