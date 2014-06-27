<?php

	include('../template/cls_fast_template.php');
	
	
	
	
	session_start();
	if (isset($_SESSION['active']) && $_SESSION['active']==true) {
		session_destroy();
		$tlp = new FastTemplate("../view");
		$tlp->define( array('messageLogin'=>"messageLogin.html"));
		$tlp->assign('MESSAGE',"<div class='alert alert-success'>I was sent an email to activate your account</div>");
		$tlp->parse('STATE','messageLogin');
		Header("Content-type: text/html");
		$tlp->FastPrint();	
	} else {
		header("Location: signInController.php");
	}
	
	




?>