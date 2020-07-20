<?php

require_once 'vendor/autoload.php';
$app = require_once 'app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$status = $kernel->handle(
    $input = new Symfony\Component\Console\Input\ArgvInput(['','migrate']),
    new Symfony\Component\Console\Output\ConsoleOutput
);