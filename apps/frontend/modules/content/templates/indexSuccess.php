	<div id="content">
		<!-- Start of main content -->
<?php

/* Photos */
if (!empty($entries['photos'])) {
	$photoItems = array();
	foreach ($entries['photos'] as $items) {
		$text    = $items->getPhotoImage();
	 
		$photoItems[] =  <<<HTML
		<li>{$text}</li>
HTML;
	}
	
	$photoItems = implode("\n", $photoItems);	
	
	echo <<<HTML
<div id="myPhotos" class="mod gallery">
	<div class="hd"></div>
	<div class="bd">
		<ul>
		{$photoItems}
		</ul>
	</div>
	<div class="ft"></div>
</div>
HTML;
}
?>

<?php
/* Long-form blog entries */
if (!empty($entries['blog'])) {
	foreach ($entries['blog'] as $items) {
		$title   = $items->getTitle();
		$link    = $items->getLink();
		$date    = $items->getPublished('D jS F Y');		
		$extract = $items->getExtract();
		
		$site    = $items->getFeed()->getTitle(); 
		$website = $items->getFeed()->getWebsite();
		echo <<<HTML
<div class="mod blog">
	<div class="hd">
		<h2><a href="{$link}">{$title}</a></h2>
		<span class="published"><em><a href="{$website}">{$site}</a></em> on {$date}</span>
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
?>

		<!-- End of main content -->
	</div>
	<div id="related">
		<!-- Start related -->


<?php
/* Micro-blogging entries */
if (!empty($entries['micro'])) {
	$microItems = array();
	foreach ($entries['micro'] as $items) {
		$link    = $items->getLink();
		$text    = $items->getTweet(true);
		$date    = $items->getPublished('H:i D n M Y');		
		 
		$microItems[] =  <<<HTML
		<li>{$text} <a href="{$link}" class="when">#<span> {$date}</span></a></li>
HTML;
	}
	
	$microItems = implode("\n", $microItems);	
	
	echo <<<HTML
<div class="mod">
	<h2 class="hd">Latest tweets:</h2>
	<ul class="bd tweets">
		{$microItems}
	</ul>
</div>
HTML;
}
?>

<?php
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

?>
		<!-- End related -->
	</div>
