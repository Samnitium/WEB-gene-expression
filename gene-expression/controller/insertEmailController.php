<?php


	include_once ('../template/cls_fast_template.php');

	session_start();
	$tlp = new FastTemplate("../view");
	$tlp->define( array('insertEmail'=>"insertEmail.html"));
	if (isset($_SESSION['error'])) {
			$tlp->assign('MESSAGE_ERROR',$_SESSION ['error']);
	} else  $tlp->assign('MESSAGE_ERROR',"");
	
	$tlp->assign('ACTION',"insertEmailDoneController.php");
	
	if (isset($_SESSION['email']) ) {
		$tlp->assign('EMAIL',$_SESSION['email']);
	}
	else $tlp->assign('EMAIL',""); 
	
	session_destroy();
	$tlp->parse('STATE','insertEmail');
	
	Header("Content-type: text/html");
	$tlp->FastPrint();
	
	

?>