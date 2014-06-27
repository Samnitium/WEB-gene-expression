<?php

	include_once ('../template/cls_fast_template.php');
	include('../logic/logicAnalysis.php');
	include('../logic/logicGene.php');
	
	session_start();
	
	$tlp = new FastTemplate("../view");
	$tlp->define( array('successfull'=>"successfullUploadMessage.html"));
	if (isset($_SESSION['iduser']) &&  $_SESSION['type']=="superuser") {
		if(isset($_POST['action']) && $_POST['action'] == 'upload' && isset($_SESSION['idexperiment']) && $_SESSION['idexperiment']!="") {
    		if(isset($_FILES['user_file']) && isset($_SESSION['idexperiment']) && $_SESSION['idexperiment']!="") {
        		$file = $_FILES['user_file'];
        		if($file['error'] == UPLOAD_ERR_OK and is_uploaded_file($file['tmp_name'])) {
            		move_uploaded_file($file['tmp_name'], '../file/'.$file['name']);
					$lg = new LogicGene();
					$la = new LogicAnalysis();
					$tr = "";
					$tlp->assign('MESSAGE',"Your file has been uploaded. ");
					$fp = fopen('../file/'.$file['name'],'r');
					if (!feof($fp)) {
						$str = fgets($fp);
					}
					while(!feof($fp)) {
						$str = fgets($fp);
						$ex = explode(",", $str);
						$analysis = new Analysis();
						$analysis->geneSymbol = $ex[1];
						$analysis->p_value = doubleval($ex[2]);
						$analysis->foldChange = doubleval($ex[3]); 
						$analysis->name = $ex[5];
						$analysis->date = $ex[6];
						$analysis->id_experiment = $_SESSION['idexperiment'];
						
						$la->DTO->setValue('analysis',$analysis);
						$la->insertAnalysis();
						if (($lg->retrieveGeneByGeneSymbol($ex[1]))==NULL) {
							$gene = new Gene();
							$gene->geneAssignment  = $ex[0];
							$gene->geneSymbol = $ex[1];
							$gene->refSeq = $ex[4];
							$lg->DTO->setValue('gene',$gene);
							$lg->insertGene();		
						}
						
					}
					$la->db->close();
					$lg->db->close();
					$_SESSION['idexperiment'] = "";
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
	





?>