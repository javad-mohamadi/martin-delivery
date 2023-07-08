<?php

namespace App\Exceptions;

use Exception;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class LogicException extends Exception
{
    protected array $error;

    #[Pure]
    public function __construct(int $httpCode = ResponseAlias::HTTP_INTERNAL_SERVER_ERROR, string $message = '', array $error = [])
    {
        $message     = empty($message) ? ResponseAlias::$statusTexts[$httpCode] : $message;
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
