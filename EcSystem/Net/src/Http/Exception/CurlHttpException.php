<?php

namespace ES\Net\Http\Exception;

class CurlHttpException extends \Exception
{
    const NOT_OPEN = 4000;

    public function __construct($message, $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function __toString()
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}
