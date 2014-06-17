<?php

	include('../logic/logicUser.php');
	
	session_start();
	if(isset($_POST['email']) && isset($_POST['password']) && isset($_POST['name']) && isset($_POST['surname']) && isset($_POST['rpassword'])) {
		$email = $_POST['email'];
		$password = $_POST['password'];
		$name = $_POST['name'];
		$surname = $_POST['surname'];
		$rpassword = $_POST['rpassword'];
		if ($email=="" || $password=="" || $name=="" || $surname=="" || $rpassword=="") {
			fillDatesSession($name,$surname,$email,$password,$rpassword);
			$_SESSION['empty'] = "fill all the fields";
			header("Location: signInController.php");
		} else if ($password!=$rpassword) {
			fillDatesSession($name,$surname,$email,$password,$rpassword);
			$_SESSION['error_password'] = "the two passwords do not match";
			header("Location: signInController.php");
		}
		
		else {
			$lu  = new LogicUser();
			$user = new User();
			$user->name = $name;
			$user->surname = $surname;
			$user->email = $email;
			$user->password = $password;
			$user->type = "user";
			$lu->DTO->setValue('user',$user);
			$lu->insertUser();
			$lu->db->close();
			$_SESSION['welcome'] = "Welcome ".$user->name.", You can now proceed with the login";
			header("Location: welcomeController.php");
		}
	}

	function fillDatesSession($name,$surname,$email,$password,$rpassword) {
			$_SESSION['email'] = $email;
			$_SESSION['name'] = $name;
			$_SESSION['surname'] = $surname;
			$_SESSION['password'] = $password;
			$_SESSION['rpassword'] = $rpassword;
	}
	


?>