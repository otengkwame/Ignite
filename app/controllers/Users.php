<?php defined('BASEPATH') OR exit('No direct script access allowed');

use Symfony\Component\Console\Command\Command as SymfonyCommand;

class Users extends CI_Controller{
    public function index()
    {
	    $this->load->view('welcome_message');
	}
}