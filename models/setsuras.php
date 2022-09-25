<?php		class SetSuras extends model 
	{ 
		var $table = "setsuras";		function search ($setid="") {			$sql = "select s.*,ss.id as ssid from suras as s					left join setsuras as ss on s.id = ss.suraid and ss.setid = ".$setid."					where 1=1 ";			$sql .= " order by s.sno asc";						return fetchRows($sql);		}		
	}
?>