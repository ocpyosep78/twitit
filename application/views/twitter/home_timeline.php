<?php
//cek apakah user telah sign
$user_sign = $this->session->userdata('user_sign');
$this->session->unset_userdata('tweet_id');
$this->session->unset_userdata('tid');

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
	$home_timeline = $twitteroauth->get('statuses/home_timeline', array('count'=>'25')); 
	$mentions_timeline = $twitteroauth->get('statuses/mentions_timeline', array('count'=>'25')); 
	$direct_messages = $twitteroauth->get('direct_messages');
?>

<!doctype html>
<html>
<head>
	<title>Twitit::Home Timeline</title>
	<base href="<?php echo(base_url()); ?>">
	<link rel="stylesheet" href="assets/stylesheets/foundation.min.css">
	<link rel="stylesheet" href="assets/stylesheets/style.css">
</head>
<body>
	<!-- Basic Needs -->
	<nav class="top-bar" style="position:fixed; z-index:9999;">
		<ul>
			<li class="name"><h1><a href="#">TwITIT <small>beta</small></a></h1></li>
			<li class="toggle-topbar"><a href="#"></a></li>
		</ul>
		<section>
			<ul class="right">
				<li><a href="#"><?php //echo($verify_credentials->name); ?></a></li>
				<li><a href="<?php echo(base_url('twitter/logout')); ?>">Logout</a></li>
			</ul>
		</section>
	</nav>
	<div style="height:50px;"></div>
	<div class="three columns kolom">
		<h3>Timeline</h3>
		<?php foreach ($home_timeline as $timeline): ?>
			<div class="panel">
				<div class="avatar">
					<img src="<?php echo($timeline->user->profile_image_url); ?>" alt="<?php echo($timeline->user->name); ?>">
				</div>
				<div class="name_date">
					<span class="name">
						<a href="<?php echo('http://twitter.com/' . $timeline->user->screen_name); ?>"><?php echo($timeline->user->name); ?></a>
					</span>
					<br>
					<span class="date"><?php echo date("d M Y H:i:s", strtotime($timeline->created_at)); ?></span>
					<br>
					<span class="source"><?php echo($timeline->source); ?></span>
					<hr>
				</div>
				<div class="tweet">
					<?php echo($timeline->text); ?>	
				</div>
				<br><hr>
				<a href="<?php echo(base_url('twitter/reply/'.$timeline->id_str)); ?>">Replies</a>
			</div>
		<?php endforeach; ?>
	</div>
	<div class="three columns kolom">
		<h3>Mentions</h3>
		<?php foreach ($mentions_timeline as $mentions): ?>
			<div class="panel">
				<div class="avatar">
					<img src="<?php echo($mentions->user->profile_image_url); ?>" alt="<?php echo($mentions->user->name); ?>">
				</div>
				<div class="name_date">
					<span class="name">
						<a href="<?php echo('http://twitter.com/' . $mentions->user->screen_name); ?>"><?php echo($mentions->user->name); ?></a>
					</span>
					<br>
					<span class="date"><?php echo date("d M Y H:i:s", strtotime($mentions->created_at)); ?></span>
					<br>
					<span class="source"><?php echo($mentions->source); ?></span>
					<hr>
				</div>
				<div class="tweet">
					<?php echo($mentions->text); ?>	
				</div>
				<br><hr>
				<a href="<?php echo(base_url('twitter/reply/'.$mentions->id_str)); ?>">Replies</a>
			</div>
		<?php endforeach; ?>
	</div>
	<div class="three columns kolom">
		<h3>Direct Messages</h3>
		<?php foreach ($direct_messages as $dm): ?>
			<div class="panel">
				<div class="avatar">
					<img src="<?php echo($dm->sender->profile_image_url); ?>" alt="<?php echo($dm->sender->name); ?>">
				</div>
				<div class="name_date">
					<span class="name">
						<a href="<?php echo('http://twitter.com/' . $dm->sender->screen_name); ?>"><?php echo($dm->sender->name); ?></a>
					</span>
					<br>
					<span class="date"><?php echo date("d M Y H:i:s", strtotime($dm->created_at)); ?></span>
					<hr>
				</div>
				<div class="tweet">
					<?php echo($dm->text); ?>	
				</div>
			</div>
		<?php endforeach; ?>
	</div>
	<div class="three columns" style="position:fixed; z-index:9999; right:0px;">
		<h3>Twitit!</h3>
		<?php echo(form_open('twitter/tweet')); ?>
			<textarea name="tweet" rows="5" placeholder="What's happening?"></textarea>
			<input type="submit" class="right radius small button" value="Twitit">
		<?php echo(form_close()); ?>

		<div id="footer" class="three columns">
			Created by <a href="http://about.me/yusufsyaifudin">Yusuf Syaifudin</a> <br>
			All other copyrights and trademarks herein are the property of their respective owners.
		</div>
	</div>
	
</body>
</html>

<?php
else :
	echo("Anda belum sign!");
endif;

?>