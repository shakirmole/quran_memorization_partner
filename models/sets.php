<?php		class Sets extends model 
	{ 
		var $table = "sets";		function getDetails($setid="") {			$sql = "select s.*, 					( select count(*) from (						select v.id from setjuzs as sj						inner join verses as v on sj.juzid = v.juzid						where sj.setid = s.id						UNION						select v.id from setsuras as ss						inner join verses as v on ss.suraid = v.suraid						where ss.setid = s.id						UNION						select v.id from setverses as sv						inner join verses as v on v.id between sv.fromverseid and sv.toverseid						where sv.setid = s.id					) as x					order by x.id ) as total					from sets as s					where s.id = ".$setid;			// echo $sql;						return fetchRow($sql);		}		
	}
?>