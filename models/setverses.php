<?php		class SetVerses extends model 
	{ 
		var $table = "setverses";		function search($setid="") {			$sql = "select sv.id, sv.fromverseid, sv.toverseid, 					sf.name||' '||sf.sno||':'||vf.vno as textfrom,					st.name||' '||st.sno||':'||vt.vno as textto,					sf.sno||':'||vf.vno as versefrom,					st.sno||':'||vt.vno as verseto from setverses as sv					inner join verses as vf on vf.id = sv.fromverseid					inner join suras as sf on sf.id = vf.suraid					inner join verses as vt on vt.id = sv.toverseid					inner join suras as st on st.id = vt.suraid					where 1=1 and sv.setid = ".$setid;								// echo $sql;			return fetchRows($sql);		}				function getVerses($jids="",$sids="",$svids="") {			$sql = "select v.*, s.sno, s.name as sura from verses as v					inner join suras as s on s.id = v.suraid					where v.id in (						select id from (							select v.id from setjuzs as sj							inner join verses as v on sj.juzid = v.juzid							where v.juzid in (".$jids.")							UNION							select v.id from setsuras as ss							inner join verses as v on ss.suraid = v.suraid							where v.suraid in (".$sids.")							UNION							select v.id from setverses as sv							inner join verses as v on v.id between sv.fromverseid and sv.toverseid							where sv.id in (".$svids.")						) as x					)";			// echo $sql;						return fetchRows($sql);		}		
	}
?>