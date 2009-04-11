<?php


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

//echo '<pre>', print_r($entries); echo '</pre>';

?>