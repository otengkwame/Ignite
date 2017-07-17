<?php
namespace CLI\Commands;

use CLI\Core\Command;
use CLI\Core\Codeigniter;
use Psy\Configuration;
use Psy\Shell;

use Symfony\Component\Console\Input\InputOption;

/**
 * Console Command
 *
 * @package     CLI
 * @author      David Sosa Valdes
 * @link        https://github.com/davidsosavaldes/CLI
 * @copyright   Copyright (c) 2016, David Sosa Valdes.
 */
class Console extends Command
{
  protected $name        = 'console';
  protected $description = 'Interact with your application';
  protected $aliases     = ['c'];

  protected $commandWhitelist = [
    'generate:controller',
    'generate:migration',
    'generate:model',
    'generate:seeder',
    'migrate:check',
    'migrate:latest',
    'migrate:refresh',
    'migrate:reset',
    'migrate:rollback',
    'migrate:version',
    'db:seed',
    'serve'
  ];

  /**
   * Command configuration method.
   * Configure all the arguments and options.
   */
  protected function configure()
  {
    parent::configure();
  }

  /**
   * Execute the console command.
   *
   * @return void
   * @throws \Exception
   */
  public function start()
  {
    $this->getApplication()->setCatchExceptions(false);
    try
    {
      $instance = new Codeigniter();
      $config   = new Configuration; // TODO: Create a method that configures the Psy\Shell
      $shell    = new Shell($config);

      $CI =& $instance->get();

      $this->writeln([
        'Ignite '.$this->getApplication()->getVersion().' Console',
        '---------------------------------------------------------------',
        'Codeigniter : $CI',
        'Path: ./'.basename(FCPATH).'/'.basename(APPPATH),
        '---------------------------------------------------------------'
      ]);

      $shell->setScopeVariables(['CI' => $CI]);
      $shell->addCommands($this->getCommands());
      $shell->run();
    }
    catch (Exception $e)
    {
      echo $e->getMessage() . PHP_EOL;
      // TODO: this triggers the "exited unexpectedly" logic in the
      // ForkingLoop, so we can't exit(1) after starting the shell...
      // exit(1);
    }
  }

  private function getCommands()
  {
    $commands = [];
    foreach ($this->getApplication()->all() as $name => $command)
    {
      in_array($name, $this->commandWhitelist) && $commands[] = $command;
    }
    return $commands;
  }
}
