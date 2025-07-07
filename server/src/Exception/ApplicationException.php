<?php

namespace App\Exception;

use Exception;

class ApplicationException extends Exception
{
    function __construct(string $message, int $code = 0, $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
