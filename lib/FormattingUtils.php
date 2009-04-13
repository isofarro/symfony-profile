<?php

class FormattingUtils {

	/**
	* Create an extract from a long blog post
	* The first two paragraphs of the description, or the
	* text up to the first header, whichever is shorter.
	*
	* @param $post - the HTML markedup post
	* @returns The extract in HTML format
	**/
	static public function getExtract($post) {
		// Find the first header
		$headerPos = strpos($post, '<h');
		
		if ($headerPos !== false) {
			$post = substr($post, 0, $headerPos);
		} else {
			// If no headers, grab just the first paragraph
			$paraPos = strpos($post, '</p>');
			if ($paraPos !== false) {
				$post = substr($post, 0, $paraPos + 4);
			}
		}
		
		// Check for over-long introductions...
		$paraPos = strpos($post, '<p', 4);
		if($paraPos !== false) {
			$paraEndPos  = strpos($post, '</p>', $paraPos);
			$post        = substr($post, 0, $paraEndPos + 4);
		}
		
		return $post;
	}

	/**
	 * Formats a message using Twitter rules, so @usernames and #searches 
	 * are linked.
	 *
	 * @param $post - the raw text of the post
	 * @param $trimSelf - boolean whether to remove the username or not
	 *
	 * @returns HTML string formatted like Twitter messages
	 **/
	static public function tweetify($post, $trimSelf=false) {

		// Link HTTP Urls
		$post = preg_replace(
			'/(https?:\/\/[^ ]+)/i', 
			'<a href="$1" rel="nofollow">[link]</a>',
			$post
		);

		// Find twitterer and either link or remove
		$selfPos = strpos($post, ':');
		if ($selfPos !== false) {
			if ($trimSelf) {
				// Remove self-identifier
				$post = substr($post, $selfPos+1);
			} else { 
				// Link twitterer
				$post = preg_replace(
					'/^([^:]+):/', 
					'<a href="http://twitter.com/$1" rel="nofollow">$1</a>:',
					$post
				);
			}
		}
		
		// Link Twitter @usernames		
		$post = preg_replace(
			'/@([a-z0-9-_]+)/i', 
			'<a href="http://twitter.com/$1" rel="nofollow">@$1</a>',
			$post
		);

		
		// Link Twitter #search
		$post = preg_replace(
			'/#([a-z0-9-_]+)/i', 
			'<a href="http://search.twitter.com/search?q=%23$1" rel="nofollow">#$1</a>',
			$post
		);
		
		return $post;
	}
	
	/**
	* Takes a raw Flickr post content and returns a more
	* tightly formatted markup
	*
	* @param $post the content as per Flickr
	*
	* @returns HTML formatted string applicable to a photo gallery
	**/
	static public function flickrfy($post) {
		if (preg_match('/href="([^"]+)" title=/', $post, $linkMatches)) {
			$link = $linkMatches[1];
			if (preg_match('/src="([^"]+)"/', $post, $srcMatches)) {
				$src = $srcMatches[1];
				$src = str_replace('_m.jpg', '_s.jpg', $src);
			}
			if (preg_match('/alt="([^"]+)"/', $post, $altMatches)) {
				$alt = $altMatches[1];
			}
			$post = <<<HTML
<a href="{$link}"><img src="{$src}" height="75" width="75" alt="{$alt}" /></a>
HTML;
		}
		return $post;
	}

}
