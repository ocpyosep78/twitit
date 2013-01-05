<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mobile extends CI_Controller {

	public function index()
	{
		$this->load->view('twitter/mobile/timeline');
	}

	function login()
	{
		redirect('twitter/login/mobile');
	}

	function timeline($max_id)
	{
		$data['max_id'] = $max_id;
		$this->load->view('twitter/mobile/timeline_next', $data);
	}

	function profile($screen_name)
	{
		$data['screen_name'] = $screen_name;
		$this->load->view('twitter/mobile/profile',$data);
	}

	function messages($max_id='')
	{
		$data['max_id'] = $max_id;
		$this->load->view('twitter/mobile/messages',$data);
	}

	function mentions($max_id='')
	{
		$data['max_id'] = $max_id;
		$this->load->view('twitter/mobile/mentions', $data);
	}

	function reply($tweet_id)
	{
		$data['tweet_id'] = $tweet_id;
		$this->load->view('twitter/mobile/reply', $data);
	}

	function reply_message($id)
	{
		$data['message_id'] = $id;
		$this->load->view('twitter/mobile/reply_message', $data);
	}

	function send_message($id)
	{
		$data['to_id'] = $id;
		$this->load->view('twitter/mobile/new_dm', $data);
	}

	function retweet($tweet_id='')
	{
		$data['tweet_id'] = $tweet_id;
		$this->load->view('twitter/mobile/retweet', $data);
	}

	function quote($tweet_id)
	{
		$data['tweet_id'] = $tweet_id;
		$this->load->view('twitter/mobile/quote', $data);
	}

	function follower($cursor)
	{
		$data['cursor'] = $cursor;
		$this->load->view('twitter/mobile/follower', $data);
	}

	function following($cursor)
	{
		$data['cursor'] = $cursor;
		$this->load->view('twitter/mobile/following', $data);
	}

	function post()
	{
		$tweet_id = $this->session->userdata('tweet_id');
		$tweet = $this->input->post('tweet');

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

			$post = $twitteroauth->post('statuses/update', 
					array(
						'status'=> $tweet,
						'in_reply_to_status_id'=> $tweet_id)
					);
		}
		redirect('mobile');
	}

	function dm()
	{
		$dm_to = $this->session->userdata('dm_to');
		$text = $this->input->post('text');

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

			$post = $twitteroauth->post('direct_messages/new', 
					array(
						'text'=> $text,
						'user_id'=> $dm_to)
					);
		}
		redirect('mobile/messages');
	}

}

/* End of file mobile.php */
/* Location: ./application/controllers/mobile.php */
