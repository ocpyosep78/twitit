<?php
error_reporting(0);

//cek apakah user telah sign
$user_sign = $this->session->userdata('user_sign');

if ($user_sign!=FALSE):
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

	//show the tweet want to reply
	//$verify_credentials = $twitteroauth->get('account/verify_credentials');
	$direct_message = $twitteroauth->get('direct_messages/show', array('id'=> $message_id));
?>

<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Twitit :: Reply Message</title>
	<base href="<?php echo(base_url()); ?>">
	<link rel="stylesheet" href="assets/stylesheets/foundation.min.css">
	<link rel="stylesheet" href="assets/stylesheets/mobile.css">
</head>
<body id="mobile">
	<?php $this->load->view('twitter/mobile/menu'); ?>
	<div class="tweets">	
		<img class="avatar" src="<?php echo($direct_message->sender->profile_image_url); ?>" alt="<?php echo($direct_message->sender->screen_name); ?>">
		<div class="username">
			<a href="#" class="name"><?php echo($direct_message->sender->name); ?></a>
			<br>
			<a href="#" class="screen_name"><?php echo('@' . $direct_message->sender->screen_name); ?></a>
		</div>
		<br>
		<br>
		<br>
		<div class="text">
			<?php echo($direct_message->text); ?>
			<br><br>
			<span class="date">
				<?php echo(date("d M Y H:i:s", strtotime($direct_message->created_at))); ?>
			</span>
		</div>
		<br>
		<?php $this->session->set_userdata('dm_to', $direct_message->sender_id); ?>
		<?php echo(form_open('mobile/dm')); ?>
			<textarea name="text"></textarea>
			<input type="submit" value="Reply" class="small button">
		<?php echo(form_close()); ?>
	</div>
</body>
</html>

<?php
else :
	echo("Anda belum sign!");
endif;

?>