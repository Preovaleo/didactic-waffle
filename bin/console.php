#!/usr/bin/env php
<?php

require_once sprintf('%s/../vendor/autoload.php', dirname(__FILE__));

use Symfony\Component\Console\Application;
use Minifier\Command\CreateUserCommand;

$app = new Application();

$app->add(new CreateUserCommand());

$app->run();