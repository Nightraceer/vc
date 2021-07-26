<?php

declare(strict_types=1);

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Yaml\Parser;
use TestWork\App;

include __DIR__ . '/../vendor/autoload.php';

$root = dirname(__DIR__);
$config = (new Parser())->parseFile("{$root}/config/config.yml");

$request = Request::createFromGlobals();
$response = (new App($config, $root))->handle($request);
$response->send();
