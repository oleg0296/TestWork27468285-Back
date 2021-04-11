<?php

namespace App\Core\Interfaces;

/**
 * Interface ResponseInterface
 * @package App\Core\Interfaces
 */
interface ResponseInterface
{
    /**
     * @param int $code
     * @return mixed
     */
    public function setStatusCode(int $code);

    /**
     * @return mixed
     */
    public function getStatusCode();

    /**
     * @param $content
     * @return mixed
     */
    public function setContent($content);

    /**
     * @return mixed
     */
    public function getOriginalContent();

    /**
     * @param $error
     * @return mixed
     */
    public function addError(array $error);

    /**
     * @return mixed
     */
    public function getErrors();
}