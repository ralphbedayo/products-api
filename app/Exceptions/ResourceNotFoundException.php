<?php


namespace App\Exceptions;


use Symfony\Component\HttpFoundation\Response;

class ResourceNotFoundException extends BaseException
{
    protected $code = Response::HTTP_NOT_FOUND;

    protected $message = 'Resource not found.';

}
