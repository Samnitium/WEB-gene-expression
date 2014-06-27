<?php

	include('../logic/logicUser.php');
	
	session_start();
	if(isset($_SESSION['iduser'])) {
		if(isset($_POST['password']) && isset($_POST['name']) && isset($_POST['surname'])) {
			$password = $_POST['password'];
			$name = trim($_POST['name']);
			$surname = trim($_POST['surname']);
			if (trim($password)=="" || trim($name)=="" || trim($surname)=="") {
				fillDatesSession($name,$surname,$password);
				$_SESSION['error'] = "<div class='alert alert-danger'>Please, fill all the fields</div>";
				header("Location: modifyProfileUserController.php");
			
			} else {
				$lu  = new LogicUser();
				
				$user = $lu->retrieveUserById($_SESSION['iduser']);
				$user->name = $name;
				$user->surname = $surname;
				$user->password = $password;
				$lu->DTO->setValue('user',$user);
				$lu->updateUser();
				$lu->db->close();
				$_SESSION['welcome'] = "<div class='alert alert-success'>Your dates has been update</div>";
				header("Location: profileUserController.php");
			}
		} else {
			header("Location: profileUserController.php");
		}		
	}
		
	else {
		header("Location: pageUnauthorized.php");
	}
	
	function fillDatesSession($name,$surname,$password) {
			$_SESSION['name'] = $name;
			$_SESSION['surname'] = $surname;
			$_SESSION['password'] = $password;
	}




?>