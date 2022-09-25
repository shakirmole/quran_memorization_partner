<div class="row cells12">
	<div class="cell colspan2">
		<ul class="bg-olive sidebar2" style="max-width:100% !important;">
			<li class="" ><a href="" onclick="randomSura();return false;" class="bg-hover-red bg-darkRed fg-white"><span class="mif-apps icon"></span>Random <small>1 - 114</small></a></li>
			<? foreach ($suras as $r) { ?>
				<li class="" >
					<a href="" onclick="selectSura(this);return false;" class="bg-olive fg-white bg-hover-green"  id="sno<?=$r['sno']?>" data-id="<?=$r['id']?>" data-sno="<?=$r['sno']?>" data-name="<?=$r['name']?>"><span class="mif-apps icon"></span><?=$r['name']?> <small>(<?=$r['sno']?>)</small></a>
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
		<h1 id="suraname">Select a Sura</h1>
		<div class="place-right">	
			<button id="nextbtn" class="no-display button bg-green fg-white" onclick="nextVerse()">Next</button>
			<button id="refreshbtn" class="no-display button bg-darkCobalt fg-white" onclick="reselectSura()">Refresh</button>
		</div>
		<div id="content" class="align-right sub-header padding20 clear-both" style="font-size:30px;clear:both !important;">
			
		</div>
	</div>
</div>

<script>
	var verses = [];
	var curno = 0;
	var sno = '';
	var random = '';
	
	function reselectSura() {
		if (random) randomSura();
		else selectSura();
	}
	
	function randomSura() {
		var rno = Math.floor(Math.random() * 113) + 1;
		sno = rno;
		random = 1;
		selectSura();
	}
	
	function selectSura(obj) {
		$('#content').html('Loading...');
		$('html, body').animate({
			scrollTop: parseInt($("#suraname").offset().top)
		}, 100);

		if (obj) { sno = $(obj).data('sno'); random = ''; }//new select
		else obj = $('#sno'+sno); //reselect
		
		sno = $(obj).data('sno');
		var name = $(obj).data('name');
		var id = $(obj).data('id');
		var order = $('input[name=order]:checked').val();
		
		$('#suraname').html('Sura '+name+' ('+sno+')');
		
		$.get("?module=suras&action=getVerses&format=json&id=" + id, null,function(d){
			verses = JSON.parse(d);
			
			if (order == 'random') curno = Math.floor(Math.random()*verses.length); //random
			else curno = 0;
			
			$('#content').html(verses[curno].vno+' - '+verses[curno].text+'<br><br>');
			$('#nextbtn,#refreshbtn').removeClass('no-display');
		})
		
	}
	
	function nextVerse() {
		curno++;
		$('#content').prepend(verses[curno].vno+' - '+verses[curno].text+'<br><br>');
		if (curno+1 >= verses.length) {
			$('#nextbtn').addClass('no-display');
			$('#content').prepend('End of Sura<br><br>');
		}
	}
</script>