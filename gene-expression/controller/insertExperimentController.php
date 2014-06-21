<?php


	include_once ('../template/cls_fast_template.php');

	session_start();
	$tlp = new FastTemplate("../view");
	if (isset($_SESSION['iduser']) && $_SESSION['type']=="superuser") {
		$_SESSION['page_corrent'] = 'insertExperimentController.php';
		$tlp->define( array('insertExperiment'=>"insertExperiment.html"));
		if (isset($_SESSION['empty'])) {
			$tlp->assign('MESSAGE_ERROR',$_SESSION ['empty']);
		} 
	
		$tlp->assign('ACTION',"addAnalysisController.php");
	
		if (isset($_SESSION['name']) )
			$tlp->assign('NAME',$_SESSION['name']);
		else $tlp->assign('NAME',""); 
	
		$_SESSION['name'] = "";
		$_SESSION['empty'] = "";	
		$tlp->parse('STATE','insertExperiment');
	
		Header("Content-type: text/html");
		$tlp->FastPrint();
	}
	else {
		header("Location: pageUnauthorized.php");
	}	

?>