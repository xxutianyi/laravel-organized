<?php

namespace App\Logging;

use Monolog\Logger;

class RequestLogger
{
    public function __invoke(array $config): Logger
    {
        return new Logger(/* ... */);
    }
}
