<?php

class profileUpdatefeedsTask extends sfPropelBaseTask {
	// A feed parser
	protected $parser;
	
	protected function configure() {
		// // add your own arguments here
		// $this->addArguments(array(
		//   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
		// ));
		
		$this->addOptions(array(
			new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name'),
			new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
			new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'propel'),
			// add your own options here
		));
		
		$this->namespace        = 'profile';
		$this->name             = 'update-feeds';
		$this->briefDescription = 'Updates profile feeds';
		$this->detailedDescription = <<<EOF
The [profile:update-feeds|INFO] task updates all the feeds.
Call it with:

	[php symfony profile:update-feeds|INFO]
EOF;
	}

	protected function execute($arguments = array(), $options = array()) {
		// initialize the database connection
		$databaseManager = new sfDatabaseManager($this->configuration);
		$connection = $databaseManager->getDatabase($options['connection'] ? $options['connection'] : null)->getConnection();

		$totalNewItems = 0;

		// Get all the listed feeds
		$feeds = FeedPeer::doSelect(new Criteria());
		//print_r($feeds);
		
		foreach($feeds as $feed) {
			$newItems       = $this->updateFeed($feed);
			$totalNewItems += $newItems;
			break;
		}
		echo $totalNewItems, " new items added\n";
	}
	
	/**
	* Takes a Feed object and updates the Item table with new entries on that feed
	* Returns number of new records added
	**/
	protected function updateFeed($feedRecord) {
		$feed = $this->getFeed($feedRecord->getLink());
		echo "Feed: ", $feedRecord->getLink(), " (", count($feed->entries), " items)\n";
		
		$itemCriteria = new Criteria();
		$newItems     = 0;
		
		// Short circuit if the feed parsing failed
		if (empty($feed) || empty($feed->entries)) {
			echo "ERROR: Returned feed not valid, or empty\n";
			return 0;
		}

		foreach($feed->entries as $entry) {
			//echo $entry->title, "\n";
			
			// Check whether this entry already exists
			$itemCriteria->add(ItemPeer::ATOMID, $entry->id, Criteria::EQUAL);
			$num = ItemPeer::doCount($itemCriteria);
			
			// Skip the current entry if we already have it
			if ($num>0) {
				//echo "INFO: Duplicate atom id: {$entry->id}. Skipping\n";
				continue;
			}
			
			// Create a new Item record, and save
			$item = new Item();
			$item->fromArray(array(
				'Atomid'      => $entry->id,
				'Title'       => $entry->title,
				'Link'        => $entry->links[0]->href,
				'Description' => $entry->content->text,
				'Published'   => $entry->published
			));
			
			$item->setFeed($feedRecord);
			//print_r($item);
			$item->save();
			
			$newItems++;
		}
		
		return $newItems;
	}
	
	protected function getFeed($feedUrl) {
		if (empty($this->parser)) {
			// TODO: Bring the FeedParser into the lib directory when complete
			require_once('/home/isofarro/projects/php5-feed-parser-and-normaliser/FeedParser.php');
			$this->parser = new FeedParser();
		}
		
		return $this->parser->parse($feedUrl);
	}
}
