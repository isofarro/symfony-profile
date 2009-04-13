<?php

require_once dirname(__FILE__).'/../bootstrap/unit.php';
 
$t = new lime_test(7, new lime_output_color());


// Test the tweetify

$t->is(
	FormattingUtils::tweetify("anon_tweet: Hello!"), 
	'<a href="http://twitter.com/anon_tweet" rel="nofollow">anon_tweet</a>: Hello!'
);

$t->is(
	FormattingUtils::tweetify("anon_tweet: Hello!", true), 
	'Hello!'
);

$t->is(
	FormattingUtils::tweetify("anon_tweet: http://example.com/", true), 
	'<a href="http://example.com/" rel="nofollow">[link]</a>'
);

$t->is(
	FormattingUtils::tweetify("anon_tweet: Hello @isofarro_public!", true), 
	'Hello <a href="http://twitter.com/isofarro_public" rel="nofollow">@isofarro_public</a>!'
);

$t->is(
	FormattingUtils::tweetify("anon_tweet: Hello #g20!", true), 
	'Hello <a href="http://search.twitter.com/search?q=%23g20" rel="nofollow">#g20</a>!'
);

$t->is(
	FormattingUtils::tweetify("anon_tweet: Hello #g20! and #g21.", true), 
	'Hello <a href="http://search.twitter.com/search?q=%23g20" rel="nofollow">#g20</a>! and <a href="http://search.twitter.com/search?q=%23g21" rel="nofollow">#g21</a>.'
);


$t->is(
	FormattingUtils::tweetify("anon_tweet: (http://example.com/)", true), 
	'(<a href="http://example.com/" rel="nofollow">[link]</a>)'
);



