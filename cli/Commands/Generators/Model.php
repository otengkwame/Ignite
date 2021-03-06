<?php
namespace CLI\Commands\Generators;

use CLI\Core\Generator;

/**
 * Generator\Model Command
 *
 * @package     CLI
 * @author      David Sosa Valdes
 * @link        https://github.com/davidsosavaldes/CLI
 * @copyright   Copyright (c) 2016, David Sosa Valdes.
 */
class Model extends Generator implements \CLI\Interfaces\Command
{
	protected $name        	= 'generate:model';
	protected $description 	= 'Generate a Model';
	protected $aliases 		= ['g:model'];

	public function start()
	{
    	$filename = ucfirst($this->getArgument('filename'));
    	$basepath = rtrim($this->getOption('path'),'/');
		$appdir   = basename($basepath);
		
		$basepath.= '/models/';

		$this->text("Controller path: <comment>{$appdir}/models</comment>");
		$this->text('Filename: <comment>'.$filename.'_model.php</comment>');

        // Confirm the action
	    if($this->confirm('Do you want to create a '.$filename.' Model?', TRUE))
	    {
			// We could try to create a directory if doesn't exist.
			(! $this->_filesystem->exists($basepath)) && $this->_filesystem->mkdir($basepath);

	    	$test_file = $basepath.$filename.'_model.php';

	    	$options = array(
	    		'NAME' 		 => $filename.'_model',
	    		'COLLECTION' => $filename,
	    		'FILENAME'   => basename($test_file),
	    		'PATH'       => "./{$appdir}/models"
	    	);

	    	if ($this->make($test_file, 'models/base.php.twig', $options))
	    	{
	    		$this->success('Model created successfully!');
	    	}
	    }
	    else
	    {
	    	$this->warning('Process aborted!');
	    }
	}

}
