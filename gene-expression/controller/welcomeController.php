<?php

	include_once ('../template/cls_fast_template.php');

	session_start();
	$tlp = new FastTemplate("../view");
	$tlp->define( array('login'=>"login.html"));
	if (isset($_SESSION['empty'])) {
		$tlp->assign('MESSAGE_ERROR',$_SESSION ['empty']);
		session_destroy();
	}
	else if(isset($_SESSION['password_error'])) {
		$tlp->assign('MESSAGE_ERROR',$_SESSION ['password_error']);
		session_destroy();
	}
	else if(isset($_SESSION['not_registered'])) {
		$tlp->assign('MESSAGE_ERROR',$_SESSION ['not_registered']);
		session_destroy();
	}
	else {
		$tlp->assign('MESSAGE_ERROR',"");	
	}
	$tlp->assign('ACTION',"loginController.php");
	$tlp->assign('USERNAME',"");
	$tlp->assign('PASSWORD',"");
	$tlp->parse('STATE','login');
	Header("Content-type: text/html");
	$tlp->FastPrint();	



?>