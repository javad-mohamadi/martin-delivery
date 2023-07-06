<?php

namespace App\Exceptions;

use Exception;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class MartinDeliveryException extends Exception
{
    protected array $error;

    #[Pure]
    public function __construct(int $httpCode = ResponseAlias::HTTP_BAD_REQUEST, string $message = '', array $error = [])
    {
        $message     = empty($message) ? 'bad request' : $message;
        $this->error = $error;
        parent::__construct($message, $httpCode);
    }

    /**
     * @return array
     */
    public function getError(): array
    {
        return $this->error;
    }
}
