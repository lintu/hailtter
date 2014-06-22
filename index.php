<?php
error_reporting(0);
session_start();
require_once('twitteroauth/twitteroauth.php');
require_once('config.php');

$access_token = $_SESSION['access_token'];
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
$content = $connection->get('account/verify_credentials');
echo 'Hi '. $content->screen_name. '<br>';
$followers = $connection->get('https://api.twitter.com/1.1/followers/ids.json', array('user_id' => $content->id));
$follower_array = ($followers->ids);
	
 foreach($follower_array as $follower) {
	$userTimeline = $connection->get('https://api.twitter.com/1.1/statuses/user_timeline.json',  array('user_id'=> $follower));
	if(is_array($userTimeline))
	{
		try{	
			if($userTimeline[0]) {
				echo 'At '. $userTimeline[0]->created_at . ', '. $userTimeline[0]->user->screen_name. " said " . $userTimeline[0]->text;
				echo '<br>';
			}
		} catch(Exception $ex) {
		}
	}
} 
?>
