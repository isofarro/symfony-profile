<?php

/**
 * content actions.
 *
 * @package    profile
 * @subpackage content
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class contentActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
	public function executeIndex(sfWebRequest $request) {
		// TODO: Check for the feed filter cookie
		
		// Get all the entries for this site, sorted into collections
		$this->entries = ItemPeer::getCollectedFeedItems(
			sfConfig::get('app_default_site')
		);
	}
}
