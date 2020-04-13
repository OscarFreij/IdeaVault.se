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

    public function getPosts($start, $amount)
    {
        Global $conn;
        // PDO // $data = $conn->query("SELECT * FROM details")->fetchAll();

        // mySQLI //
        $sql = "SELECT * FROM ideas WHERE is_public = 1 ORDER BY id DESC LIMIT $start,$amount";
        $data = $conn->query($sql);

        $returnObject = new \stdClass();

        $temp = 0;

        if ($data->num_rows > 0)
        {
            // output data of each row
            while($row = $data->fetch_assoc()) {
                
                $subObject = new \stdClass();
                $subObject->id = $row['id'];
                $subObject->title = $row['title'];
                $subObject->author = $this->getOwnerName($row['owner_id']);
                $subObject->short_description = $row['short_description'];
                $subObject->followers = $row['followers'];
                $subObject->creation_dateTime = $row['creation_dateTime'];
                $subObject->edit_dateTime = $row['edit_dateTime'];

                $returnObject->$temp = $subObject; 
                $temp++;
            }
        }
        else
        {
            echo "0 results";
        }

        $JsonReturnObject = json_encode($returnObject);
        
        return $JsonReturnObject;
    }

    public function getOwnerName($id)
    {
        Global $conn;

        $sql = "SELECT nickname FROM `users` WHERE `id` = $id";
        
        $data = $conn->query($sql);

        if ($data->num_rows > 0) {
            // output data of each row
            while($row = $data->fetch_assoc()) {

                return $row['nickname'];
            }
        }
        else
        {
            return "No User Found";
        }
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

    public function getPostAmount($isPublic)
    {
        Global $conn;

        if ($isPublic)
        {
            $sql = "SELECT COUNT(*) FROM `ideas` WHERE 1";
        }
        else
        {
            $sql = "SELECT COUNT(*) FROM `ideas` WHERE is_public = 1";
        }

        $data = $conn->query($sql);

        if ($data->num_rows > 0) {
            // output data of each row
            while($row = $data->fetch_assoc()) {

                foreach ($row as $key => $value) {
                    return($value);
                }
            }
        }
        else
        {
            return 0;
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

        $nickname = "";

        if ($data->num_rows > 0) {
            // output data of each row
            while($row = $data->fetch_assoc()) {

                foreach ($row as $key => $value) {
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

    public function updateUser($valueToChange, $newValue, $userToUpdate)
    {
        Global $conn;

        $sql = "UPDATE `users` SET `$valueToChange`='$newValue' WHERE `email`='$userToUpdate'";

        if (mysqli_query($conn, $sql)) {
            return("Successfully updated account!");
        } else {
            return("Faild updated account! ERROR: ".mysqli_error($conn));
        }
    }

    public function closeConn()
    {
        Global $conn;

        $conn = null;
    }
}