<?php


namespace App\Exceptions;


use Symfony\Component\HttpFoundation\Response;

class CreateResourceException extends BaseException
{
    protected $code = Response::HTTP_INTERNAL_SERVER_ERROR;

    protected $message = 'Failed to Create a Resource';
}
