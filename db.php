<?php
global $db_connection, $db_result;

$db_connection = false; 
$db_connection = new SQLite3($config['database']); 

$db_result = false;


function fetchRow($sql) {
	global $db_connection, $db_result;
	$db_result = $db_connection->query($sql);
	if ( $db_result ) return $db_result->fetchArray(SQLITE3_ASSOC);
	else return false;
}

$total_pages = 0;

function fetchRows($sql, $paginate=false) {
	global $db_connection, $db_result;
	global $total_pages;
	
	$total_pages = 0;
	
	$db_result = $db_connection->query($sql);
	
	if ( $db_result ) {
	
		if ( $paginate ) {
			// implement pagination
			$page = $_GET['pg'];
			$pg_size = $_GET['pg_size'];
			if(empty($page)) $page = 1;
			if(empty($pg_size)) $pg_size = 20;
			$st = ($page-1)*$pg_size;
			$total_pages = ceil(countRows($db_result) / $pg_size);
			$sql .= ' LIMIT ' . $st . ', ' . $pg_size;
			
			$db_result = $db_connection->query($sql);
		}
	
		$results = array();
		while ($row = $db_result->fetchArray(SQLITE3_ASSOC)) {
			$results[] = $row;
		}
		return $results;
	} else return false;
}

function totalPages() {
	global $total_pages;
	return $total_pages;
}

function executeQuery($sql) {
	global $db_connection, $db_result;
	$db_result = $db_connection->query($sql);
	return $db_result;
}

function countRows($rs=null) {
	global $db_connection, $db_result;
	if ( empty($rs) ) $rs = $db_result;
	while ($rs->fetchArray(SQLITE3_ASSOC)) {
		$rowCount++;
	}
	
	return $rowCount;
}

function lastInsertId() {
	global $db_connection, $db_result;
	return $db_connection->lastInsertRowid();
}

class model {
	var $table;	
	var $paginate = false;
	
	function get($id) {
		$sql = 'select * from ' . $this->table . ' where id="'.$id.'"';
		return fetchRow($sql);
	}
	
	function getAll($orderby="", $limit="") {
		$sql = 'select * from ' . $this->table . '';
		if ( $orderby ) $sql .= ' order by ' . $orderby;
		if ( $limit ) $sql .= ' limit ' . $limit;
		return fetchRows($sql, $this->paginate);
	}
	
	function getAllVisible($orderby="", $limit="") {
		$sql = 'select * from ' . $this->table . ' where ' . $this->table . '.hide="N"';
		if ( $orderby ) $sql .= ' order by ' . $orderby;
		if ( $limit ) $sql .= ' limit ' . $limit;
		return fetchRows($sql, $this->paginate);
	}
	
	function getAllDeleted($orderby="", $limit="") {
		$sql = 'select * from ' . $this->table . ' where ' . $this->table . '.hide="Y"';
		if ( $orderby ) $sql .= ' order by ' . $orderby;
		if ( $limit ) $sql .= ' limit ' . $limit;
		return fetchRows($sql, $this->paginate);
	}
	
	function getHidden() {
	}

	function insert($data) {
		$keys = implode(', ', array_keys($data) );
		$values = '"' . implode('", "', array_values($data) ) . '"';		
		$sql = 'insert into ' . $this->table . ' (' . $keys . ') values (' . $values . ')';
		// echo $sql;
		// die;
		return executeQuery($sql);
	}

	function update($id, $data) {
		$updateClause = array();
		foreach ( $data as $iid=>$val ) {
			$updateClause[] = $iid . ' = "' . $val . '"';
		}
		$updateClause = implode(', ', $updateClause);
		$sql = 'update ' . $this->table . ' set ' . $updateClause . ' where id = "' . $id . '"';
		//echo $sql;
		//die();
		return executeQuery($sql);
	}

	function updateWhere($updateData, $data) {
		$updateClause = array();
		$whereClause = array();
		if(is_array($data)) foreach ( $data as $iid=>$val ) {
			$updateClause[] = $iid . " = '" . $val . "'";
		}
		if(is_array($updateData)) foreach ( $updateData as $iid=>$val ) {
			$whereClause[] = $iid . " = " . $val;
		}
		$updateClause = implode(", ", $updateClause);
		$whereClause = implode(" and ", $whereClause);
		$sql = "update " . $this->table . " set " . $updateClause . " where " . $whereClause;
		// echo $sql.'<br>';
		//die();
		return executeQuery($sql);
	}
	
	function updateWhereAdd($updateData, $data) {
		$updateClause = array();
		$whereClause = array();
		if(is_array($data)) foreach ( $data as $iid=>$val ) {
			$updateClause[] = $iid . " = " . $val;
		}
		if(is_array($updateData)) foreach ( $updateData as $iid=>$val ) {
			$whereClause[] = $iid . " = " . $val;
		}
		$updateClause = implode(", ", $updateClause);
		$whereClause = implode(" and ", $whereClause);
		$sql = "update " . $this->table . " set " . $updateClause . " where " . $whereClause;
		// echo $sql ;
		//die();
		return executeQuery($sql);
	}
	
	function updateIds($ids, $data) {
		$updateClause = array();
		foreach ( $data as $iid=>$val ) {
			$updateClause[] = $iid . ' = ' . $val;
		}
		$updateClause = implode(', ', $updateClause);
		$sql = 'update ' . $this->table . ' set ' . $updateClause . ' where id in (' . $ids . ')';
		// echo $sql;
		// die();
		return executeQuery($sql);
	}
	
	function real_delete($id) {
		$sql = 'delete from ' . $this->table . ' where id="'.$id.'"';
		return executeQuery($sql);
	}
	
	function delete($id) {
		$sql = 'update ' . $this->table . ' set status="inactive" where id="'.$id.'"';
		echo $sql;
		return executeQuery($sql);
	}

	function undelete($id) {
		$sql = 'update ' . $this->table . ' set hide="N" where id="'.$id.'"';
		return executeQuery($sql);
	}
	
	function deleteWhere($data) {
		$whereClause = array();
		foreach ( $data as $id=>$val ) {
			$whereClause[] = $id . ' = "' . $val . '"';
		}
		$whereClause = implode(' and ', $whereClause);
		
		$sql = 'delete from ' . $this->table . ' where '.$whereClause;
		//echo $sql;
		return executeQuery($sql);
	}

	function find($data, $sortby = 'id') {
		$whereClause = array();
		
		if ( is_array($data) ) {
			foreach ( $data as $id=>$val ) {
				$whereClause[] = $id . ' = "' . $val . '"';
			}
			$whereClause = implode(' and ', $whereClause);
		} else $whereClause = $data;
		
		$sql = 'select * from ' . $this->table . ' where ' . $whereClause . ' order by ' . $sortby;
		
		return fetchRows($sql);
	}
	
	function clearTable() {
		$sql = "delete from ".$this->table;
		executeQuery($sql);
		
		$sql = "update sqlite_sequence set seq = 0 where name = '".$this->table."';";
		return executeQuery($sql);
	}
	
					
	function getMaxId() {
		$sql = "select max(id) as id from ".$this->table;
		
		return fetchRow($sql);
	}
	
	function insertSQL($data){	
		$values = implode(", ", $data[1]);	
		
		$sql .= "insert into ".$this->table." (" . $data[0] . ") values " . $values;
		
		return executeQuery($sql);
	}
	
	function count($rs="") {
		return countRows($rs);
	}
	
	function lastId() {
		return lastInsertId();
	}
	
	function totalPages() {
		return totalPages();
	}
	
}

?>