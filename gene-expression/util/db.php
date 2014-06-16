<?php

class db {

  	var $db_connect_id;
  	var $query_result;
  	var $num_queries = 0;
  	var $printError = 0;
	var $row = array();
	var $rowset = array();
	var $query_lock = "LOCK TABLES ";
	var $num_lock = 0;
	var $query_select = "";
	var $query_join = "";
	var $query_nparent_select = "";

  	//costruttore
  	function db($sqlserver, $database, $sqluser, $sqlpassword, $printErr) {

  	  	$this->db_connect_id = mysql_connect($sqlserver, $sqluser, $sqlpassword);

  	  	if ($this->db_connect_id == FALSE)
			die ("Errore nella connessione. Verificare i parametri nel file config.php");

		mysql_select_db($database, $this->db_connect_id)
			or die ("Errore nella selezione del database. Verificare i parametri nel file config.php");

		$this->printError = $printErr;
	}

	//distruttore
	function close() {

		if( $this->db_connect_id ) {

			return mysql_close($this->db_connect_id);
		}
	}

	/*
	 * SEZIONE CON AUTOCOMMIT ABILITATO
	 */
	//query semplice
	function query($query = "") {
		// elimino qualsiasi altra query
		unset($this->query_result);

		if($query != "") {

			$this->num_queries++;
			$this->query_result = mysql_query($query, $this->db_connect_id);
			if($this->printError == 1) print(mysql_error());
		}

	}

	/*
	 * SEZIONE PER GESTIONE COMMIT
	 */
	//disabilita abilita autocommit
	function autocommit($value) {

		$this->num_queries++;
		$this->query_result = mysql_query("SET AUTOCOMMIT = " . $value . ";", $this->db_connect_id);
		if($this->printError == 1) print(mysql_error());
	}
	//inizia transazione
	function start_transaction() {

		$this->num_queries++;
		$this->query_result = mysql_query("START TRANSACTION;", $this->db_connect_id);
		if($this->printError == 1) print(mysql_error());
	}
	//esegue il commit
	function commit() {

		$this->num_queries++;
		$this->query_result = mysql_query("COMMIT;", $this->db_connect_id);
		if($this->printError == 1) print(mysql_error());
	}
	//blocca le righe lette
	function query_locked($query = "") {
		// elimino qualsiasi altra query
		unset($this->query_result);
		$lock = " FOR UPDATE;";

		if($query != "") {

			$this->num_queries++;
			$this->query_result = mysql_query(($query . $lock), $this->db_connect_id);
			if($this->printError == 1) print(mysql_error());
		}

	}
	//resetta la query_lock
	function reset_lock() {

		$this->query_lock = "LOCK TABLES ";
		$this->num_lock = 0;
	}
	//inserisce la tabella
	function insert_locked_table($table, $alias, $lock) {

		if($this->num_lock != 0) $this->query_lock .= ", ";
		$this->query_lock .= $table . " AS " . $alias. " " . $lock;

		$this->num_lock += 1;
	}
	//esegue lock
	function lock() {

		$this->num_queries++;
		$this->query_result = mysql_query(($this->query_lock), $this->db_connect_id);
		if($this->printError == 1) print(mysql_error());
	}
	//esegue unlock
	function unlock() {
		$unlock = "UNLOCK TABLES";

		$this->num_queries++;
		$this->query_result = mysql_query(($unlock), $this->db_connect_id);
		if($this->printError == 1) print(mysql_error());
	}
	/*
	 * SEZIONE GENERICA
	 */
	//ultimo id inserito
	function insertedid() {

	  return ($this->db_connect_id) ? mysql_insert_id() : false;
	}
	//numero di righe
	function numrows($query_id = 0) {

		if(!$query_id) {

			$query_id = $this->query_result;
		}

		return ($query_id) ? mysql_num_rows($query_id) : false;
	}
	//numero di campi
	function numfields($query_id = 0) {

		if(!$query_id) {

			$query_id = $this->query_result;
		}

		return ($query_id) ? mysql_num_fields($query_id) : false;
	}
	//prendi una riga
	function fetchrow($query_id = 0) {

		if(!$query_id) {

			$query_id = $this->query_result;
		}

		if($query_id) {

			$this->row[$query_id] = mysql_fetch_array($query_id, MYSQL_ASSOC);

			return $this->row[$query_id];
		} else {

			return false;
		}
	}
	//prendi un'array di righe
	function fetchrowset($query_id = 0) {
		$result = array();
		if( !$query_id )
		{
			$query_id = $this->query_result;
		}

		if( $query_id )
		{
			unset($this->rowset[$query_id]);
			unset($this->row[$query_id]);

			while($this->rowset[$query_id] = mysql_fetch_array($query_id, MYSQL_ASSOC)) {
			
				$result[] = $this->rowset[$query_id];
			}

			return $result;
		} else {

			return false;
		}
	}
	//libera la memoria
	function freeresult($query_id = 0) {

		if(!$query_id) {

			$query_id = $this->query_result;
		}

		if ($query_id) {
			unset($this->row[$query_id]);
			unset($this->rowset[$query_id]);

			return true;
		} else {

			return false;
		}
	}
	//numero di query totali
	function queryNumber() {

		return $this->num_queries;
	}
	//errori sql
	function sql_error() {

		$result['message'] = mysql_error($this->db_connect_id);
		$result['code'] = mysql_errno($this->db_connect_id);

		return $result;
	}
	/*
	 * QUERIES
	 */
	//esegue una select
	function select($fields, $from, $join, $where, $options) {
		
		if(($join==NULL)) $join = "";
		if(($options==NULL)) $options = "";
		if(($where==NULL) || ($where=="")) $where = "";
		else $where =  "WHERE " . $where . "";

		$query = "SELECT " . $fields . "
			      FROM " . $from . "
			      " . $join . "
				  " . $where . "
				  " . $options . "";
		
		$this->query($query);
	}
	//select con join
	function start_select($fields) {

		$this->query_select = "SELECT " . $fields . "
							   FROM ";

		$this->query_join = "";
		$this->query_nparent_select = "";
	}
	function join_select($e1, $e1alias, $e2, $e2alias, $join, $on) {

		$this->query_join .= "`" . $e1 . "`";
		if(($e1alias != "") && (!empty($e1alias))) $this->query_join .= " AS " . $e1alias;
		$this->query_join .= " " . $join . " ";
		$this->query_join .= "`" . $e2 . "`";
		if(($e2alias != "") && (!empty($e2alias))) $this->query_join .= " AS " . $e2alias;
		$this->query_join .= " ON " . $on . ")";

		$this->query_nparent_select .= "(";
	}
	function append_join_select($e1, $e1alias, $join, $on) {

		$this->query_join .= " " . $join . " ";
		$this->query_join .= "`" . $e1 . "`";
		if(($e1alias != "") && (!empty($e1alias))) $this->query_join .= " AS " . $e1alias;
		$this->query_join .= " ON " . $on . ")";

		$this->query_nparent_select .= "(";
	}
	function from_select($e, $ealias) {

		if($this->query_join == "") $this->query_join .= ", `" . $e . "`";
		else $this->query_join .= "`" . $e . "`";

		if(($ealias != "") && (!empty($ealias))) $this->query_join .= " AS " . $ealias . ",";
	}
	function end_select($where, $options) {

		if(($options==NULL)) $options = "";
		if(($where==NULL) || ($where=="")) $where = "";
		else $where =  "WHERE " . $where . "";

		$this->query_select .= $this->query_nparent_select . $this->query_join;

		$this->query_select .= "" . $where . "
				  		 	   " . $options . "";

	}
	
