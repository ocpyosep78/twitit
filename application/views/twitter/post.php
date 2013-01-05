<?php
//cek apakah user telah sign
$user_sign = $this->session->userdata('user_sign');

if ($user_sign!=FALSE)
{
	date_default_timezone_set('Asia/Jakarta');

	//include kan class twitter api
	include_once(APPPATH.'libraries/twitteroauth/twitteroauth.php');
	include_once(APPPATH.'libraries/twitteroauth/twitterapi-config.php');

	$oauth_token = $this->session->userdata('oauth_token');
	$oauth_token_secret = $this->session->userdata('oauth_token_secret');
	$access_token = $this->session->userdata('access_token');
	$access_token_secret = $this->session->userdata('access_token_secret');

	//TwitterOAuth instance, with two new parameters we got in twitter_login.php
	$twitteroauth = new TwitterOAuth($consumer_key, $consumer_secret, $oauth_token, $oauth_token_secret);

	// Let's request the access token
	$twitteroauth->getAccessToken('',$access_token,$access_token_secret);

	//post status and redirect
	if ($tweet!='' && $this->session->userdata('tid')!=FALSE) 
	{
		$post = $twitteroauth->post('statuses/update', 
			array(
				'status'=> $tweet,
				'id'=>$this->session->userdata('tweet_id')
			)
		);
		$this->session->unset_userdata('tweet_id');
		$this->session->unset_userdata('tid');
	}
	else if ($tweet_id!='' && $this->session->userdata('tid')==FALSE)
	{
		$post = $twitteroauth->post('statuses/update', 
			array(
				'status'=> $tweet,
			)
		);

	}
	redirect('twitter/home_timeline');
}
else 
{
	echo("Anda belum sign!");
}
?>