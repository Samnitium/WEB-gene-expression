<?php

	include_once ('../template/cls_fast_template.php');
	
	
	session_start();
	$tlp = new FastTemplate("../view");
	$tlp->define( array('pageUnauthorized'=>"pageUnauthorized.html"));
	if (isset($_SESSION['iduser'])) {
		$tlp->assign('MESSAGE_LOGIN',"");
	} else {
		$tlp->assign('MESSAGE_LOGIN',"Please proceed to the <a href='welcomeController.php'>login</a>");
		session_destroy();
	}
	$tlp->parse('STATE','pageUnauthorized');
	Header("Content-type: text/html");
	$tlp->FastPrint();	
	

?>