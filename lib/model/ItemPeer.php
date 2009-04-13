<?php

class ItemPeer extends BaseItemPeer {

	/**
	* Gets all the items for a given site
	* @param $site_id - the id of the site
	* @return $items - an array of items for that site
	**/
	public static function getSiteFeedItems($site_id) {
		$itemCriteria = new Criteria();
		
		// Get items belonging to a site feed
		$itemCriteria->addJoin(
			self::FEED_ID, 
			SitefeedPeer::FEED_ID, 
			Criteria::LEFT_JOIN
		);
		$itemCriteria->add(SitefeedPeer::SITE_ID,	$site_id, Criteria::IN);

		// order by published date Descending
		$itemCriteria->addDescendingOrderByColumn(self::PUBLISHED);
		
		// Bring in the item data plus the feed data for each item.
		$items = self::doSelectJoinFeed($itemCriteria);
		return $items;
	}
	
	/**
	 * Gets all the items for a site separated into collections
	 * @param $site_id - the id of the site
	 * @return collection - a collection hash, keyed by collection name
	 *			each value is an array of items 
	 **/
	public static function getCollectedFeedItems($site_id) {
		// Get the feed collections map for a site
		$collections = SitefeedPeer::getSiteFeedCollections($site_id);
		
		// Get all the items for the site
		$items       = self::getSiteFeedItems($site_id);
		
		$sortedItems = array();		
		
		// Sort the items into their categories
		foreach($items as $item) {
			$feedid = $item->getFeedId();
			$collection = $collections[$feedid];
			
			if (empty($sortedItems[$collection])) {
				$sortedItems[$collection] = array();
			}
			
			array_push($sortedItems[$collection], $item);
		}
		
		// Reduce the number of collection items
		$defaultMax = sfConfig::get('app_max_default');
		foreach($sortedItems as $key=>$collection) {
			$max = sfConfig::get('app_max_' . $key, $defaultMax);
			$sortedItems[$key] = 
				array_slice($collection, 0, $max);
		}
		
		return $sortedItems;
	}

	/**
	* Gets the latest blog post.
	* @param $site_id - the id of the site
	* @param $type (Optional) - the type of post, defaults to blog
	* @return $post - the latest blog post
	**/
	public static function getLatestSiteItem($site_id, $type='blog') {
		$itemCriteria = new Criteria();
		
		// Get an item belonging to the site feed
		$itemCriteria->addJoin(
			self::FEED_ID, 
			SitefeedPeer::FEED_ID, 
			Criteria::LEFT_JOIN
		);
		$itemCriteria->add(SitefeedPeer::SITE_ID,	$site_id, Criteria::IN);
		
		$itemCriteria->add(SitefeedPeer::COLLECTION, $type, Criteria::EQUAL);

		// order by published date Descending
		$itemCriteria->addDescendingOrderByColumn(self::PUBLISHED);
		
		// Bring in the item data plus the feed data for each item.
		return self::doSelectOne($itemCriteria);
		return $items;
	}
	
	
}
