<?php
//include kan class twitter api
include_once(APPPATH.'libraries/twitteroauth/twitteroauth.php');
include_once(APPPATH.'libraries/twitteroauth/twitterapi-config.php');

//buat objek untuk twitteroauth
$twitteroauth = new TwitterOAuth($consumer_key, $consumer_secret);

//halaman callback untuk handle response dr twitter
$request_token = $twitteroauth->getRequestToken(base_url("twitter/callback/$redirect"));

//simpan sementara data request token pada session
$this->session->set_userdata("oauth_token",$request_token['oauth_token']);
$this->session->set_userdata("oauth_token_secret",$request_token['oauth_token_secret']);

// If everything goes well..
if($twitteroauth->http_code==200)
{
	// Let's generate the URL and redirect
	$url = $twitteroauth->getAuthorizeURL($request_token['oauth_token']);
	header('Location: '. $url);
}
else
{
	// It's a bad idea to kill the script, but we've got to know when there's an error.
	die('Something wrong happened.');
}
?>