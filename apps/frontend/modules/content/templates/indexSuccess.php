<?php

/* Photos */
if (!empty($entries['photos'])) {
	$photoItems = array();
	foreach ($entries['photos'] as $items) {
		$text    = $items->getDescription();
	 
		$photoItems[] =  <<<HTML
		<li>{$text}</li>
HTML;
	}
	
	$photoItems = implode("\n", $photoItems);	
	
	echo <<<HTML
<div class="mod photos">
	<h2 class="hd">Photos</h2>
	<ul class="bd">
		{$photoItems}
	</ul>
</div>
HTML;
}


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
		 
		$microItems[] =  <<<HTML
		<li>{$text} <span>at <a href="{$link}">{$date}</a></span></li>
HTML;
	}
	
	$microItems = implode("\n", $microItems);	
	
	echo <<<HTML
<div class="mod">
	<h2 class="hd">Latest tweets:</h2>
	<ul class="bd">
		{$microItems}
	</ul>
</div>
HTML;
}


/* Bookmarks */
if (!empty($entries['links'])) {
	$bookmarks = array();
	foreach ($entries['links'] as $items) {
		$link    = $items->getLink();
		$title   = $items->getTitle();
		$text    = $items->getDescription();
		$date    = $items->getPublished('H:i D n M Y');		
		 
		if ($text) {
			$text = '<p>' . $text . '</p>';
		}

		$bookmarks[] =  <<<HTML
		<li>
			<h3><a href="{$link}">{$title}</a></h3>
			{$text}
		</li>
HTML;
	}
	
	$bookmarks = implode("\n", $bookmarks);	
	
	echo <<<HTML
<div class="mod bookmarks">
	<h2 class="hd">Recently bookmarked:</h2>
	<ul class="bd">
		{$bookmarks}
	</ul>
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