<?php

	
	include('../template/cls_fast_template.php');
	include('../logic/logicUser.php');
	
	session_start();
	if(isset($_SESSION['iduser']) && $_SESSION['type']=='superuser') {
		$_SESSION['page_corrent'] = "selectUserController.php";
		$tlp = new FastTemplate("../view");
		$tlp->define(array('userList' => "userList.html", 'user' => "userDate.html"));
		$tlp->assign('ACTION',"enablePermissionsController.php");
		$tlp->assign('HOME',"superUserChoiceController.php");
		$lu = new LogicUser();
		$users = $lu->retrieveAllUsers("user");
		if (isset($users) && count($users)!=0) {
			foreach ($users as $us) {	
				$tlp -> assign('EMAIL',$us['email']);
				$tlp->parse('USER',".user");
			}
		} else {
			$tlp -> assign('EMAIL',"");
			$tlp->parse('USER',".user");
		}
		 
		$lu->db->close();
	
		$tlp->parse('STATE',"userList");
		Header("Content-type: text/html");
		$tlp->FastPrint();	
	}
	
	else {
		header("Location: pageUnauthorized.php");
	}
	
	
		
		
	
	

?>