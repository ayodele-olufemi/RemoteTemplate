<?php
class Configuration
{
    // Class properties
    protected $username = "root";
    protected $password = "";
    protected $site = "localhost";
    protected $database = "site";
    protected $local = false;

    // Constructor
    public function __construct()
    {
        if ($this->local == false) {
            $this->username = "ics325sp2409";
            $this->password = "";
            $this->database = "ics325sp2409";
        }
    }

    // Getter
    public function __get($property)
    {
        return $this->$property;
    }

    // Setter
    public function __set($prop, $value)
    {
        $this->$prop = $value;
    }
}
