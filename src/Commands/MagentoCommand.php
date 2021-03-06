<?php

namespace ProjectCLI\Magento\Commands;

use Chriha\ProjectCLI\Commands\Command;
use Chriha\ProjectCLI\Contracts\Plugin;
use Chriha\ProjectCLI\Helpers;
use Chriha\ProjectCLI\Services\Docker;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class MagentoCommand extends Command
{

    /** @var string */
    protected static $defaultName = 'magento';

    /** @var string */
    protected $description = 'Alias for Magento commands';


    /**
     * Configure the command by adding a description, arguments and options
     *
     * @return void
     */
    public function configure() : void
    {
        $this->addDynamicArguments()->addDynamicOptions();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(Docker $docker) : void
    {
        $docker->exec('web', $this->getParameters(['php', 'bin/magento']))
            ->setTty(true)
            ->run(
                function ($type, $buffer)
                {
                    $this->output->write($buffer);
                }
            );
    }

    /**
     * Make command only available if inside the project
     */
    public static function isActive() : bool
    {
        return PROJECT_IS_INSIDE
            && file_exists(Helpers::projectPath('src/bin/magento'));
    }

}
