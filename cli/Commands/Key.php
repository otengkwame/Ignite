<?php
namespace CLI\Commands;

use CLI\Core\KeyEncryptor;

/**
 * Generator\Key Command
 *
 * @package     CLI
 * @author      Oteng Kwame Appiah Nti
 * @link        https://github.com/otengkwame/CLI
 * @copyright   Copyright (c) 2017, DOteng Kwame Appiah Nti.
 */
class Key extends KeyEncryptor implements \CLI\Interfaces\Command
{
	protected $name 		= 'fire:key';
	protected $description 	= 'Generate an encryption key for your application';
	protected $aliases 		= ['f:key'];

	public function start()
	{
		$string = $this->getArgument('string');
		$filename = $this->getArgument('filename');
		$basepath = realpath(getenv('CI_APPPATH'));
		//$basepath = rtrim(preg_replace('/config/', '', $this->getOption('path')),'/');
		$appdir   = basename($basepath);

		if(is_null($string))
		{
			$string = microtime();
		}

		$key = hash('ripemd128', $string);

		$files = $this->searchFiles($basepath.'/config/','config.php');

		//var_dump($files);

		

		// Confirm the action
		if($this->confirm("Do you want to set encryption key?", TRUE))
		{
            //die('Died');
			if(!empty($files))
			{
				$search = '$config[\'encryption_key\'] = \'\';';
				$replace = '$config[\'encryption_key\'] = \''.$key.'\';';
				foreach($files as $file)
				{
					$file = trim($file);
					// is weird, but it seems that the file cannot be found unless I do some trimming
					$f = file_get_contents($file);
					if(strpos($f, $search)!==FALSE)
					{
						$f = str_replace($search, $replace, $f);
						if($this->writeFile($file,$f))
						{
                            $this->text('Encryption key '.$key.' added to '.$file);
                            $this->newLine();
						}
						else
						{
                            $this->text('Couldn\'t write encryption key '.$key.' to '.$file);
                            $this->newLine();
						}
					}
					else 
                    {
                         $this->text('Couldn\'t find encryption_key or encryption_key already exists in '.$file);
                         $this->newLine();
                    }
				}
			} 
            else 
            {
                 $this->text('Couldn\'t wfind config.php');
                 $this->newLine();
			}
		}
		else
		{
			$this->warning('Process aborted!');
		}
	}

}

