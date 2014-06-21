<?php

	include_once ('../template/cls_fast_template.php');
	
	session_start();
	$tlp = new FastTemplate("../view");
	if(isset($_SESSION['iduser'])) {
		$tlp->define( array('logout'=>"logout.html"));
		$tlp->assign("ACTION","logoutDoneController.php");
		$tlp->parse('STATE','logout');
	
		Header("Content-type: text/html");
		$tlp->FastPrint();
	}
	else {
		header("Location: pageUnauthorized.php");
	}	

	


?>