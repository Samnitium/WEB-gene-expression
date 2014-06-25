<?php

	
	include('../template/cls_fast_template.php');
	include('../logic/logicGene.php');
	
	session_start();
	if(isset($_SESSION['iduser'])) {
		if (isset($_GET['gene_symbol']) && $_GET['gene_symbol']!="") {
			$_SESSION['page_corrent'] = "showGene.php";
			$tlp = new FastTemplate("../view");
			$tlp->define(array('gene' => "showViewGene.html"));
		    $tlp->assign('NAME_GENE',$_GET['gene_symbol']);
			if ($_SESSION['type']=='superuser') {
				$tlp->assign('HOME',"superUserChoiceController.php");
			} else $tlp->assign('HOME',"userChoiceController.php");
			$lg = new LogicGene();
			$gene = $lg->retrieveGeneByGeneSymbol($_GET['gene_symbol']); 
			if (isset($gene) && $gene!=NULL) {
				$tlp->assign('GENE_SYMBOL',$gene->geneSymbol);
				$tlp->assign('GENE_ASSIGNMENT',$gene->geneAssignment);
				$tlp->assign('REF_SEQ',$gene->refSeq);
			} else {
				$tlp->assign('GENE_SYMBOL',"?");
				$tlp->assign('GENE_ASSIGNMENT',"?");
				$tlp->assign('REF_SEQ',"?");
			}
		
		 
			$lg->db->close();
	
			$tlp->parse('STATE',"gene");
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