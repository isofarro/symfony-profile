<?php

class ItemPeer extends BaseItemPeer {

	public static function getSiteFeedItems($site_id) {
		$itemCriteria = new Criteria();
		
		// TODO: filter to items belonging to a site feed
		// TODO: order by published date Descending
		
		$items = ItemPeer::doSelect($itemCriteria);
		return $items;
	}
	
	/**
	 * Gets all the items for a site broken down into collections
	 * @param $site_id - the id of the site
	 * @return collection - a collection hash, keyed by collection name
	 *			each value is an array of items 
	 **/
	public static function getCollectedFeedItems($site_id) {
		// Get the collections map, keyed by feed id
		$collections = SitefeedPeer::getSiteFeedCollections($site_id);
		
		// Get all the items for the site
		$items       = ItemPeer::getSiteFeedItems($site_id);
		
		$sortedItems = array();		
		
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
