<?php

	//include_once ('../template/cls_fast_template.php');
	
	session_start();
	//$tlp = new FastTemplate("../view");
	if(isset($_SESSION['iduser'])) {
		if (isset($_POST['choose'])) {
			$answer = $_POST['choose'];
			if ($answer=="YES") {
				session_destroy();
				header("Location: welcomeController.php");
			} else {
				header("Location: ".$_SESSION['page_corrent']);
			}
		}
		else {
			header("Location: logoutController.php");	
		}
	}
	else {
		header("Location: pageUnauthorized.php");
	}
	

?>