<?php

	
	include('../template/cls_fast_template.php');
	include('../logic/logicAnalysis.php');
	
	session_start();
	if(isset($_SESSION['iduser'])) {
		if (isset($_POST['experiment']) && $_POST['experiment']!="") {
			$exp = $_POST['experiment'];
			$id_exp = explode(", ", $exp);
			$_SESSION['page_corrent'] = "showAnalysisList.php";
			$tlp = new FastTemplate("../view");
			$tlp->define(array('analysisList' => "showViewAnalysisList.html", 'analysis' => "rowAnalysis.html"));
			if ($_SESSION['type']=='superuser') {
				$tlp->assign('HOME',"superUserChoiceController.php");
			} else $tlp->assign('HOME',"userChoiceController.php");
			$la = new LogicAnalysis();
			$analysisList = $la->retrieveAnalysisByIdExperiment($id_exp[0]); 
			if (isset($analysisList) && count($analysisList)!=0) {
				foreach ($analysisList as $an) {	
					$tlp -> assign(array('GENE_SYMBOL'=>$an['geneSymbol'], 'P_VALUE'=>$an['p_value'], 'FOLD_CHANGE'=>$an['foldChange'], 'NAME'=>$an['name'], 'DATE'=>$an['date']));
					$tlp->parse('ROW',".analysis");
				}
			} else {
				$tlp -> assign(array('GENE_SYMBOL'=>"", 'P_VALUE'=>"", 'FOLD_CHANGE'=>"", 'NAME'=>"", 'DATE'=>""));
				$tlp->parse('ROW',".analysis");
			}
		
		 
			$la->db->close();
	
			$tlp->parse('STATE',"analysisList");
			Header("Content-type: text/html");
			$tlp->FastPrint();
		} else {
			header("Location: userChoiceController.php");
		}	
	}
	
	else {
		header("Location: pageUnauthorized.php");
	}
	
	
		
		
	
	

?>