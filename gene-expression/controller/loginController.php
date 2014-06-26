<?php

	include('../logic/logicUser.php');
	
	session_start();
	if(isset($_POST['username']) && isset($_POST['password'])) {
		if (ltrim($_POST['username'])=="" || ltrim($_POST['password'])=="") {
			$_SESSION['error'] = "<div class='alert alert-danger'><a href='#' class='alert-link'>Please, fill all the fields</a></div>";
			fillSession();
			header("Location: welcomeController.php");	
		} else {
			$lu = new logicUser();
			$user = $lu->retrieveUserByEmail($_POST['username']);
			if (isset($user) && $user->password==$_POST['password']) {
				if ($lu->retrieveAccountById($user->id)=="N") {
					$lu->db->close();
					$_SESSION['error'] = "<div class='alert alert-danger'><a href='#' class='alert-link'>Your account has not been activated yet. Please, go to this <a href='sendMailActiveAccountController.php?email=".$_POST['username']."'>link</a></a></div>";
					fillSession();
					header("Location: welcomeController.php");	
				} else {
					$_SESSION['iduser'] = $user->id;
					$_SESSION['type'] = $user->type;
			 		$lu->db->close();
			 		if($user->type=="superuser") {
			 			header("Location: superUserChoiceController.php");
			 		}
			 		else {
			 			header("Location: userChoiceController.php");
			 		}
				}
			}else if (isset($user)) {
				$lu->db->close();
				$_SESSION['error'] = "<div class='alert alert-danger'><a href='#' class='alert-link'>The username or password is not correct</a></div>";
				fillSession();
				header("Location: welcomeController.php");	
			} else {
				$lu->db->close();
				$_SESSION['error'] = "<div class='alert alert-danger'><a href='#' class='alert-link'>You are not registered yet</a></div>";	
				fillSession();
				header("Location: welcomeController.php");				
			}
			$lu->db->close();
		}
		
	} else {
		header("Location: welcomeController.php");	
	}
	
	
	function fillSession() {
		$_SESSION['username'] = $_POST['username'];
		$_SESSION['password'] = $_POST['password'];
	}



?>