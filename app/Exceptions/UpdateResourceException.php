<?php


namespace App\Exceptions;


use Symfony\Component\HttpFoundation\Response;

class UpdateResourceException extends BaseException
{
    protected $code = Response::HTTP_INTERNAL_SERVER_ERROR;

    protected $message = 'Failed to Update the Resource';
}
