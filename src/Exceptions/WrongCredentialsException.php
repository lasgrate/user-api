<?php

namespace App\Exceptions;

class WrongCredentialsException extends ServiceException
{
    protected $message = 'Incorrect nickname or password.';

    protected $type = 'WRONG_CREDENTIALS';
}
