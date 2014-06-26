<?php

include("../logic/logicUser.php");


	if (isset($_GET['id']) && isset($_GET['code']) && $_GET['id']!="" && $_GET['code']!="") {
		$lu = new LogicUser();
		$user = $lu-> retrieveUserByIdAndCode($_GET['id'], $_GET['code']);
		if (isset($user) && $user!=NULL) {
			session_start();
			if ($lu->retrieveAccountById($user->id)=="N") {
				$lu->updateAccount($user->id);
				$_SESSION['welcome'] = "<div class='alert alert-success'>Welcome ".$user->name.", You can now proceed with the login</div>";
				$lu->db->close();
				header("Location: welcomeController.php");
			} else {
				$lu->db->close();
				$_SESSION['error'] = "<div class='alert alert-danger'><a href='#' class='alert-link'>Your account has already been activated</a></div>";
				header("Location: welcomeController.php");
			}				
			
		} else {
			$lu->db->close();
			header("Location: pageUnauthorized.php");	
		}
		
	} else {
		header("Location: pageUnauthorized.php");	
	}

?>