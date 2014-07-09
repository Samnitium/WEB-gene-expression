<?php

	include_once ('../template/cls_fast_template.php');
	include('../logic/logicAnalysis.php');
	include('../logic/logicGene.php');
	include('../logic/logicAnalysisInstance.php');
	
	session_start();
	
	$tlp = new FastTemplate("../view");
	$tlp->define( array('successfull'=>"successfullUploadMessage.html"));
	if (isset($_SESSION['iduser']) &&  $_SESSION['type']=="superuser") {
		if(isset($_POST['action']) && $_POST['action'] == 'upload' && isset($_SESSION['idexperiment']) && $_SESSION['idexperiment']!="") {
    		if(isset($_FILES['user_file']) && isset($_SESSION['idexperiment']) && $_SESSION['idexperiment']!="") {
        		$file = $_FILES['user_file'];
        		if($file['error'] == UPLOAD_ERR_OK and is_uploaded_file($file['tmp_name'])) {
            		move_uploaded_file($file['tmp_name'], '../file/file_'.$_SESSION['idexperiment']);
					$lg = new LogicGene();
					$la = new LogicAnalysis();
					$lai = new LogicAnalysisInstance();
					$tr = "";
					$fp = fopen('../file/file_'.$_SESSION['idexperiment'],'r');
					$arrayIdPvalue = array();
					$arrayIdFoldChange = array();
					$arrayIdAnalysis = array();
					if (!feof($fp)) {
						$str = fgets($fp);
						$ex = explode("\t", $str);
						//sto supponendo che la sequenza dei primi 5 campi è fissa
						$i = 6;
						while($i<count($ex)) {
							if (strpos($ex[$i], '(Description)') !== false) {
								$analysis = new Analysis();	
								$ex[$i] = str_replace("Fold-Change(","", $ex[$i]);
								$ex[$i] = str_replace(") (Description)","", $ex[$i]);							
								$analysis->name = $ex[$i];
								$analysis->date = date("Y-m-d", time());
								$analysis->id_experiment = $_SESSION['idexperiment'];
								$la->DTO->setValue('analysis',$analysis);
								$la->insertAnalysis();
								$idana = $la->db->insertedid(); 
								array_push($arrayIdAnalysis,$idana); 
							} else if (strpos($ex[$i], 'p-value') !== false) {
								array_push($arrayIdPvalue,$i);
							} else if (strpos($ex[$i], 'Fold-Change') !== false) {
								array_push($arrayIdFoldChange,$i);	
							}
							$i++;	
						}
						$la->db->close();
					}
					while(!feof($fp)) {
						$str = fgets($fp);
						$ex = explode("\t", $str);
						$i=0;
						/*$indexPvalue = 6;
						$indexFoldChange = 8;*/
						//sto supponendo che i 3 array siano allineati
						for($i;$i<count($arrayIdAnalysis);++$i) {
							fillAnalysisInstance($arrayIdAnalysis[$i],$ex[$arrayIdPvalue[$i]],$ex[$arrayIdFoldChange[$i]],$ex[2],$lai);
						}
						if (($lg->retrieveGeneByGeneSymbol($ex[2]))==NULL) {
							$gene = new Gene();
							$gene->geneAssignment  = str_replace("'","",$ex[1]);
							$gene->geneSymbol = $ex[2];
							$gene->refSeq = $ex[3];
							$lg->DTO->setValue('gene',$gene);
							$lg->insertGene();		
						}
						
					}
					$lai->db->close();
					$lg->db->close();
					$tlp->assign('MESSAGE',"Your file has been uploaded. ");
					$_SESSION['idexperiment'] = NULL;
					fclose($fp);
		
        		} else {
        			$tlp->assign('MESSAGE',"<div class='alert alert-danger'>Sorry, there was an error loading the file</div>");
        		}
    		} else {
    			$_SESSION['error_upload'] = "<div class='alert alert-danger'>You need to upload the file</div>";
				header("Location: addAnalysisController.php");
    		}
		} else {
			$_SESSION['error_upload'] = "<div class='alert alert-danger'>You need to upload the file</div>";
			header("Location: addAnalysisController.php");
		}
		
		$tlp->assign('HOME',"superUserChoiceController.php");
		$tlp->parse('STATE','successfull');
		Header("Content-type: text/html");
		$tlp->FastPrint();		
		
			
	}
	else {
		header("Location: pageUnauthorized.php");
	}
	
	
	function fillAnalysisInstance($idana,$pvalue,$foldChange,$geneSymbol,$lai) {
		$analysisInstance = new AnalysisInstance();
		$analysisInstance->id_analysis = $idana;
		$analysisInstance->geneSymbol = $geneSymbol;
		$analysisInstance->p_value_string = $pvalue;
		$analysisInstance->p_value = doubleval($pvalue);
		$analysisInstance->foldChange = doubleval($foldChange);
		$lai->DTO->setValue('analysisInstance',$analysisInstance);
		$lai->insertAnalysisInstance();
	}	





?>