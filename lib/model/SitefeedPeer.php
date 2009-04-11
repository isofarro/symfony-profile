<?php

class SitefeedPeer extends BaseSitefeedPeer {

	public static function getSiteFeeds($site_id) {
		$sitefeedCriteria = new Criteria();
		$sitefeedCriteria->add(
			SitefeedPeer::SITE_ID,
			$site_id,
			Criteria::EQUAL
		);
	
		return SitefeedPeer::doSelect($sitefeedCriteria);
	}
	
	public static function getSiteFeedCollections($site_id) {
		$feeds = SitefeedPeer::getSiteFeeds($site_id);
		
		$collections = array();
		foreach($feeds as $feed) {
			$collections[$feed->getFeedId()] = $feed->getCollection();
		}
		return $collections;	
	}

}
