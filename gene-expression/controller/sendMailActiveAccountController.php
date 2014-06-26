<?php
	
	include("../logic/logicUser.php");
	
	if (isset($_GET['email']) && $_GET['email']!="") {
		$lu = new LogicUser();
		$user =  $lu->retrieveUserByEmail($_GET['email']);
		if (isset($user) && $user!=NULL) {
			if ($lu->retrieveAccountById($user->id)=="Y") {
				$lu->db->close();
				$_SESSION['error'] = "<div class='alert alert-danger'><a href='#' class='alert-link'>Your account has already been activated</a></div>";
				header("Location: welcomeController.php");
			} else {
				$code = md5(time());
				$lu->updateCodeUser($code,$user->id);
				$from = "davidebernardini91@gmail.com";
    			$subject = "registration mendel";
    			$message = "Welcome Mendel, Now to proceed with the activation of the account, click on the following 
    						<a href='activeAccountController.php?id=".$user->id."&code=".$code."'>link</a>";
   				 // send mail
   				$fatto = mail($_GET['email'],$subject,$message,"From:".$from."\n");
				session_start();
				//$_SESSION['welcome'] = "<div class='alert alert-success'>Welcome ".$user->name.", You can now proceed with the login</div>";
				$_SESSION['active'] = true;
				header("Location: messageLoginController.php");
			}
		} else {
			$lu->db->close();
			header("Location: welcomeController.php");			
		}
		
	} else {
		header("Location: welcomeController.php");	
	}

?>