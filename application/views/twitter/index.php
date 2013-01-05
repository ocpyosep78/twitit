<!doctype html>
<html>
<head>
	<title>Login to twitter</title>
</head>
<body>
<?php
//cek apakah user telah sign
$user_sign = $this->session->userdata('user_sign');

if ($user_sign==FALSE)
{?>
	<a href="<?php echo(base_url('twitter/login')); ?>">Login to twitter</a>
<?php
}
else
{
	redirect('twitter/home_timeline');
}
?>
</body>
</html>