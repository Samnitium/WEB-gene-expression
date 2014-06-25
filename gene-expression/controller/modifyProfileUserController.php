<?php

include('../template/cls_fast_template.php');
include('../logic/logicUser.php');
	
	session_start();
	if(isset($_SESSION['iduser'])) {
		$_SESSION['page_corrent'] = "modifyProfileUserController.php";
		$tlp = new FastTemplate("../view");
		$tlp->define(array('modifyProfileUser' => "profileUserModify.html"));
		if ($_SESSION['type']=='superuser') {
			$tlp->assign('HOME',"superUserChoiceController.php");
		} else $tlp->assign('HOME',"userChoiceController.php");
		$lu = new LogicUser();
		$user = $lu->retrieveUserById($_SESSION['iduser']);
		if (isset($user) && $user!=NULL) {
			if (isset($_SESSION['name']) && $_SESSION['name']!="") {
				$tlp->assign('NAME',$_SESSION['name']);
				$_SESSION['name'] = "";
			}
			else $tlp->assign('NAME',$user->name);
			
			if (isset($_SESSION['surname']) && $_SESSION['surname']!="") {
				$tlp->assign('SURNAME',$_SESSION['surname']);
				$_SESSION['surname'] = "";
			}
			else $tlp->assign('SURNAME',$user->surname);
			
			if (isset($_SESSION['password']) && $_SESSION['password']!="") {
				$tlp->assign('PASSWORD',$_SESSION['password']);
				$_SESSION['password'] = "";
			}
			else $tlp->assign('PASSWORD',$user->password);
	
		} else {
			$tlp->assign('NAME',"");
			$tlp->assign('SURNAME',"");
			$tlp->assign('PASSWORD',"");
		}
		$lu->db->close();
		if (isset($_SESSION['error'])) {
			$tlp->assign('MESSAGE_ERROR',$_SESSION['error']);
			$_SESSION['error'] = "";
		} else {
			$tlp->assign('MESSAGE_ERROR',"");
		}
		$tlp->assign('ACTION',"modifyProfileUserDoneController.php");
		$tlp->parse('STATE',"modifyProfileUser");
		Header("Content-type: text/html");
		$tlp->FastPrint();
	}
	
	else {
		header("Location: pageUnauthorized.php");
	}
	
?>