<?php

namespace Minifier\Command;

use Minifier\Manager\UserManager;
use Minifier\Repository\UserRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Minifier\Config\Config;

class CreateUserCommand extends Command
{
    protected function configure()
    {
        $this->setName('user:create')
            ->setDescription('Create a user in the database')
            ->setHelp('This is usefull to create a User in the database')
            ->addArgument('username', InputArgument::REQUIRED, 'The username of the user.')
            ->addArgument('password', InputArgument::REQUIRED, 'The password for the user');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $pdo = new \PDO(sprintf('mysql:host=%s;dbname=%s', Config::DBHOST, Config::DBNAME), Config::DBUSER, Config::DBPASSWORD);
        $um = new UserManager(new UserRepository($pdo));

        $user = $um->createUser($input->getArgument('username'), $input->getArgument('password'));

        $output->writeln([
            'User Creator',
            '============'
        ]);
        $output->writeln(sprintf('Username : %s ', $user->username));
        $output->writeln(sprintf('password : %s ', $user->hash));
    }
}