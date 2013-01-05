<ul class="breadcrumbs">
	<?php $screen_name = $this->session->userdata('screen_name'); ?>
	<li><a href="<?php echo(base_url("mobile/profile/{$screen_name}")); ?>">Profile</a></li>
	<li><a href="<?php echo(base_url('mobile/index')); ?>">Home</a></li>
	<li><a href="<?php echo(base_url('mobile/mentions')); ?>">Mentions</a></li>
	<li><a href="<?php echo(base_url('mobile/follower/-1')); ?>">Follower</a></li>
	<li><a href="<?php echo(base_url('mobile/following/-1')); ?>">Following</a></li>
	<li><a href="<?php echo(base_url('mobile/messages')); ?>">Messages</a></li>
	<li><a href="<?php echo(base_url('twitter/logout/mobile')); ?>">Logout</a></li>
	<li><a href="https://github.com/yusyaif/">About</a></li>
</ul>