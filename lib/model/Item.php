<?php

class Item extends BaseItem
{
	/**
	 * Returns an extract of the current description, which is:
	 **/
	public function getExtract() {
		return FormattingUtils::getExtract(
			$this->getDescription()
		);
	}
	
	/**
	 * Returns a cleaned-up twitter message, along with normal
	 * Twitter formatting.
	 **/
	public function getTweet($trimSelf = false) {
		return FormattingUtils::tweetify(
			$this->getDescription(), $trimSelf
		);
	}
	
	/**
	 * Extract small thumbnail images from a Flickr description
	 **/
	public function getPhotoImage() {
		return FormattingUtils::flickrfy(
			$this->getDescription()
		);
	}
}
