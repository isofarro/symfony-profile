<?php

class SitefeedPeer extends BaseSitefeedPeer {

	/**
	* Get all the feeds for the specified site
	* @param $site_id - the id of the site
	* @return $feeds - an array of feeds that makes up the site
	**/
	public static function getSiteFeeds($site_id) {
		$sitefeedCriteria = new Criteria();
		$sitefeedCriteria->add(self::SITE_ID, $site_id, Criteria::EQUAL);
		return self::doSelect($sitefeedCriteria);
	}
	
	/**
	* Get a hash of site collections, keyed by feed id
	* @param $site_id - the id of the site
	* @return $collections - a feed collection map, keyed by feed id.
	**/
	public static function getSiteFeedCollections($site_id) {
		$feeds = self::getSiteFeeds($site_id);
		
		$collections = array();
		foreach($feeds as $feed) {
			$collections[$feed->getFeedId()] = $feed->getCollection();
		}
		return $collections;	
	}

}
