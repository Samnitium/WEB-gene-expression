<?php

	include('../logic/logicUser.php');
	
	session_start();
	if(isset($_POST['email']) && isset($_POST['password']) && isset($_POST['name']) && isset($_POST['surname']) && isset($_POST['rpassword'])) {
		$email = $_POST['email'];
		$password = $_POST['password'];
		$name = $_POST['name'];
		$surname = $_POST['surname'];
		$rpassword = $_POST['rpassword'];
		if (trim($email)=="" || trim($password)=="" || trim($name)=="" || trim($surname)=="" || trim($rpassword)=="") {
			fillDatesSession($name,$surname,$email,$password,$rpassword);
			$_SESSION['empty'] = "<div class='alert alert-danger'>fill all the fields</div>";
			header("Location: signInController.php");
		} else if ($password!=$rpassword) {
			fillDatesSession($name,$surname,$email,$password,$rpassword);
			$_SESSION['error_password'] = "<div class='alert alert-danger'>the two passwords do not match</div>";
			header("Location: signInController.php");
		}
		
		else {
			$lu  = new LogicUser();
			if (($lu->retrieveUserByEmail($_POST['email']))!=NULL) {
				$lu->db->close();
				fillDatesSession($name,$surname,$email,$password,$rpassword);
				$_SESSION['exist_email'] = "<div class='alert alert-danger'>Sorry, this email already exists</div>";
				header("Location: signInController.php");
			} else {
				$user = new User();
				$user->name = $name;
				$user->surname = $surname;
				$user->email = $email;
				$user->password = $password;
				$user->type = "user";
				$lu->DTO->setValue('user',$user);
				$lu->insertUser();
				$lu->db->close();
				$_SESSION['welcome'] = "<div class='alert alert-success'>Welcome ".$user->name.", You can now proceed with the login</div>";
				header("Location: welcomeController.php");
			}
		}
	}
	else  {
		header("Location: signInController.php");
	}


	function fillDatesSession($name,$surname,$email,$password,$rpassword) {
			$_SESSION['email'] = $email;
			$_SESSION['name'] = $name;
			$_SESSION['surname'] = $surname;
			$_SESSION['password'] = $password;
			$_SESSION['rpassword'] = $rpassword;
	}
	


?>