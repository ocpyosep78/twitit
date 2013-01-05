<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Twitter extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->load->view('twitter/index');
	}

	function login($where)
	{
		if ($where=="mobile") 
		{
			$data['redirect'] = "mobile";
		}
		else 
		{
			$data['redirect'] = "web";
		}
		$this->load->view('twitter/login', $data);
	}

	function callback($redirect)
	{
		$data['redirect'] = $redirect;
		$this->load->view('twitter/callback', $data);
	}

	function tweet()
	{
		$data['tweet'] = $this->input->post('tweet');
		$this->load->view('twitter/post', $data);
	}

	function reply($tweet_id)
	{
		$data['tweet_id'] = $tweet_id;
		$this->load->view('twitter/reply', $data);
	}

	function retweet($tweet_id)
	{
		$data['tweet_id'] = $tweet_id;
		$this->load->view('twitter/retweet');
	}

	function follower()
	{

	}

	function following()
	{

	}

	function logout($redirect)
	{
		$this->session->sess_destroy();
		redirect($redirect);
	}

}

/* End of file twitter.php */
/* Location: ./application/controllers/twitter.php */
