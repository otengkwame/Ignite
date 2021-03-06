<?php
namespace CLI\Database;

use CLI\Core\Codeigniter;

/**
 * Base Seeder Class
 *
 * @package     CLI
 * @author      David Sosa Valdes
 * @link        https://github.com/davidsosavaldes/CLI
 * @copyright   Copyright (c) 2016, David Sosa Valdes.
 * @version     1.0.0
 */
abstract class Seeder
{
	/**
	 * @var \CI_Controller
	 */
	private $CI;

	/**
	 * @var \CI_DB
	 */
	protected $db;

	/**
	 * @var \CI_DB_Forge
	 */
	protected $dbforge;

	/**
	 * Force Extending class to define this method
	 * @return void
	 */
	abstract public function run();

	/**
	 * Class Constructor
	 */
	public function __construct()
	{
		$instance = new Codeigniter();

		$this->CI =& $instance->get();
		$this->CI->load->database();
		$this->CI->load->dbforge();

		$this->db = $this->CI->db;
		$this->dbforge = $this->CI->dbforge;
	}

	/**
	 * Get CI properties
	 * @param  string $property Property name
	 * @return object           CI property (e.g. Model, Library, Config, etc...)
	 */
	public function __get($property)
	{
		return $this->CI->{$property};
	}
}
