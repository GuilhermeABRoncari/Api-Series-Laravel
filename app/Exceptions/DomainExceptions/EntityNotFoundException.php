<?php

namespace App\Exceptions\DomainExceptions;

use App\Enums\HttpStatusCode;
use DateTime;
use DateTimeZone;
use DomainException;

class EntityNotFoundException extends DomainException
{
    private DateTime $timestamp;
    public function __construct(int $entityId)
    {
        parent::__construct("Entity not found for id : {$entityId}", HttpStatusCode::NOT_FOUND);
        $this->timestamp = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
    }

    public function getFormattedTimestamp(): string
    {
        $dateTime = $this->timestamp;
        return $dateTime->format('d/m/Y H:i:s');
    }
}