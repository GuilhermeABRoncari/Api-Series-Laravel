<?php

namespace App\Exceptions\DomainExceptions;

use DateTime;
use DateTimeZone;
use DomainException;

class AuthValidateException extends DomainException
{
    private DateTime $timestamp;
    public function __construct()
    {
        parent::__construct("Unauthorized", 401);
        $this->timestamp = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
    }

    public function getFormattedTimestamp(): string
    {
        $dateTime = $this->timestamp;
        return $dateTime->format('d/m/Y H:i:s');
    }
}
