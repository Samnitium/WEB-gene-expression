<?php


	include_once ('../template/cls_fast_template.php');

	session_start();
	$tlp = new FastTemplate("../view");
	$tlp->define( array('login'=>"signIn.html"));
	if (isset($_SESSION['empty'])) {
		$tlp->assign('MESSAGE_ERROR',$_SESSION ["<div class='alert alert-danger'><a href='#' class='alert-link'>empty</a></div>"]);
	} else if (isset($_SESSION['error_password'])) {
		$tlp->assign('MESSAGE_ERROR',$_SESSION ["<div class='alert alert-danger'><a href='#' class='alert-link'>error_password</a></div>"]);
	} else if (isset($_SESSION['exist_email'])) {
		$tlp->assign('MESSAGE_ERROR',$_SESSION ["<div class='alert alert-danger'><a href='#' class='alert-link'>exist_email</a></div>"]);
	} else {
		$tlp->assign('MESSAGE_ERROR',"");	
	}
	$tlp->assign('ACTION',"signInDoneController.php");
	
	if (isset($_SESSION['name']))
		$tlp->assign('NAME',$_SESSION['name']);
	else $tlp->assign('NAME',""); 
	
	if (isset($_SESSION['surname']))
		$tlp->assign('SURNAME',$_SESSION['surname']);
	else $tlp->assign('SURNAME',"");
	
	if (isset($_SESSION['email']))
		$tlp->assign('EMAIL',$_SESSION['email']);
	else $tlp->assign('EMAIL',"");
	
	if (isset($_SESSION['password']))
		$tlp->assign('PASSWORD',$_SESSION['password']);
	else $tlp->assign('PASSWORD',"");
	
	if (isset($_SESSION['rpassword']))
		$tlp->assign('RPASSWORD',$_SESSION['rpassword']);
	else $tlp->assign('RPASSWORD',"");
	
	session_destroy();
	
	$tlp->parse('STATE','login');
	Header("Content-type: text/html");
	$tlp->FastPrint();	






?>