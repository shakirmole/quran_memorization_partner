<?php
	
	class Verses extends model 
	{ 
		var $table = "Verses";

		function getVerses($search="") {
			$sql = "select v.id, s.name||' '||s.sno||':'||v.vno as text from verses as v
					inner join suras as s on s.id = v.suraid
					where 1=1 ";
			if ($search)	$sql .= " and s.name||' '||s.sno||':'||v.vno like '%".$search."%'";	
			$sql .= " order by v.id asc";
			// echo $sql;
			return fetchRows($sql);
		}
		
	}

?>