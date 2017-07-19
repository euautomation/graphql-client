<?php

namespace EUAutomation\GraphQL;

class Response
{
    /**
     * @var
     */
    protected $data;

    /**
     * @var array
     */
    protected $errors = [];

    /**
     * Response constructor.
     *
     * @param $data
     * @param array $errors
     */
    public function __construct($response)
    {

        if (isset($response->data)) {
            $this->data = $response->data;
        }

        if (isset($response->errors)) {
            $this->errors = $response->errors;
        }
    }

    /**
     * Return all the data
     *
     * @return mixed
     */
    public function all()
    {
        return $this->data;
    }

    /**
     * Get errors returned from query
     *
     * @return array
     */
    public function errors()
    {
        return $this->errors;
    }

    /**
     * Check if there are any errors
     *
     * @return bool
     */
    public function hasErrors()
    {
        return (bool)count($this->errors());
    }

    /**
     * Return the data as a JSON string
     *
     * @return string
     */
    public function toJson()
    {
        return json_encode($this->data);
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function __get($name)
    {
        return $this->data->{$name};
    }

    /**
     * @param string $name
     * @param mixed $value
     */
    public function __set($name, $value)
    {
        $this->data->{$name} = $value;
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function __isset($name)
    {
        return $this->data->{$name};
    }
    
    /**
     * @param $name
     */
    public function __unset($name)
    {
        unset($this->data->{$name});
    }
}
