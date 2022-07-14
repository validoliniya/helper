<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Uid\UuidV4;

class TokenPasswdGenerateCommand extends Command
{
    protected static $defaultName = 'user:token:pass:generate';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $token = UuidV4::v4()->toRfc4122();
        $output->writeln(sprintf('<info>%s</info>', $token));

        return Command::SUCCESS;
    }
}
