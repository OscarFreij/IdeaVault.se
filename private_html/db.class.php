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

    public function getUserInfoEmail($email)
    {
        Global $conn;

        $sql = "SELECT * FROM `users` WHERE `email`= '$email'";
        
        $data = $conn->query($sql);

        if ($data->num_rows > 0) {
            // output data of each row
            while($row = $data->fetch_assoc()) {

                return $row;
            }
        }
        else
        {
            return null;
        }

    }

    public function getUserInfoNick($nickname)
    {
        Global $conn;

        $sql = "SELECT * FROM `users` WHERE `nickname`= '$nickname'";
        
        $data = $conn->query($sql);

        if ($data->num_rows > 0) {
            // output data of each row
            while($row = $data->fetch_assoc()) {

                return $row;
            }
        }
        else
        {
            return null;
        }

    }

    public function createUser($email,$given_name,$family_name,$locale)
    {
        Global $conn;

        $sql = "SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = 'ideavault' AND TABLE_NAME = 'users'";
        
        $data = $conn->query($sql);

        if ($data->num_rows > 0) {
            // output data of each row
            while($row = $data->fetch_assoc()) {

                foreach ($variable as $key => $value) {
                    $nickname = "IdeaGenerator".$value;
                }
                
            }
        }


        $sql = "INSERT INTO `users`(`nickname`, `first_name`, `family_name`, `email`, `locale`) VALUES ('$nickname','$given_name','$family_name','$email','$locale')";

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        return $nickname;
    }

    public function closeConn()
    {
        Global $conn;

        $conn = null;
    }
}