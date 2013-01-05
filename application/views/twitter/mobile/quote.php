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
	$status = $twitteroauth->get('statuses/show', array('id'=> $tweet_id));
?>

<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Twitit :: Quote</title>
	<base href="<?php echo(base_url()); ?>">
	<link rel="stylesheet" href="assets/stylesheets/foundation.min.css">
	<link rel="stylesheet" href="assets/stylesheets/mobile.css">
</head>
<body id="mobile">
	<?php $this->load->view('twitter/mobile/menu'); ?>
	<?php if ($tweet_id != $status->id_str) : ?>
	<div class="tweets">
		Sorry, that page does not exist or tweet you want to reply may have been deleted by its owner.
	</div>
	<?php else: ?>
	<div class="tweets">	
		<img class="avatar" src="<?php echo($status->user->profile_image_url); ?>" alt="<?php echo($status->user->screen_name); ?>">
		<div class="username">
			<a href="#" class="name"><?php echo($status->user->name); ?></a>
			<br>
			<a href="#" class="screen_name"><?php echo('@' . $status->user->screen_name); ?></a>
		</div>
		<br>
		<br>
		<br>
		<div class="text">
			<?php echo($status->text); ?>
			<br><br>
			<span class="date">
				<?php if ($status->retweeted==1) : ?>
					You retweeted this tweet
					<br>
				<?php endif; ?>
				<?php echo('retweeted ' . $status->retweet_count.'x'); ?>
				<br>
				<?php echo(date("d M Y H:i:s", strtotime($status->created_at))); ?>
			</span>
		</div>
		<br>
		<?php $this->session->set_userdata('tweet_id', $tweet_id); ?>
		<?php echo(form_open('mobile/post')); ?>
			<textarea name="tweet"><?php echo('RT @' . $status->user->screen_name . ' ' . $status->text); ?></textarea>
			<input type="submit" value="Quote" class="small button">
		<?php echo(form_close()); ?>
	</div>
	<?php endif; ?>
</body>
</html>

<?php
else :
	echo("Anda belum sign!");
endif;

?>