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
		<h1>Create a Set</h1>
		
		<form method="post" action="?module=sets&action=set_save">
			<div class="grid">
				<div class="row cells10">
					<div class="cell colspan4">
						<label>Name</label>
						<div class="input-control text full-size">
							<input type="text" name="set[name]" class="required">
						</div>
					</div>					
					<div class="cell colspan6">	
						<label>Description</label>
						<div class="input-control text full-size">
							<input type="text" name="set[description]" class="">
						</div>
					</div>					
				</div>					
				<div class="row">
					<input type="submit" class="button" value="Save">
				</div>					
			</div>					
		</form>
		
	</div>
</div>	