<?php
//include kan class twitter api
include_once(APPPATH.'libraries/twitteroauth/twitteroauth.php');
include_once(APPPATH.'libraries/twitteroauth/twitterapi-config.php');

$oauth_token = $this->session->userdata('oauth_token');
$oauth_token_secret = $this->session->userdata('oauth_token_secret');
if(!empty($_GET['oauth_verifier']) && !empty($oauth_token) && !empty($oauth_token_secret))
{
    //TwitterOAuth instance, with two new parameters we got in twitter_login.php
    $twitteroauth = new TwitterOAuth($consumer_key, $consumer_secret, $oauth_token, $oauth_token_secret);

    // Let's request the access token
    $access_token = $twitteroauth->getAccessToken($_GET['oauth_verifier']); 

    //menyimpan access token dan access token secret ke dalam session
    $this->session->set_userdata('access_token',$access_token['oauth_token']);
    $this->session->set_userdata('access_token_secret',$access_token['oauth_token_secret']);
    $this->session->set_userdata('screen_name', $access_token['screen_name']);

    //membuat key untuk memastikan user telah sign atau belum
    $this->session->set_userdata('user_sign', TRUE);

    redirect($redirect);
} else {  
    // Something's missing, go back to square 1  
    redirect('twitter/login');
}
?>