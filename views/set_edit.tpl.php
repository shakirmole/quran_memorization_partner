<div class="row cells12">
	<div class="cell colspan2">
		<ul class="bg-olive sidebar2" style="max-width:100% !important;">
			<? foreach ($sets as $r) { ?>
				<li class="" >
					<a href="?module=sets&action=set_edit&id=<?=$r['id']?>" class="bg-olive fg-white bg-hover-green" ><span class="mif-apps icon"></span><?=$r['name']?></a>
				</li>
			<? } ?>
		</ul>
	</div>
	<div class="cell colspan10 padding20">
		<h1><?=$set['name']?> (<?=$set['total']?> Verses)</h1>
		
		<form method="post" action="?module=sets&action=set_update">
			<input type="hidden" name="id" value="<?=$set['id']?>">
			<div class="grid">
				<div class="row cells9">
					<div class="cell colspan4">
						<label>Name</label>
						<div class="input-control text full-size">
							<input type="text" name="set[name]" value="<?=$set['name']?>" class="required">
						</div>
					</div>					
					<div class="cell colspan5">	
						<label>Description</label>
						<div class="input-control text full-size">
							<input type="text" name="set[description]" value="<?=$set['description']?>" class="">
						</div>
						
					</div>
				</div>				
				<div class="row cells10">
					<div class="cell colspan5">
						<label>Juzs</label>
						<div class="full-size" data-role="select" data-multiple="true" data-placeholder="Select a Juz">
							<select class="full-size" name="juz[]" multiple>
								<? foreach ($juzs as $r) { ?>
									<option value="<?=$r['id']?>" <?=($r['sjid'])?'selected':'';?>><?=$r['name']?> (<?=$r['jno']?>)</option>
								<? } ?>
							</select>
						</div>
					</div>
					<div class="cell colspan5">
						<label>Suras</label>
						<div class="full-size" data-role="select" data-multiple="true" data-placeholder="Select a Sura">
							<select class="full-size" name="sura[]" multiple>
								<? foreach ($suras as $r) { ?>
									<option value="<?=$r['id']?>" <?=($r['ssid'])?'selected':'';?>><?=$r['name']?> (<?=$r['sno']?>)</option>
								<? } ?>
							</select>
						</div>
					</div>
				</div>
				<div class="row cells10">
					<div class="cell colspan10">
						<big>Verses</big>
						<table class="table bordered border">
							<thead>
								<tr>
									<th>From Verse</th>
									<th>To Verse</th>
									<th>Total</th>
								</tr>
							</thead>
							<tbody>
								<? foreach ($verses as $r) { ?>
								<tr id="rowv<?=$i?>">
									<td style="width:40%">
										<div data-role="select" data-placeholder="Select a Verse" onchange="countVerses('v<?=$i?>')">
											<select id="fvidv<?=$i?>" class="verseid full-size" name="fvid[]">
												<option selected value="<?=$r['fromverseid']?>"><?=$r['textfrom']?></option>
											</select>
										</div>
									</td>
									<td style="width:40%">
										<div data-role="select" data-placeholder="Select a Verse" onchange="countVerses('v<?=$i?>')">
											<select id="tvidv<?=$i?>" class="verseid full-size" name="tvid[]">
												<option selected value="<?=$r['toverseid']?>"><?=$r['textto']?></option>
											</select>
										</div>
									</td>
									<td>
										<span id="countv<?=$i?>"><?=$r['toverseid']-$r['fromverseid']+1?></span>
										<span class="mif-cross mif-2x place-right fg-red" onclick="removeSetVerse('v<?=$i?>')"></span>
									</td>
								</tr>
								<? } ?>
								<? for ($i=0;$i<5;$i++) { ?>
								<tr>
									<td style="width:40%">
										<div data-role="select" data-placeholder="Select a Verse" onchange="countVerses(<?=$i?>)">
											<select id="fvid<?=$i?>" class="verseid full-size" name="fvid[]">
												
											</select>
										</div>
									</td>
									<td style="width:40%">
										<div data-role="select" data-placeholder="Select a Verse" onchange="countVerses(<?=$i?>)">
											<select id="tvid<?=$i?>" class="verseid full-size" name="tvid[]">
												
											</select>
										</div>
									</td>
									<td>
										<span id="count<?=$i?>">0</span>
									</td>
								</tr>
								<? } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>					
			<input type="submit" class="button" value="Save" style="position:fixed;right:0px;bottom:10%">
			<a onclick="return confirm('Are you sure?')" class="button bg-red fg-white" href="?module=sets&action=set_delete&id=<?=$set['id']?>">Delete Set</a>
		</form>
		
	</div>
</div>

<script>	
	$('.verseid').select2({
		minimumInputLength:3,
		ajax: {
			url: "?module=sets&action=getAllVerses&format=json",
			dataType: 'json',
			delay: 250,
			data: function (params) {
				return {
					search: params.term // search term
				};
			},
			processResults: function (data, params) {
				return {
					results: data.items
				};
			},
			cache: true
		}
	})
	
	function countVerses(no) {
		var fvid = parseInt($('#fvid'+no).val());
		var tvid = parseInt($('#tvid'+no).val());
		var count = tvid - fvid + 1;
		$('#count'+no).html(count);
	}
	
	function removeSetVerse(no) {
		$('#row'+no).remove();
	}
</script>