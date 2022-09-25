<?php		class Suras extends model 
	{ 
		var $table = "suras";		function getVerses ($suraid="") {			$sql = "select v.* from verses as v					inner join suras as s on s.id = v.suraid					where 1=1 ";								if ($suraid) $sql .= " and v.suraid = ".$suraid;								$sql .= " order by v.vno asc";						return fetchRows($sql);		}		
	}
?>