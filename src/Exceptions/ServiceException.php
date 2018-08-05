<?php

namespace App\Exceptions;

class ServiceException extends \Exception
{
    protected $fields = [];

    protected $type = '';

    /**
     * @return array
     */
    public function getError(): array
    {
        return [
            'status' => 0,
            'error' => [
                'fields' => $this->fields,
                'type' => $this->type,
                'message' => $this->message,
            ]
        ];
    }

    /**
     * @return array
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * @param array $fields
     * @return ServiceException
     */
    public function setFields(array $fields): ServiceException
    {
        $this->fields = $fields;

        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return ServiceException
     */
    public function setType(string $type): ServiceException
    {
        $this->type = $type;

        return $this;
    }
}
