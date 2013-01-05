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

	//get statuses
	$status = $twitteroauth->get('statuses/show', array('id'=> $tweet_id));
	$this->session->set_userdata("tweet_id", $tweet_id);
	$this->session->set_userdata("tid", TRUE);
?>

<!doctype html>
<html>
<head>
	<title>Twitit::Reply</title>
	<base href="<?php echo(base_url()); ?>">
	<link rel="stylesheet" href="assets/stylesheets/foundation.min.css">
	<link rel="stylesheet" href="assets/stylesheets/style.css">
</head>
<body>
	<div class="row">
		<div class="panel">
			<div class="avatar">
				<img src="<?php echo($status->user->profile_image_url); ?>" alt="<?php echo($status->user->name); ?>">
			</div>
				<div class="name_date">
					<span class="name">
						<a href="<?php echo('http://twitter.com/' . $status->user->name); ?>"><?php echo($status->user->name); ?></a>
					</span>
					<br>
					<span class="date"><?php echo date("d M Y H:m:i", strtotime($status->created_at)); ?></span>
					<br>
					<span class="source"><?php echo($status->source); ?></span>
					<hr>
				</div>
				<div class="tweet">
					<?php echo($status->text); ?>	
				</div>
				<br><hr>
			<div class="panel">
				<?php echo(form_open('twitter/tweet')); ?>
					<textarea name="tweet" rows="5"><?php echo('@' . $status->user->screen_name . ' '); ?></textarea>
					<input type="submit" value="Reply" class="medium radius button">
				<?php echo(form_close()); ?>
			</div>
		</div>
	</div>
</body>
</html>

<?php
}
else 
{
	echo("Anda belum sign!");
}
?>