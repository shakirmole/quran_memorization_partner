<?
    define('ElementHover','');
    define('LinkText','fg-white');
    define('LinkHoverText','fg-hover-white');
    define('LinkHoverBkg','bg-hover-darkCobalt');
?>
<nav class="app-bar bg-darkCyan" data-role="appbar">
	<a href="?action=index" class="app-bar-element no-pc"></a>
	<ul class="app-bar-menu">
		<li>
			<a class='<?=ElementHover?>' href="?module=home&action=index">Home</a>
		</li>
		<li>
			<a class='<?=ElementHover?>' href="?module=juzs&action=index">Juz Wise</a>
		</li>
		<li>
			<a class='<?=ElementHover?>' href="?module=suras&action=index">Sura Wise</a>
		</li>
		<li>
			<a class='<?=ElementHover?>' href="?module=sets&action=index">Sets</a>
		</li>
	</ul>
	<span class="app-bar-pull"></span>
</nav>