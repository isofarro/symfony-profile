<?php

/* Long-form blog entries */
if (!empty($entries['blog'])) {
	foreach ($entries['blog'] as $items) {
		$title   = $items->getTitle();
		$link    = $items->getLink();
		$date    = $items->getPublished('D jS F Y');		
		$extract = $items->getDescription();
		
		$site    = $items->getFeed()->getTitle(); 
		echo <<<HTML
<div class="mod">
	<div class="hd">
		<h2 class="hd"><a href="{$link}">{$title}</a></h2>
		<p>From: {$site} on {$date}</p>
	</div>
	<div class="bd">
		{$extract}
	</div>
	<div class="ft">
		<a href="{$link}">More</a>	
	</div>
</div>

HTML;
	}
}

/* Micro-blogging entries */
if (!empty($entries['micro'])) {
	$microItems = array();
	foreach ($entries['micro'] as $items) {
		$link    = $items->getLink();
		$text    = $items->getDescription();
		$date    = $items->getPublished('H:i D n M Y');		
		$site    = $items->getFeed()->getTitle();
		 
		$microItems[] =  <<<HTML
		<li>{$text} <span>at <a href="{$link}">{$date}</a></span></li>
HTML;
	}
	
	$microItems = implode("\n", $microItems);	
	
	echo <<<HTML
<div class="mod">
	<div class="hd"></div>
	<ul class="bd">
		{$microItems}
	</ul>
	<div class="ft"></div>
</div>
HTML;
}


/****
foreach($entries as $collection => $items) {
	echo "<h2>{$collection}</h2>\n";
	
	echo "<ul>\n";
	foreach($items as $item) {
		echo '<li><a href="',
			$item->getLink(),
			'">',
			$item->getTitle(),
			'</a></li>';
	}
	echo "</ul>\n";
}
****/

//echo '<pre>', print_r($entries); echo '</pre>';

?>