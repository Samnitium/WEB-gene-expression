<?php

include("../logic/logicUser.php");

	session_start();
	if (isset($_GET['id']) && isset($_POST['code']) && trim($_GET['id'])!="" && trim($_POST['code'])!="") {
		$lu = new LogicUser();
		$user = $lu-> retrieveUserByIdAndCode($_GET['id'], trim($_POST['code']));
		if (isset($user) && $user!=NULL) {
			
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
			$_SESSION['code'] = $_POST['code'];
			$_SESSION['error'] = "<div class='alert alert-danger'><a href='#' class='alert-link'>there was an error in the code or the user ID is not the one you want</a></div>";
			header("Location: insertCodeController.php?id=".$_GET['id']);	
		}
		
	} else if(isset($_POST['code']) &&  trim($_POST['code'])=="") {
		$_SESSION['error'] = "<div class='alert alert-danger'><a href='#' class='alert-link'>You need to enter the code in the following field</a></div>";
		header("Location: insertCodeController.php?id=".$_GET['id']);
	}
	
	
	else {
		header("Location: pageUnauthorized.php");	
	}

?>