<?php

	
	include('../template/cls_fast_template.php');
	include('../logic/logicUser.php');
	include('../logic/logicViewPermission.php');
	include('../logic/logicExperiment.php');
	
	session_start();
	if(isset($_SESSION['iduser']) && $_SESSION['type']=='superuser') {
		if (isset($_GET['user'])) {
			$lu = new LogicUser();
			$user = $lu->retrieveUserByEmail($_GET['user']);
			if ($user==NULL) {
				header("Location: selectUserController.php");
			}
			$_SESSION['page_corrent'] = "enablePermissionsController.php?user=".$_GET['user'];
			$tlp = new FastTemplate("../view");
			$tlp->define(array('experimentList' => "enablePermissionList.html", 'experiment' => "experimentPermission.html"));
			$lvp = new LogicViewPermission();
			$le = new LogicExperiment();
			$experiments_id = $lvp->retrievePermissionDisableByIdUser($user->id);
			$lu->db->close();
			$tlp->assign('HOME',"superUserChoiceController.php");
			$tlp->assign('NAME_USER',$user->name."  ".$user->surname);
			if (isset($experiments_id ) && count($experiments_id )!=0) {
				foreach ($experiments_id  as $exp_id) {
					$experiment = $le->retrieveExperimentById($exp_id['id']);	
					$tlp -> assign(array('NAME'=>$experiment->name, 'DATE'=>$experiment->date, 'LINK'=>"<a href='enablePermissionDoneController.php?iduser=".$user->id."&user=".$_GET['user']."&idexperiment=".$experiment->id."'>Enable</a>" ));
					$tlp->parse('EXPERIMENT',".experiment");
				}
			} else {
				$tlp -> assign(array('NAME'=>"", 'DATE'=>"", 'LINK'=>"" ));
			    $tlp->parse('EXPERIMENT',".experiment");	
			}
			
			$le->db->close();
			$lvp->db->close();
	
			$tlp->parse('STATE',"experimentList");
			Header("Content-type: text/html");
			$tlp->FastPrint();	
		} else {
			header("Location: selectUserController.php");
		}
	}
	
	else {
		header("Location: pageUnauthorized.php");
	}
	
	
		
		
	
	

?>