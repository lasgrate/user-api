<?php

namespace App\Services;

use App\Exceptions\ServiceException;
use Validator\LIVR;

/**
 * Class Validator.
 * Use LIVR validator, for more detail see http://livr-spec.org/
 *
 * @package Service
 */
class Validator
{
    public static function validate(array $data, array $rules): array
    {
        $validator = new LIVR($rules);

        $validated = $validator->validate($data);
        $errors = $validator->getErrors();

        if (is_array($errors) && count($errors)) {
            throw (new ServiceException())
                ->setFields($errors)
                ->setType('FORMAT_ERROR');
        }

        return $validated;
    }
}
