<?php

namespace App\Command;

use App\Controller\ParseApiDataController;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class getApiDataCommand extends Command
{
    private $parse;

    public function __construct(string $name = null, ParseApiDataController $parse)
    {
        parent::__construct($name);
        $this->parse = $parse;

    }

    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:get-data';

    protected function configure(): void
    {
        $this->addArgument('url', InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $this->parse->parseApiData($input->getArgument('url'));
        $output->writeln([
            'success',
            '<============>',
            '',
        ]);
        return 0;
    }

}
