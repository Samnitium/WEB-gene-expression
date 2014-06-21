<?php

	include('../logic/logicUser.php');
	
	session_start();
	if(isset($_POST['username']) && isset($_POST['password'])) {
		if (ltrim($_POST['username'])=="" || ltrim($_POST['password'])=="") {
			$_SESSION['empty'] = 'fill all the fields';
			header("Location: welcomeController.php");	
		} else {
			$lu = new logicUser();
			$user = $lu->retrieveUserByEmail($_POST['username']);
			if (isset($user) && $user->password==$_POST['password']) {
			 $_SESSION['iduser'] = $user->id;
			 $_SESSION['type'] = $user->type;
			 $lu->db->close();
			 if($user->type=="superuser") {
			 	$lu->db->close();
			 	header("Location: superUserChoiceController.php");
			 }
			 else {
			 	$lu->db->close();
			 	header("Location: userChoiceController.php");
			 }
		} else if (isset($user)) {
			$_SESSION['password_error'] = "there is a mistake entering the password";
			$lu->db->close();
			header("Location: welcomeController.php");	 
		} else {
			$_SESSION['not_registered'] = "you have to register yet";
			$lu->db->close();
			header("Location: welcomeController.php");	 	
		}
			
		
		}
	} else {
		header("Location: welcomeController.php");	
	}



?>