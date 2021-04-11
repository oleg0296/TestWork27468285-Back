<?php

namespace App\Core\Responses;

use App\Core\Interfaces\ResponseInterface;
use Illuminate\Http\Response;

/**
 * Class HttpResponse
 * @package App\Core\Responses
 */
class HttpResponse extends Response implements ResponseInterface
{
    /**
     * @var array
     */
    protected $errors = [];

    /**
     * @param array $error
     */
    public function addError(array $error): void
    {
        $this->errors[] = $error;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}