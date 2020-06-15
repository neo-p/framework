<?php

namespace NeoP;

use NeoP\Annotation\Scaner\Scaner;
use NeoP\Console\Commander;
use NeoP\Config\Config;
use NeoP\Process\Processor;
use NeoP\Log\Log;
use NeoP\DI\Container;

class Application
{
    public static $service;

    public function run(string $service = "app")
    {
        self::$service = $service;
        (new Scaner())->run();
        Config::init();
        Container::init();

        Commander::init();
        $processor = Container::getDefinition(Processor::class);
        $call = Commander::getCall();

        $processor->run(...$call);
    }
}