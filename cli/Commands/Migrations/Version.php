<?php
namespace CLI\Commands\Migrations;

use CLI\Core\Migration;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Migration\Version Command
 *
 * @package     CLI
 * @author      David Sosa Valdes
 * @link        https://github.com/davidsosavaldes/CLI
 * @copyright   Copyright (c) 2016, David Sosa Valdes.
 */
class Version extends Migration implements \CLI\Interfaces\Command
{
	protected $name        	= 'migrate:version';
	protected $description 	= 'Run a specific migration';
	protected $aliases 		= ['m:version'];

	protected function configure()
	{
		parent::configure();
		$this
			->addArgument(
				'version',
				InputArgument::REQUIRED,
				'The version name'
			);
	}

	public function start()
	{
		$version    = abs($this->getArgument('version'));
		$db_version = intval($this->migration->get_db_version());

		if($version == $db_version)
		{
			return $this->note('Database is up-to-date');
		}
		elseif ($version > $db_version)
		{
			$this->text('Migrating database <info>UP</info> to version '
				.'<comment>'.$version.'</comment> from <comment>'.$db_version.'</comment>');
			$case = 'migrating';
			$signal = '++';
		}
		else
		{
			$this->text('Migrating database <info>DOWN</info> to version '
				.'<comment>'.$version.'</comment> from <comment>'.$db_version.'</comment>');
			$case = 'reverting';
			$signal = '--';
		}

		$this->newLine();
		$this->text('<info>'.$signal.'</info> '.$case);

		$time_start = microtime(true);

		$this->migration->version($version);

		$time_end = microtime(true);

		list($query_exec_time, $exec_queries) = $this->measureQueries($this->migration->db->queries);

		$this->summary($signal, $time_start, $time_end, $query_exec_time, $exec_queries);
	}
}