	function end_select_add_option($options) {

		$this->query_select .= "" . $options . "";

	}
	
	function exec_select() {
	
		$this->query($this->query_select);
	}

	//inserisce una tupla
	function insert($table, $list) {

		$query = "INSERT INTO `" . $table . "`";

		$dim = count($list);
		$k = 1;
		$y = 0;
		$names = "(";
		$values = "VALUES (";
		
		reset($list);
		while (list($name, $value) = each($list)) {

			if(!empty($value) || $value=="0" || $value=="") {
				$names .= "`" . $name . "`";
				$values .= "'" . $value . "'";

				if($k<$dim) {$names .= ",";$values .= ",";}

				$y = $y + 1;
			}

	    	$k = $k + 1;
		}

		$names .= ")";
		$values .= ")";

		$query .= $names . " " .  $values;

		if($y>0) $this->query($query);
		
	}
	function replace($table, $list) {

		$query = "REPLACE INTO `" . $table . "`";

		$dim = count($list);
		$k = 1;
		$y = 0;
		$names = "(";
		$values = "VALUES (";

		reset($list);
		while (list($name, $value) = each($list)) {

			if(!empty($value) || $value=="0") {
				$names .= "`" . $name . "`";
				$values .= "'" . $value . "'";

				if($k<$dim) {$names .= ",";$values .= ",";}

				$y = $y + 1;
			}

	    	$k = $k + 1;
		}

		$names .= ")";
		$values .= ")";

		$query .= $names . $values;

		if($y>0) $this->query($query);
	}
	//esegue una update
	function update($table, $list, $where, $options) {

		$query = "UPDATE `" . $table . "` SET ";
		if(($options==NULL)) $options = "";

		$dim = count($list);
		$k = 1;
		$y = 0;
		reset($list);
		while (list($name, $value) = each($list)) {

			if(!empty($value) || $value=="0" || $value=="") {
				$query .= "`" . $name . "` = '" . $value . "'";
				if($k<$dim) $query .= ",";

				$y = $y + 1;
			}

	    	$k = $k + 1;
		}

		$query .= " WHERE  " . $where . "
				  " . $options . "";

		if($y>0) $this->query($query);
		
	}
	//esegue una update
	function insert_or_update($table, $list, $vincolo,$condizione)  {

		$query = "INSERT INTO `" . $table . "`";

		$dim = count($list);
		$k = 1;
		$y = 0;
		$names = "(";
		$values = "VALUES (";
		
		reset($list);
		while (list($name, $value) = each($list)) {

			if(!empty($value) || $value=="0" || $value=="") {
				$names .= "`" . $name . "`";
				$values .= "'" . $value . "'";

				if($k<$dim) {$names .= ",";$values .= ",";}

				$y = $y + 1;
			}

	    	$k = $k + 1;
		}

		$names .= ")";
		$values .= ")";

		$query .= $names . " " .  $values . "ON DUPLICATE KEY UPDATE `".$vincolo."`=".$condizione."";
		
		if($y>0) $this->query($query);
	}
	//cancella
	function delete($tables, $where) {

		$query = "DELETE FROM `" . $tables . "`
				   WHERE " . $where . "";
		$this->query($query);
	}
	function execute($query) {
	
		$this->query($query);
	
	}

}

?>
