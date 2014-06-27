<?php

	include('../logic/logicUser.php');
	
	session_start();
	if(isset($_POST['email']) && isset($_POST['password']) && isset($_POST['name']) && isset($_POST['surname']) && isset($_POST['rpassword'])) {
		$email = trim($_POST['email']);
		$password = $_POST['password'];
		$name = trim($_POST['name']);
		$surname = trim($_POST['surname']);
		$rpassword = $_POST['rpassword'];
		if ($email=="" || trim($password)=="" || $name=="" || $surname=="" || trim($rpassword)=="") {
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
				$code = md5(time());
				$user = new User();
				$user->name = $name;
				$user->surname = $surname;
				$user->email = $email;
				$user->password = $password;
				$user->type = "user";
				$lu->DTO->setValue('user',$user);
				$lu->insertUser($code);
				$idlast = $lu->db->insertedid();
				$lu->db->close();
				$from = "davidebernardini91@gmail.com";
    			$subject = "registration mendel";
    			$message = "Welcome Mendel, Now to proceed with the activation of the account, use the following code that will be asked:  ".$code;
   				 // send mail
   				$fatto = mail($email,$subject,$message,"From:".$from."\n");
				if ($fatto==FALSE) {
   					$_SESSION['error_email'] = "<div class='alert alert-danger'>This email doesn't exist</div>";	
   					header("Location: signInController.php");
				} 
				
				//$_SESSION['welcome'] = "<div class='alert alert-success'>Welcome ".$user->name.", You can now proceed with the login</div>";
				

				header("Location: insertCodeController.php?id=".$idlast);
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