<div class="row cells12">
	<div class="cell colspan2">
		<ul class="bg-olive sidebar2" style="max-width:100% !important;">
			<li class="" ><a href="" onclick="randomJuz();return false;" class="bg-hover-red bg-darkRed fg-white"><span class="mif-apps icon"></span>Random <small>1 - 30</small></a></li>
			<? foreach ($juzs as $r) { ?>
				<li class="" onclick="selectJuz(this)" id="jno<?=$r['jno']?>" data-id="<?=$r['id']?>" data-jno="<?=$r['jno']?>" data-name="<?=$r['name']?>">
					<a class="bg-olive fg-white bg-hover-green" href="#"><span class="mif-apps icon"></span><?=$r['name']?> <small>(<?=$r['jno']?>)</small></a>
				</li>
			<? } ?>
		</ul>
	</div>
	<div class="cell colspan10 padding20">
		<h3> Order </h3>
		<label class="input-control radio">
			<input type="radio" checked value="start" name="order">
			<span class="check"></span>
			<span class="caption">Start</span>
		</label>
		<label class="input-control radio">
			<input type="radio" value="random" name="order">
			<span class="check"></span>
			<span class="caption">Random</span>
		</label>
		<h1 id="juzname">Select a Juz</h1>
		<div class="place-right">	
			<button id="nextbtn" class="no-display button bg-green fg-white" onclick="nextVerse()">Next</button> &nbsp;
			<button id="refreshbtn" class="no-display button bg-darkCobalt fg-white" onclick="reselectJuz()">Refresh</button>
		</div>
		<div id="content" class="align-right sub-header padding20" style="font-size:2em;clear:both !important">
			
		</div>
	</div>
</div>

<script>
	var verses = [];
	var curno = 0;
	var sura = '';
	var jno = '';
	var random = '';
	
	function reselectJuz() {
		if (random) randomJuz();
		else selectJuz();
	}
	
	function randomJuz() {
		var rno = Math.floor(Math.random() * 29) + 1;
		jno = rno;
		random = 1;
		selectJuz();
	}
	
	function selectJuz(obj) {
		$('#content').html('Loading...');		
		$('html, body').animate({
			scrollTop: parseInt($("#juzname").offset().top)
		}, 100);
		
		if (obj) { jno = $(obj).data('jno'); random = ''; }//new select
		else obj = $('#jno'+jno); //reselect
		
		var name = $(obj).data('name');
		var sno = $(obj).data('sno');
		var id = $(obj).data('id');
		var order = $('input[name=order]:checked').val();
		
		$('#juzname').html('Juz '+name+' ('+jno+')');
		
		$.get("?module=juzs&action=getVerses&format=json&id=" + id, null,function(d){
			verses = JSON.parse(d);
			
			if (order == 'random') curno = Math.floor(Math.random()*verses.length); //random
			else curno = 0;
			
			sura = verses[curno].sura;
			
			$('#content').html(verses[curno].sura+' ('+verses[curno].sno+') '+'<br><br>');
			$('#content').prepend(verses[curno].vno+' - '+verses[curno].text+'<br><br>');
			$('#nextbtn,#refreshbtn').removeClass('no-display');
		})
		
	}
	
	function nextVerse() {
		curno++;
		$('#content').prepend(verses[curno].vno+' - '+verses[curno].text+'<br><br>');
		
		if (verses[curno+1].sura != sura) {
			sura = verses[curno+1].sura;
			$('#content').prepend(sura+' ('+verses[curno+1].sno+') '+'<br><br>');
		}
		
		if (curno+1 >= verses.length) {
			$('#nextbtn').addClass('no-display');
			$('#content').prepend('End of Juz<br><br>');
		}
	}
</script>