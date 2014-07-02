<?php

	
	include('../model/analysisInstance.php');
	include_once('logic.php');
	
	class LogicAnalysisInstance extends Logic {

		var $analysisInstance;
	
		function __construct() {
			parent::__construct();
			$this->analysisInstance = null;	
		}
		
		
		public function __get($value) {
			return $this->$value;
		}
	
		public function __set($name,$value) {
			$this->$name = $value;
		}	
	
		function insertAnalysisInstance() {
			$this->analysisInstance = $this->DTO->getValue('analysisInstance');
			$list = $this->createList();
			$this->db->insert('analysis_instance',$list);
		}
		
		function deleteAnalysisInstanceByIdAnalysis($idAnalysis) {
			$this->db->delete('analysis_instance','id_analysis='.$idAnalysis);
		}
		
		
		
		
		function retrieveAnalysisInstanceByIdExperimentThreshold($idExperiment,$pvalue,$foldchange) {
			$this->db->execute("SELECT *
								FROM analysis, analysis_instance
								WHERE id_experiment='".$idExperiment."' and id=id_analysis and p_value>='".$pvalue."' and foldChange>='".$foldchange."'");
			$result = $this->db->fetchrowset();
			if ($result) {
				if (count($result)!=0) {
				
				return $result;
				} else {
					return NULL;
				}
			} else {
				return NULL;
			}
			
		}
		
		
		function retrieveAnalysisInstanceByIdExperiment($idExperiment) {
			$this->db->execute("SELECT *
								FROM analysis, analysis_instance
								WHERE id_experiment='".$idExperiment."' and id=id_analysis");
			$result = $this->db->fetchrowset();
			if ($result) {
				if (count($result)!=0) {
				
				return $result;
				} else {
					return NULL;
				}
			} else {
				return NULL;
			}
			
		}
		
	
	
		
		function createList() {
			$list = array();
			$list['id_analysis'] = $this->analysisInstance->id_analysis;
			$list['geneSymbol'] =  $this->analysisInstance->geneSymbol;
			$list['p_value'] =  $this->analysisInstance->p_value;
			$list['foldChange'] =  $this->analysisInstance->foldChange;
			return $list;
			
		}
		
		function retrieveAnalysisInstanceByIdExperiment_All($idExperiment,$ida,$pvalue,$foldchange) {
			$this->db->execute("SELECT *
								FROM analysis, analysis_instance
								WHERE id_experiment='".$idExperiment."' and id=id_analysis and id_analysis='".$ida."'");
			$result = $this->db->fetchrowset();
			if ($result) {
				if (count($result)!=0) {
				
				return $result;
				} else {
					return NULL;
				}
			} else {
				return NULL;
			}
			
		}
		
		
		function retrieveAnalysisInstanceByIdExperiment_Up_All($idExperiment,$pvalue,$foldchange) {
			$this->db->execute("SELECT *
								FROM analysis, analysis_instance
								WHERE id_experiment='".$idExperiment."' and id=id_analysis and p_value>='".$pvalue."'");
			$result = $this->db->fetchrowset();
			if ($result) {
				if (count($result)!=0) {
				
				return $result;
				} else {
					return NULL;
				}
			} else {
				return NULL;
			}
			
		}

		
		function retrieveAnalysisInstanceByIdExperiment_Up_Up($idExperiment,$pvalue,$foldchange) {
			$this->db->execute("SELECT *
								FROM analysis, analysis_instance
								WHERE id_experiment='".$idExperiment."' and id=id_analysis and p_value>='".$pvalue."' and foldChange>='".$foldchange."'");
			$result = $this->db->fetchrowset();
			if ($result) {
				if (count($result)!=0) {
				
				return $result;
				} else {
					return NULL;
				}
			} else {
				return NULL;
			}
			
		}
		
		function retrieveAnalysisInstanceByIdExperiment_Up_Down($idExperiment,$pvalue,$foldchange) {
			$this->db->execute("SELECT *
								FROM analysis, analysis_instance
								WHERE id_experiment='".$idExperiment."' and id=id_analysis and p_value>='".$pvalue."' and foldChange<='".$foldchange."'");
			$result = $this->db->fetchrowset();
			if ($result) {
				if (count($result)!=0) {
				
				return $result;
				} else {
					return NULL;
				}
			} else {
				return NULL;
			}
			
		}
		
		function retrieveAnalysisInstanceByIdExperiment_Down_All($idExperiment,$pvalue,$foldchange) {
			$this->db->execute("SELECT *
								FROM analysis, analysis_instance
								WHERE id_experiment='".$idExperiment."' and id=id_analysis and p_value<='".$pvalue."'");
			$result = $this->db->fetchrowset();
			if ($result) {
				if (count($result)!=0) {
				
				return $result;
				} else {
					return NULL;
				}
			} else {
				return NULL;
			}
			
		}
		
		
		function retrieveAnalysisInstanceByIdExperiment_Down_Up($idExperiment,$pvalue,$foldchange) {
			$this->db->execute("SELECT *
								FROM analysis, analysis_instance
								WHERE id_experiment='".$idExperiment."' and id=id_analysis and p_value<='".$pvalue."' and foldChange>='".$foldchange."'");
			$result = $this->db->fetchrowset();
			if ($result) {
				if (count($result)!=0) {
				
				return $result;
				} else {
					return NULL;
				}
			} else {
				return NULL;
			}
			
		}
		
		function retrieveAnalysisInstanceByIdExperiment_Down_Down($idExperiment,$pvalue,$foldchange) {
			$this->db->execute("SELECT *
								FROM analysis, analysis_instance
								WHERE id_experiment='".$idExperiment."' and id=id_analysis and p_value<='".$pvalue."' and foldChange<='".$foldchange."'");
			$result = $this->db->fetchrowset();
			if ($result) {
				if (count($result)!=0) {
				
				return $result;
				} else {
					return NULL;
				}
			} else {
				return NULL;
			}
			
		}
		
		function retrieveAnalysisInstanceByIdExperiment_All_Down($idExperiment,$pvalue,$foldchange) {
			$this->db->execute("SELECT *
								FROM analysis, analysis_instance
								WHERE id_experiment='".$idExperiment."' and id=id_analysis and foldChange<='".$foldchange."'");
			$result = $this->db->fetchrowset();
			if ($result) {
				if (count($result)!=0) {
				
				return $result;
				} else {
					return NULL;
				}
			} else {
				return NULL;
			}
			
		}
		
		function retrieveAnalysisInstanceByIdExperiment_All_Up($idExperiment,$pvalue,$foldchange) {
			$this->db->execute("SELECT *
								FROM analysis, analysis_instance
								WHERE id_experiment='".$idExperiment."' and id=id_analysis and foldChange>='".$foldchange."'");
			$result = $this->db->fetchrowset();
			if ($result) {
				if (count($result)!=0) {
				
				return $result;
				} else {
					return NULL;
				}
			} else {
				return NULL;
			}
			
		}
		
		function retrieveAnalysisInstanceByIdExperiment_All_Range($idExperiment,$pvalue,$foldchange) {
			$this->db->execute("SELECT *
								FROM analysis, analysis_instance
								WHERE id_experiment='".$idExperiment."' and id=id_analysis and foldChange>='-".$foldchange."' and foldChange<='".$foldchange."'");
			$result = $this->db->fetchrowset();
			if ($result) {
				if (count($result)!=0) {
				
				return $result;
				} else {
					return NULL;
				}
			} else {
				return NULL;
			}
			
		}
		
		function retrieveAnalysisInstanceByIdExperiment_Up_Range($idExperiment,$pvalue,$foldchange) {
			$this->db->execute("SELECT *
								FROM analysis, analysis_instance
								WHERE id_experiment='".$idExperiment."' and id=id_analysis and p_value>='".$pvalue."' and foldChange>='-".$foldchange."' and foldChange<='".$foldchange."'");
			$result = $this->db->fetchrowset();
			if ($result) {
				if (count($result)!=0) {
				
				return $result;
				} else {
					return NULL;
				}
			} else {
				return NULL;
			}
			
		}
		
		function retrieveAnalysisInstanceByIdExperiment_Down_Range($idExperiment,$pvalue,$foldchange) {
			$this->db->execute("SELECT *
								FROM analysis, analysis_instance
								WHERE id_experiment='".$idExperiment."' and id=id_analysis and p_value<='".$pvalue."' and foldChange>='-".$foldchange."' and foldChange<='".$foldchange."'");
			$result = $this->db->fetchrowset();
			if ($result) {
				if (count($result)!=0) {
				
				return $result;
				} else {
					return NULL;
				}
			} else {
				return NULL;
			}
			
		}
		
		function retrieveAnalysisInstanceByIdExperiment_Range_All($idExperiment,$pvalue,$foldchange) {
			$this->db->execute("SELECT *
								FROM analysis, analysis_instance
								WHERE id_experiment='".$idExperiment."' and id=id_analysis and p_value<='".$pvalue."' and p_value>='-".$pvalue."'");
			$result = $this->db->fetchrowset();
			if ($result) {
				if (count($result)!=0) {
				
				return $result;
				} else {
					return NULL;
				}
			} else {
				return NULL;
			}
			
		}
		
		function retrieveAnalysisInstanceByIdExperiment_Range_Up($idExperiment,$pvalue,$foldchange) {
			$this->db->execute("SELECT *
								FROM analysis, analysis_instance
								WHERE id_experiment='".$idExperiment."' and id=id_analysis and p_value<='".$pvalue."' and p_value>='-".$pvalue."' and foldChange>='".$foldchange."'");
			$result = $this->db->fetchrowset();
			if ($result) {
				if (count($result)!=0) {
				
				return $result;
				} else {
					return NULL;
				}
			} else {
				return NULL;
			}
			
		}
		
		function retrieveAnalysisInstanceByIdExperiment_Range_Down($idExperiment,$pvalue,$foldchange) {
			$this->db->execute("SELECT *
								FROM analysis, analysis_instance
								WHERE id_experiment='".$idExperiment."' and id=id_analysis and p_value<='".$pvalue."' and p_value>='-".$pvalue."' and foldChange<='".$foldchange."'");
			$result = $this->db->fetchrowset();
			if ($result) {
				if (count($result)!=0) {
				
				return $result;
				} else {
					return NULL;
				}
			} else {
				return NULL;
			}
			
		}
		
		function retrieveAnalysisInstanceByIdExperiment_Range_Range($idExperiment,$pvalue,$foldchange) {
			$this->db->execute("SELECT *
								FROM analysis, analysis_instance
								WHERE id_experiment='".$idExperiment."' and id=id_analysis and p_value<='".$pvalue."' and p_value>='-".$pvalue."' and foldChange<='".$foldchange."' and foldChange>='-".$foldChange."'");
			$result = $this->db->fetchrowset();
			if ($result) {
				if (count($result)!=0) {
				
				return $result;
				} else {
					return NULL;
				}
			} else {
				return NULL;
			}
			
		}
		
		
		
		
}



?>