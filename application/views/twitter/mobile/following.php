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

	//show the tweet want to reply
	//$verify_credentials = $twitteroauth->get('account/verify_credentials');
	$friends = $twitteroauth->get('friends/list', array('cursor'=>$cursor));
?>

<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Twitit :: Following</title>
	<base href="<?php echo(base_url()); ?>">
	<link rel="stylesheet" href="assets/stylesheets/foundation.min.css">
	<link rel="stylesheet" href="assets/stylesheets/mobile.css">
</head>
<body id="mobile">
	<?php $this->load->view('twitter/mobile/menu'); ?>
	<?php foreach ($friends->users as $user) : ?>
	<div class="tweets">
		<img class="avatar" src="<?php echo($user->profile_image_url); ?>" alt="<?php echo($user->screen_name); ?>">
		<div class="username">
			<a href="<?php echo(base_url("mobile/profile/{$user->screen_name}")); ?>" class="name"><?php echo($user->name); ?></a>
			<br>
			<a href="<?php echo(base_url("mobile/profile/{$user->screen_name}")); ?>" class="screen_name"><?php echo('@' . $user->screen_name); ?></a>
		</div>
		<br>
		<br>
		<br>
		<div class="text">
			<?php echo($user->description); ?>
			<br><br>
			<span class="date">
				<?php echo('Created at ' . date("d M Y H:i:s", strtotime($user->created_at))); ?>
				<br>
				<?php echo($user->location); ?>
			</span>
			<br><br>
			<code><?php echo($user->url); ?></code>
		</div>
		<div class="tweet_do">
			<dl class="sub-nav">
				<dd class="active"><a href="#">followers <?php echo($user->followers_count); ?></a></dd>
				<dd class="active"><a href="#">following <?php echo($user->friends_count); ?></a></dd>
			</dl>
			
		</div>
	</div>
	<?php endforeach; ?>
	<ul class="pagination">
		<?php if ($friends->previous_cursor_str==0) : ?>
			<li class="unavailable arrow"><a href="<?php echo(base_url("mobile/following/{$friends->previous_cursor_str}")); ?>">&laquo; prev</a></li>
		<?php else : ?>
		<li class="arrow"><a href="<?php echo(base_url("mobile/following/{$friends->previous_cursor_str}")); ?>">&laquo; prev</a></li>
		<?php endif; ?>
		<li class="arrow"><a href="<?php echo(base_url("mobile/following/{$friends->next_cursor_str}")); ?>">next &raquo;</a></li>
	</ul>
</body>
</html>

<?php
else :
	echo("Anda belum sign!");
endif;

?>