<?php		class Juzs extends model 
	{ 
		var $table = "juzs";		function getVerses ($juzid="") {			$sql = "select v.*, s.sno, s.name as sura from verses as v					inner join suras as s on s.id = v.suraid					inner join juzs as j on j.id = v.juzid					where 1=1 ";								if ($juzid) $sql .= " and v.juzid = ".$juzid;								$sql .= " order by v.id asc";						return fetchRows($sql);		}		
	}
?>