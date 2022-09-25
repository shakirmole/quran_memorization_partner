<?php		class SetJuzs extends model 
	{ 
		var $table = "SetJuzs";		function search ($setid="") {			$sql = "select j.*,sj.id as sjid from juzs as j					left join setjuzs as sj on j.id = sj.juzid and sj.setid = ".$setid."					where 1=1 ";			$sql .= " order by j.jno asc";						return fetchRows($sql);		}		
	}
?>