<?php


	include_once ('../template/cls_fast_template.php');

	session_start();
	if (isset($_GET['id']) && ltrim($_GET['id'])!="") {
		$tlp = new FastTemplate("../view");
		$tlp->define( array('insertCode'=>"insertCode.html"));
		if (isset($_SESSION['error'])) {
				$tlp->assign('MESSAGE_ERROR',$_SESSION ['error']);
		} else  $tlp->assign('MESSAGE_ERROR',"");
	
		$tlp->assign('ACTION',"activeAccountController.php?id=".$_GET['id']);
	
		if (isset($_SESSION['code']) ) {
			$tlp->assign('CODE',$_SESSION['code']);
		} else $tlp->assign('CODE',""); 
	
		session_destroy();
		$tlp->parse('STATE','insertCode');
	
		Header("Content-type: text/html");
		$tlp->FastPrint();
	} else {
		header("Location: pageUnauthorized.php");
	}
	

?>