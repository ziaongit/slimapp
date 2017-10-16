<?php
class db {
    //Propertise
    private $dbhost = 'localhost';
    private $dbuser = 'root';
    private $dbpass = '';
    private $dbname = 'slimapp';
    //Connect

    public function connect(){

        try {
            $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
            $dbConnection = new PDO("mysql:host=$this->dbhost;dbname=$this->dbname;", $this->dbuser, $this->dbpass, $options);

            // set the PDO error mode to exception
            $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //echo "Connected successfully"; 
        }
        catch(PDOException $e)
        {
            echo "Connection failed: " . $e->getMessage();
        }

        return $dbConnection;

        
    }
}

