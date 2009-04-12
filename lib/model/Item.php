<?php

class Item extends BaseItem
{
	/**
	 * Returns an extract of the current description, which is:
	 * The first two paragraphs of the description, or the
	 * text up to the first header, whichever is shorter
	 **/
	public function getExtract() {
		$description = $this->getDescription();
		
		$headerPos = strpos($description, '<h');
		
		if ($headerPos !== false) {
			$description = substr($description, 0, $headerPos);
		} else {
			$paraPos = strpos($description, '</p>');
			if ($paraPos !== false) {
				$description = substr($description, 0, $paraPos + 4);
			}
		}
		
		// Check for over-long introductions...
		$paraPos = strpos($description, '<p', 4);
		if($paraPos !== false) {
			$paraEndPos  = strpos($description, '</p>', $paraPos);
			$description = substr($description, 0, $paraEndPos + 4);
		}
		
		return $description;
	}
	
	/**
	 * Returns a cleaned-up twitter message, along with normal
	 * Twitter formatting.
	 **/
	public function getTweet($trimSelf = false) {
		$description = $this->getDescription();

		// Link HTTP Urls
		$description = preg_replace(
			'/(https?:\/\/[^ ]+)/i', 
			'<a href="$1" rel="nofollow">[link]</a>',
			$description
		);

		// Find and process twitterer
		$selfPos = strpos($description, ':');
		if ($selfPos !== false) {
			if ($trimSelf) {
				// Remove self-identifier
				$description = substr($description, $selfPos+1);
			} else { 
				// Link twitterer
				$description = preg_replace(
					'/^([^:]+):/', 
					'<a href="http://twitter.com/$1" rel="nofollow">$1</a>:',
					$description
				);
			}
		}
		
		// Link Twitter usernames		
		$description = preg_replace(
			'/@([a-z0-9-_]+)/i', 
			'<a href="http://twitter.com/$1" rel="nofollow">@$1</a>',
			$description
		);

		
		// Twitter search shortcut
		$description = preg_replace(
			'/#([a-z0-9-_]+)/i', 
			'<a href="http://search.twitter.com/search?q=%23$1" rel="nofollow">#$1</a>',
			$description
		);
		
		return $description;
	}
	
	/**
	 * Extract small thumbnail images from a Flickr description
	 **/
	public function getPhotoImage() {
		$description = $this->getDescription();
		
		if (preg_match('/href="([^"]+)"/', $description, $linkMatches)) {
			$link = $linkMatches[1];
			if (preg_match('/src="([^"]+)"/', $description, $srcMatches)) {
				$src = $srcMatches[1];
				$src = str_replace('_m.jpg', '_s.jpg', $src);
			}
			if (preg_match('/alt="([^"]+)"/', $description, $altMatches)) {
				$alt = $altMatches[1];
			}
			$description = <<<HTML
<a href="{$link}"><img src="{$src}" height="75" width="75" alt="{$alt}" /></a>
HTML;
		}		
		
		return $description;
	}
}
