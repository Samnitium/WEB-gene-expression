<?php

	
	include('../template/cls_fast_template.php');
	include('../logic/logicUser.php');
	
	session_start();
	if(isset($_SESSION['iduser'])) {
		$_SESSION['page_corrent'] = "profileUserController.php";
		$tlp = new FastTemplate("../view");
		$tlp->define(array('profileUser' => "profileUser.html"));
		if ($_SESSION['type']=='superuser') {
			$tlp->assign('HOME',"superUserChoiceController.php");
		} else $tlp->assign('HOME',"userChoiceController.php");
		$lu = new LogicUser();
		$user = $lu->retrieveUserById($_SESSION['iduser']);
		if (isset($user) && $user!=NULL) {
			
			$tlp->assign('NAME_USER',$user->name);
			$tlp->assign('SURNAME_USER',$user->surname);
			$tlp->assign('EMAIL',$user->email);
			$tlp->assign('ROLE',$user->type);
		} else {
			$tlp->assign('NAME',"?");
			$tlp->assign('SURNAME',"?");
			$tlp->assign('EMAIL',"?");
			$tlp->assign('ROLE',"?");
		}
		if (isset($_SESSION['welcome'])) {
			$tlp->assign('WELCOME',$_SESSION['welcome']);
			$_SESSION['welcome'] = "";
		} else $tlp->assign('WELCOME',"");
		$lu->db->close();
		$tlp->assign('HREF',"modifyProfileUserController.php");
		$tlp->parse('STATE',"profileUser");
		Header("Content-type: text/html");
		$tlp->FastPrint();
	}
	
	else {
		header("Location: pageUnauthorized.php");
	}
	
	
		
		
	
	

?>