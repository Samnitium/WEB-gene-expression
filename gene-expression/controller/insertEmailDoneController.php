<?php

include('../logic/logicUser.php');
	
	session_start();
	if (isset($_POST['email'])) {
		if (trim($_POST['email'])!="") {
			$email = trim($_POST['email']);
			$lu = new LogicUser();
			$user = $lu->retrieveUserByEmail($email);
			if (isset($user) && $user!=NULL) {
				$from = "davidebernardini91@gmail.com";
    			$subject = "Mendel: password forgotten";
    			$message = "Dear ".$email.", your current password is:  ".$user->password;
   				 // send mail
   				$fatto = mail($email,$subject,$message,"From:".$from."\n");
				if ($fatto==FALSE) {
   					$_SESSION['error'] = "<div class='alert alert-danger'>The email is not correct or doesn't exist</div>";
					header('Location: insertEmailController.php');	
				} else {
					$_SESSION['welcome'] = "<div class='alert alert-success'>In a few minutes you will receive an email with your password</div>";
					header('Location: welcomeController.php');						
				}
				
			} else {
				$_SESSION['error'] = "<div class='alert alert-danger'>The email is not correct or doesn't exist</div>";
				header('Location: insertEmailController.php');	
			}
			
		} else {
			$_SESSION['error'] = "<div class='alert alert-danger'>You must fill the email's field</div>";
			header('Location: insertEmailController.php');	
		}	
	} else {
			header('Location: insertEmailController.php');	
	}
		
	
	
	
?>