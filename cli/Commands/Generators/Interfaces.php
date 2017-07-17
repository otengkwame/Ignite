<?php
namespace CLI\Commands\Generators;

use CLI\Core\Generator;

/**
 * Generator\Interface Command
 *
 * @package     CLI
 * @author      Oteng Kwame Appiah Nti
 * @link        https://github.com/otengkwame/CLI
 * @copyright   Copyright (c) 2017, DOteng Kwame Appiah Nti.
 */
class Interfaces extends Generator implements \CLI\Interfaces\Command
{
	protected $name 		= 'fire:interface';
	protected $description 	= 'Generate an Interface';
	protected $aliases 		= ['f:i'];

	public function start()
	{
    	$filename = ucfirst($this->getArgument('filename'));
		$basepath = rtrim(preg_replace('/Interfaces/', '', $this->getOption('path')),'/');
		$appdir   = basename($basepath);

		$interfacesPath = $basepath.'/Interfaces';

		$this->text("Interface path: <comment>{$appdir}/interfaces</comment>");
		$this->text("Filename: <comment>{$filename}.php</comment>");

    	// Confirm the action
	  	if($this->confirm("Do you want to create a {$filename} Interface?", TRUE))
	  	{
			$interfaceFile = "{$interfacesPath}/{$filename}.php";

			// We could try to create a directory if doesn't exist.
			(! $this->_filesystem->exists($interfacesPath)) && $this->_filesystem->mkdir($interfacesPath);

		    $options = array(
		    	'NAME'       => $filename,
		    	'COLLECTION' => strtolower($filename),
		    	'FILENAME'   => basename($interfaceFile),
		    	'PATH'       => "./{$appdir}/Interfaces"
		    );

	    	$this->comment('Interface');

	    	if ($this->make($interfaceFile, 'interfaces/base.php.twig', $options))
	    	{
	    		$this->text("<info>create</info> {$appdir}/Interfaces/".basename($interfaceFile));
	    	}
	  	}
	  	else
	  	{
	    	$this->warning('Process aborted!');
	  	}
	}
}
