<?php

include('../logic/logicUser.php');
	
	session_start();
	if (isset($_POST['email'])) {
		if ($_POST['email']!="") {
			$email = $_POST['email'];
			$lu = new LogicUser();
			$user = $lu->retrieveUserByEmail($email);
			if (isset($user) && $user!=NULL) {
				$from = "davidebernardini91@gmail.com";
    			$subject = "Mendel: password forgotten";
    			$message = "Dear ".$email.", your current password is:  ".$user->password;
   				 // send mail
   				$fatto = mail($email,$subject,$message,"From:".$from."\n");
				if ($fatto==FALSE) {
   					$_SESSION['error'] = "Your email entered doesn't correct or doesn't exist";
					header('Location: insertEmailController.php');	
				} else {
					$_SESSION['welcome'] = "I was sent an email to receive your password";
					header('Location: welcomeController.php');						
				}
				
			} else {
				$_SESSION['error'] = "Your email entered doesn't correct or doesn't exist";
				header('Location: insertEmailController.php');	
			}
			
		} else {
			$_SESSION['error'] = "You must fill the email's field";
			header('Location: insertEmailController.php');	
		}	
	} else {
			header('Location: insertEmailController.php');	
	}
		
	
	
	
?>