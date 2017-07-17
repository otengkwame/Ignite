<?php
namespace CLI\Core;

use CLI\Core\Command;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

/**
 * Base KeyEncryptor Class
 *
 * @package     CLI
 * @author      Oteng Kwame Appiah Nti
 * @link        https://github.com/davidsosavaldes/CLI
 * @copyright   Copyright (c) 2016, David Sosa Valdes.
 * @version     1.0.0
 */
abstract class KeyEncryptor extends Command
{
	/**
	 * @var \Filesystem
	 */
	protected $_filesystem;

	/**
   * Class constructor
   */
	public function __construct()
	{
		parent::__construct();
		$this->_filesystem = new Filesystem();
	}

	/**
   * Command configuration method.
   * Configure all the arguments and options.
   */
	protected function configure()
	{
		parent::configure();
		$this
		->addArgument(
			'string',
			InputOption::VALUE_REQUIRED,
			'String to be encrypted'
		)
		->addArgument(
			'filename',
			InputOption::VALUE_REQUIRED,
			'Set filename to replace file in',
			realpath(getenv('CI_APPPATH') . '/config/' . 'config.php')
		)
		->addOption(
			'force',
			NULL,
			InputOption::VALUE_NONE,
			'If set, the task will force the generation process'
		);
	}

	protected function searchFiles($path, $file)
	{
		$dir = new \RecursiveDirectoryIterator($path);
		$ite = new \RecursiveIteratorIterator($dir);
		$files = array();
		foreach($ite as $oFile)
		{   
			if($oFile->getFilename()=='config.php')
			{
				$found = str_replace('\\', '/', $oFile->getPath().'/'.$file);
				$files[] = $found;
			}
		}
		return $files;
	}

	/**
	 * Write File
	 *
	 * Writes data to the file specified in the path.
	 * Creates a new file if non-existent.
	 *
	 * @param	string	$path	File path
	 * @param	string	$data	Data to write
	 * @param	string	$mode	fopen() mode (default: 'wb')
	 * @return	bool
	 */
	protected function writeFile($path, $data, $mode = 'wb')
	{
		if ( ! $fp = @fopen($path, $mode))
		{
			return FALSE;
		}
		flock($fp, LOCK_EX);
		for ($result = $written = 0, $length = strlen($data); $written < $length; $written += $result)
		{
			if (($result = fwrite($fp, substr($data, $written))) === FALSE)
			{
				break;
			}
		}
		flock($fp, LOCK_UN);
		fclose($fp);
		return is_int($result);
	}
}
