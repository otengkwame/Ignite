<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 */
class Build extends CI_Controller
{
	/**
	 * Display a listing of the resource.
	 * GET /build
	 */
	public function index()
	{
		echo "Let's build something great :) <br>";
		echo STORAGEPATH;
		//log_message('info', 'index page opened');
	}

}

/* End of file Build.php */
/* Location: ./app/controllers/Build.php */
