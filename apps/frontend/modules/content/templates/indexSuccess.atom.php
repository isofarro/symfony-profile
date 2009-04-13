<?php echo '<?xml version="1.0" encoding="utf-8"?>'; ?>
<feed xmlns="http://www.w3.org/2005/Atom">
	<title>Isofarro</title>
	<subtitle>My writings around the web</subtitle>
	<link rel="self" href="<?php echo url_for('content/index?sf_format=atom', true) ?>" />
	<link rel="alternate" type="text/html" href="<?php echo url_for('@homepage', true) ?>"/>
	<updated><?php 
  		echo gmstrftime(
  			'%Y-%m-%dT%H:%M:%SZ', 
  			ItemPeer::getLatestSiteItem(
  				sfConfig::get('app_default_site')
  			)->getPublished('U')
  		);
	?></updated>
	<author>
		<name>Isofarro</name>
	</author>
	<id>http://isofarro.com/</id>
 
<?php
	foreach ($entries['blog'] as $items) {
		$title   = $items->getTitle();
		$link    = $items->getLink();
		$atomid  = $items->getAtomId();
		$date    = $items->getPublished('c');		
		$extract = $items->getExtract();
		
		$site    = $items->getFeed()->getTitle(); 

		echo <<<XML
<entry>
		<title><![CDATA[{$site}: {$title}]]></title>
		<link href="{$link}" />
		<id>{$atomid}</id>
		<updated>{$date}</updated>
		<summary type="html"><![CDATA[
			{$extract}
			<a href="{$link}">More</a>
		]]>
		</summary>
	</entry>
	
XML;
	}
?>

</feed>