<?php

require_once '../vendor/autoload.php';

use Klein\Klein;
use Minifier\Manager\ServiceManager;

$klein = new Klein();

ServiceManager::initService($klein);

$klein->respond('GET', '/u/[s:token]', array('Minifier\Controller\RedirectController', 'redirectAction'));

$klein->dispatch();

