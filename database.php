<?php
$local = false;
$path = $_SERVER['DOCUMENT_ROOT'];

if ($local == false) {
    $path = $_SERVER["CONTEXT_DOCUMENT_ROOT"];
}

require_once($path . "/secure/config.php");

class Database
{
    protected $user = "root";
    protected $password = "";
    protected $db = "site";
    protected $cn;

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

    // Get connection function
    public function GetConnection()
    {
        $config = new Configuration();
        $this->user = $config->username;
        $this->password = $config->password;
        $this->db = $config->database;

        $conn = new mysqli("localhost", $this->user, $this->password, $this->db);

        if ($conn->connect_errno) {
            echo "Failed to connect to MySQL: " . $conn->connect_errno;
            exit();
        }

        $this->cn = $conn;
        return $this->cn;
    }

    // Close connection function
    public function CloseConnection()
    {
        $this->cn->close();
    }

    // Utility functions 
    public function getAll($query)
    {
        $cn = $this->cn;
        if ($query == "") {
            return "Error: $query cannot be blank";
        }
        $result = $cn->query($query);
        // Fetch all 
        $array = $result->fetch_all(MYSQLI_ASSOC);
        // Free result set 
        $result->free_result();
        return $array;
    }
    public function getArray($query)
    {
        $cn = $this->cn;
        if ($query == "") {
            return "Error: $query cannot be blank";
        }
        $result = $cn->query($query);
        // Fetch all 
        $array = $result->fetch_array(MYSQLI_ASSOC);
        // Free result set 
        $result->free_result();
        return $array;
    }
}

$db = new Database();
$cn = $db->GetConnection();
