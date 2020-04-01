<?php

/*
 * This file will access the database and execute different queries
 */

class db
{

    private $servername;
    private $username;
    private $password;
    private $dbname;

    public $conn;
    
     
    public function connectToDB()
    {
        $accessJson = fopen("../private_html/access.json", 'r');
        $cred = json_decode(fread($accessJson,filesize("../private_html/access.json")), true);
        
        $servername = $cred['servername'];
        $username = $cred['username'];
        $password = $cred['password'];
        $dbname = $cred['dbname'];
        
        fclose($accessJson);

        // PDO // 
        /*
        try
        {
            Global $conn;
            $conn = new PDO("mysql:host=$servername;$dbname", $username, $password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Connected successfully";
        }
        catch(PDOException $e)
        {
            echo "Connection failed: " . $e->getMessage();
        }
        */
        
        // mySQLI //
        global $conn;
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error)
        {
            die("Connection failed: " . $conn->connect_error);
        }
        
        return;
    }

    public function getPosts()
    {
        Global $conn;
        // PDO // $data = $conn->query("SELECT * FROM details")->fetchAll();

        // mySQLI //
        $sql = "SELECT * FROM `ideas` WHERE is_public = 1";
        $data = $conn->query($sql);

        if ($data->num_rows > 0) {
            // output data of each row
            while($row = $data->fetch_assoc()) {
                echo("<div>");
                foreach ($row as $key => $value) {
                    
                    echo("$key : $value");
                    echo("<br>");
                    
                }
                echo("<div>");
            }
        } else {
            echo "0 results";
        }
        return $data;
    }

    public function getPost($id)
    {
        Global $conn;

        $sql = "SELECT * FROM `ideas` WHERE 'id' = $id";
        
        $data = $conn->query($sql);

        if ($data->num_rows > 0) {
            // output data of each row
            while($row = $data->fetch_assoc()) {

                foreach ($row as $key => $value) {
                    echo($value);
                }
            }
        }

    }

    public function closeConn()
    {
        Global $conn;

        $conn = null;
    }
}