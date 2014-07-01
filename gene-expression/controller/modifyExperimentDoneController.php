<?php

	include("../logic/logicExperiment.php");
	include("../logic/logicAnalysis.php");
	include("../logic/logicAnalysisInstance.php");
	include("../logic/logicGene.php");
    include_once ('../template/cls_fast_template.php');
	
	
	
	session_start();
	
	$tlp = new FastTemplate("../view");
	$tlp->define( array('successfull'=>"successfullUploadMessage.html"));
	if (isset($_SESSION['iduser']) &&  $_SESSION['type']=="superuser") {
		$le = new LogicExperiment();
		if (isset($_GET['idexperiment']) && $le->retrieveExperimentById($_GET['idexperiment'])!=NULL && isset($_POST['name_experiment'])) {
			$ne = trim($_POST['name_experiment']); 
			if ($ne!="") {
				$le->updateNameExperiment($_GET['idexperiment'], $ne);
				$_SESSION['experiment'] = NULL;	
				$le->db->close();
			} else {
				$le->db->close();
				$_SESSION['error_upload'] = "<div class='alert alert-danger'>The experiment name can not be blank</div>";
				header("Location: modifyExperimentController.php");
			}
			
			if(isset($_POST['action']) && $_POST['action'] == 'upload') {
    			if(isset($_FILES['user_file'])) {
        			$file = $_FILES['user_file'];
        			if($file['error'] == UPLOAD_ERR_OK and is_uploaded_file($file['tmp_name'])) {
            			move_uploaded_file($file['tmp_name'], '../file/'.$file['name']);
						$lg = new LogicGene();
						$la = new LogicAnalysis();
						$lai = new LogicAnalysisInstance();
						$tr = "";
						$tlp->assign('MESSAGE',"Your file has been uploaded and the name of experiment is update. ");
						$fp = fopen('../file/'.$file['name'],'r');
						$arrayIdAnalysis = array();
						if (!feof($fp)) {
							$str = fgets($fp);
							$ex = explode("\t", $str);
							$i = 9;
							while($i<=29) {
								$analysis = new Analysis();
								$ex[$i] = str_replace("Fold-Change(","", $ex[$i]);
								$ex[$i] = str_replace(") (Description)","", $ex[$i]);
								$analysis->name = $ex[$i];
								$analysis->date = date("Y-m-d", time());
								$analysis->id_experiment = $_GET['idexperiment'];
								$la->DTO->setValue('analysis',$analysis);
								$la->insertAnalysis();
								$idana = $la->db->insertedid();  
								array_push($arrayIdAnalysis,$idana);
								$i = $i + 4;	
							}
							$la->db->close();
						}
						while(!feof($fp)) {
							$str = fgets($fp);
							$ex = explode("\t", $str);
							$i=0;
							$indexPvalue = 6;
							$indexFoldChange = 8;
							for($i;$i<count($arrayIdAnalysis);++$i) {
								fillAnalysisInstance($arrayIdAnalysis[$i],$ex[$indexPvalue],$ex[$indexFoldChange],$ex[2],$lai);
								$indexPvalue = $indexPvalue + 4;
								$indexFoldChange = $indexFoldChange + 4;	
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
						$_SESSION['idexperiment'] = "";
						fclose($fp);
		
        			} else {
        				$tlp->assign('MESSAGE',"<div class='alert alert-danger'>The experiment's name is update, but no additional file is uploaded</div>");
        			}
    			} else {
    				$tlp->assign('MESSAGE',"<div class='alert alert-danger'>The experiment's name is update, but no additional file is uploaded</div>");    		
			  	}
			} else {
			  	 $tlp->assign('MESSAGE',"<div class='alert alert-danger'>The experiment's name is update, but no additional file is uploaded</div>");    		
				}
		} else {
			$le->db->close();
			header("Location: experimentsToModifyController.php");	
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
		$analysisInstance->p_value = doubleval($pvalue);
		$analysisInstance->foldChange = doubleval($foldChange);
		$lai->DTO->setValue('analysisInstance',$analysisInstance);
		$lai->insertAnalysisInstance();
	}	
	
		
	





?>