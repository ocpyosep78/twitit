<?php
error_reporting(0);

$this->session->unset_userdata('tweet_id');

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

	//show the home timeline of user
	//$verify_credentials = $twitteroauth->get('account/verify_credentials');
	if (!empty($max_id)) {
		$mentions_timeline = $twitteroauth->get('statuses/mentions_timeline', array('count'=>'25', 'max_id' => $max_id));
	}
	else {
		$mentions_timeline = $twitteroauth->get('statuses/mentions_timeline', array('count'=>'25'));
	}
	 
?>

<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Twitit :: Mentions Timeline</title>
	<base href="<?php echo(base_url()); ?>">
	<link rel="stylesheet" href="assets/stylesheets/foundation.min.css">
	<link rel="stylesheet" href="assets/stylesheets/mobile.css">
</head>
<body id="mobile">
	<?php $this->load->view('twitter/mobile/menu'); ?>
	<div class="tweets">
		<?php echo(form_open('mobile/post')); ?>
			<textarea name="tweet"></textarea>
			<input type="submit" value="twitit!" class="small button">
		<?php echo(form_close()); ?>
	</div>
	<?php foreach ($mentions_timeline as $timeline) : ?>
	<div class="tweets">
		<img class="avatar" src="<?php echo($timeline->user->profile_image_url); ?>" alt="<?php echo($timeline->user->screen_name); ?>">
		<div class="username">
			<a href="<?php echo(base_url("mobile/profile/{$timeline->user->screen_name}")); ?>" class="name"><?php echo($timeline->user->name); ?></a>
			<br>
			<a href="<?php echo(base_url("mobile/profile/{$timeline->user->screen_name}")); ?>" class="screen_name"><?php echo('@' . $timeline->user->screen_name); ?></a>
		</div>
		<br>
		<br>
		<br>
		<div class="text">
			<?php echo($timeline->text); ?>
			<br><br>
			<span class="date">
				<?php echo(date("d M Y H:i:s", strtotime($timeline->created_at))); ?>
				<?php echo(' via ' . $timeline->source); ?>
			</span>
		</div>
		<div class="tweet_do">
			<a href="<?php echo(base_url("mobile/reply/{$timeline->id_str}")); ?>">Reply</a>
			<a href="<?php echo(base_url("mobile/quote/{$timeline->id_str}")); ?>">Quote</a>
			<a href="<?php echo(base_url("mobile/send_message/{$timeline->user->id_str}")); ?>">DM</a>
		</div>
	</div>
	<?php endforeach; ?>
	<ul class="pagination">
		<li class="arrow"><a href="<?php echo(base_url("mobile/mentions/{$timeline->id_str}")); ?>">&laquo; previous tweets</a></li>
	</ul>
</body>
</html>

<?php
else :
	echo("Anda belum sign!");
endif;

?>