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
		$itemCriteria->addJoin(self::FEED_ID, SitefeedPeer::FEED_ID);
		$itemCriteria->add(SitefeedPeer::SITE_ID,	$site_id, Criteria::IN);

		// order by published date Descending
		$itemCriteria->addDescendingOrderByColumn(self::PUBLISHED);
		
		$items = self::doSelect($itemCriteria);
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
		
		return $sortedItems;
	}
	
}
