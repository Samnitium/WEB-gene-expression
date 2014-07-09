<?php

	include_once ('../template/cls_fast_template.php');

	session_start();
	$tlp = new FastTemplate("../view");
	$tlp->define( array('login'=>"login.html"));
	
	
	
	
	if (isset($_SESSION['error'])) {
		$tlp->assign('MESSAGE_ERROR',$_SESSION ['error']);
	} else $tlp->assign('MESSAGE_ERROR',""); 
	
	if(isset($_SESSION['welcome'])) {
		$tlp->assign('WELCOME',$_SESSION ['welcome']);
	}
	else {
		$tlp->assign('WELCOME',"");	
	}
	$tlp->assign('ACTION',"loginController.php");
	
	if (isset($_SESSION['username'])) {
		$tlp->assign('USERNAME',$_SESSION['username']);
	}
	else $tlp->assign('USERNAME',""); 
	
	if (isset($_SESSION['password'])) {
		$tlp->assign('PASSWORD',$_SESSION['password']);
	}
	else $tlp->assign('PASSWORD',""); 
	
	if(!(isset($_SESSION['iduser']))) {
		session_destroy();	
	} else {
		if ($_SESSION['type']=='superuser') {
			header('Location: superUserChoiceController.php');
		} else {
			header('Location: userChoiceController.php');			
		}
	}
	
	
	
	$tlp->parse('STATE','login');
	Header("Content-type: text/html");
	$tlp->FastPrint();	



?>