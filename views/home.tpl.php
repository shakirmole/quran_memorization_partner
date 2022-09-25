<div class="row cells12">
	<div class="cell colspan2">
		<ul class="bg-olive sidebar2" style="max-width:100% !important;">
			<? foreach ($sets as $r) { ?>
				<li class="" >
					<a href="#homecontent" class="bg-olive fg-white bg-hover-green" onclick="selectSet(<?=$r['id']?>)"><span class="mif-apps icon"></span><?=$r['name']?></a>
				</li>
			<? } ?>
		</ul>
	</div>
	<div class="cell colspan10 padding20" id="homecontent">
		<h1> Select a set </h1>
	</div>
</div>

<script>
	var verses = [];
	var curno = 0;
	
	function selectSet(id) {
		$('#content').html('');		
		$('html, body').animate({
			scrollTop: parseInt($("#homecontent").offset().top)
		}, 1000);
		
		$('#homecontent').load("?module=home&action=home_content&id=" + id);
		
	}
</script>