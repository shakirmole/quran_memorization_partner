<div class="row cells10">
	<div class="cell colspan10">
		<h1> <?=$set['name']?> </h1>
		<div class="place-right">
			<button id="" class="button bg-indigo fg-white" onclick="resetPage()">Reset</button>
			<button id="" class="button bg-green fg-white" onclick="startSet()">Start</button>
		</div>
	</div>
</div>
<div class="row cells10">
	<div class="cell colspan5">
		<label>Juzs</label>
		<div class="full-size" data-role="select" data-multiple="true" data-placeholder="Select a Juz">
			<select class="full-size" id="juz" multiple>
				<? foreach ($juzs as $r) { 
					if ($r['sjid']) { ?>
					<option value="<?=$r['id']?>" selected><?=$r['name']?> (<?=$r['jno']?>)</option>
					<? }
				   } ?>
			</select>
		</div>
	</div>
	<div class="cell colspan5">
		<label>Suras</label>
		<div class="full-size" data-role="select" data-multiple="true" data-placeholder="Select a Sura">
			<select class="full-size" id="sura" multiple>
				<? foreach ($suras as $r) { 
					if ($r['ssid']) { ?>
					<option value="<?=$r['id']?>" selected><?=$r['name']?> (<?=$r['sno']?>)</option>
				<? 	}
				   } ?>
			</select>
		</div>
	</div>
</div>
<div class="row cells10">
	<div class="cell colspan10">
		<h3>Verses</h3>
		<? foreach ($verses as $r) { ?>
		<label class="input-control checkbox small-check" style="padding-right:20px;">
			<input type="checkbox" checked class="verses" value="<?=$r['id']?>">
			<span class="check"></span>
			<span class="caption">
				<? if($r['versefrom'] == $r['verseto']) echo $r['versefrom']; else echo $r['versefrom'].' - '.$r['verseto']; ?>
			</span>
		</label>
		<? } ?>
	</div>
</div>

<div class="place-right">	
	<button id="nextbtn" class="no-display button bg-green fg-white" onclick="nextVerse()">Next</button>
	<button id="refreshbtn" class="no-display button bg-darkCobalt fg-white" onclick="startSet()">Refresh</button>
</div>
<h3 id="suraname"></h3>
<div id="content" class="align-right sub-header padding20 clear-both" style="font-size:2em;clear:both !important">
	
</div>

<script>
	var verses = [];
	var curno = 0;
	var jids = [];
	var sids = [];
	var svids = [];
	var sura = '';
	
	function resetPage() {
		$('#juz').find('option').each( function() {
			$(this).prop('selected','selected');
		})
		
		$('#juz').select2('destroy');
		$('#juz').select2();
		
		$('#sura').find('option').each( function() {
			$(this).prop('selected','selected');
		})
		$('#sura').select2('destroy');
		$('#sura').select2();
		
		$('.verses').prop('checked','checked');
	}
	
	function startSet() {
		jids.length = 0;
		sids.length = 0;
		svids.length = 0;
		
		$('#juz option:selected').each( function() {
			jids.push($(this).val());
		})
		
		$('#sura option:selected').each( function() {
			sids.push($(this).val());
		})
		
		$('.verses:checked').each( function() {
			svids.push($(this).val());
		})
		
		$('#content').html('Loading...');
		$('html, body').animate({
			scrollTop: parseInt($("#content").offset().top)
		}, 100);
		
		$.get("?module=home&action=getVerses&format=json&jids="+jids+"&sids="+sids+"&svids="+svids, null,function(d){
			verses = JSON.parse(d);
			
			curno = Math.floor(Math.random()*verses.length); //random
			
			renameSura('Sura '+verses[curno].sura+' ('+verses[curno].sno+')');
			
			$('#content').html(verses[curno].vno+' - '+verses[curno].text+'<br><br>');
			$('#nextbtn,#refreshbtn').removeClass('no-display');
		})
		
	}
	
	function nextVerse() {
		curno++;
		$('#content').prepend(verses[curno].vno+' - '+verses[curno].text+'<br><br>');
		renameSura('Sura '+verses[curno].sura+' ('+verses[curno].sno+')');
	}
	
	function renameSura(csura) {
		if (!sura || sura != csura) sura = 'Sura '+verses[curno].sura+' ('+verses[curno].sno+')'
		$('#suraname').html(sura);
	}
</script>