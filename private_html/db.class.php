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

    public function getPosts($start, $amount, $userId)
    {
        Global $conn;
        // PDO // $data = $conn->query("SELECT * FROM details")->fetchAll();

        // mySQLI //
        $sql = "SELECT * FROM ideas WHERE (is_public = 1) OR (owner_id = '$userId') ORDER BY id DESC LIMIT $start,$amount";
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
                $subObject->is_public = $row['is_public'];

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

    public function getOwnerName2($id)
    {
        Global $conn;

        $sql = "SELECT owner_id FROM `ideas` WHERE `id` = $id";
        
        $data = $conn->query($sql);

        if ($data->num_rows > 0) {
            // output data of each row
            while($row = $data->fetch_assoc()) {

                $ideaOwnerId = $row['owner_id'];
            }
        }
        else
        {
            return "Idea ID not found";
        }

        $sql = "SELECT nickname FROM `users` WHERE `id` = $ideaOwnerId";
        
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

    public function getOwnerID($id)
    {
        Global $conn;

        $sql = "SELECT owner_id FROM `ideas` WHERE `id` = $id";
        
        $data = $conn->query($sql);

        if ($data->num_rows > 0) {
            // output data of each row
            while($row = $data->fetch_assoc()) {

                return $ideaOwnerId = $row['owner_id'];
            }
        }
        else
        {
            return "Idea ID not found";
        }
    }

    public function getPost($id,$userID)
    {
        Global $conn;
        // PDO // $data = $conn->query("SELECT * FROM details")->fetchAll();

        // mySQLI //

        $sql = "SELECT * FROM ideas WHERE (`is_public` = 1 AND `id` = $id) OR (owner_id = '$userID' AND id = $id)";
        $data = $conn->query($sql);

        

        $subObject = new \stdClass();

        if ($data->num_rows > 0)
        {
            // output data of each row
            while($row = $data->fetch_assoc()) {
                
                
                $subObject->id = $row['id'];
                $subObject->title = $row['title'];
                $subObject->author = $this->getOwnerName($row['owner_id']);
                $subObject->short_description = $row['short_description'];
                $subObject->followers = $row['followers'];
                $subObject->creation_dateTime = $row['creation_dateTime'];
                $subObject->edit_dateTime = $row['edit_dateTime'];
                $subObject->is_public = $row['is_public'];
            }
        }
        else
        {
            echo "Could not find idea!";
        }
        return $subObject;
    }

    public function getPostDescription($id, $userId)
    {
        Global $conn;

        $sql = "SELECT `description` FROM ideas WHERE (`is_public` = '1' AND `id` = '$id') OR (`owner_id` = '$userId' AND `id` = '$id')";
        $data = $conn->query($sql);

        if ($data->num_rows > 0)
        {
            // output data of each row
            while($row = $data->fetch_assoc()) {
                echo($row['description']);
            }
        }
        else
        {
            echo "Could not find idea!";
        }
    }

    public function updatePost($id, $title, $short, $long, $public)
    {
        Global $conn;
        
        $title = ($title);
        $short = ($short);
        $long = ($long);

        $dateTime = date("Y-m-d H:i:s");

        $sql = "UPDATE `ideas` SET `title` = '$title', `short_description` = '$short', `description` = '$long', `is_public` = '$public', `edit_dateTime` = '$dateTime' WHERE `id` = $id";

        if (mysqli_query($conn, $sql)) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
    }

    public function createPost($ownerID, $title, $short, $long, $is_public)
    {
        Global $conn;
        
        $ownerID = ($ownerID);
        $title = ($title);
        $short = ($short);
        $long = ($long);
        $is_public = ($is_public);

        $sql = "INSERT INTO `ideas` (`owner_id`, `title`, `short_description`, `description`, `is_public`) VALUES ('$ownerID', '$title', '$short', '$long', '$is_public')";
            
        if ($conn->query($sql) === TRUE) {
            $sql = "SELECT `id` FROM ideas WHERE `owner_id` = '$ownerID' ORDER BY `id` DESC LIMIT 1";
            $data = $conn->query($sql);
    
            if ($data->num_rows > 0)
            {
                // output data of each row
                while($row = $data->fetch_assoc()) {
                    return($row['id']);
                }
            }
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

    }

    public function deletePost($postID, $userID)
    {
        Global $conn;

        if ($userID == $this->getOwnerID($postID))
        {
            $sql = "DELETE FROM `ideas` WHERE `id` = '$postID'";

            if ($conn->query($sql) === TRUE) {
                echo "Post Removed!";
            } else {
                echo "Error deleting record: " . $conn->error;
            }
        }
        else
        {
            echo("Unauthorised Access!");
        }
    }

    public function checkIfIdeaPublic($id)
    {
        Global $conn;

        $sql = "SELECT `is_public` FROM ideas WHERE `id` = $id";
        $data = $conn->query($sql);

        if ($data->num_rows > 0)
        {
            // output data of each row
            while($row = $data->fetch_assoc()) {
                echo($row['is_public']);
            }
        }
        else
        {
            echo "Could not find idea!";
        }
    }

    public function checkIfFollow($userID, $TargetType, $TargetID)
    {
        Global $conn;

        $sql = "SELECT * FROM `relations` WHERE `user_id` = '$userID' AND `target_type` = '$TargetType' AND `target_id` = '$TargetID'";
        
        $data = $conn->query($sql);

        if ($data->num_rows > 0)
        {
            return true;
        }
        else
        {
            return false;
        }

    }

    public function updateFollowerCount($TargetType, $TargetID)
    {
        Global $conn;

        $sql = "SELECT COUNT(`user_id`) FROM `relations` WHERE `target_type` = '$TargetType' AND `target_id` = '$TargetID'";

        $data = $conn->query($sql);

        while($row = $data->fetch_assoc()) {
            $followerCount = ($row['COUNT(`user_id`)']);
        }

        $sql = "UPDATE `ideas` SET `followers`='$followerCount' WHERE `id` = '$TargetID'";

        if ($conn->query($sql) === TRUE) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }

    public function toggleFollow($userID, $TargetType, $TargetID)
    {
        Global $conn;

        if ($this->checkIfFollow($userID, $TargetType, $TargetID))
        {
            $sql = "DELETE FROM `relations` WHERE `user_id` = '$userID' AND `target_type` = '$TargetType' AND `target_id` = '$TargetID'";

            if ($conn->query($sql) === TRUE) {
                echo "Unfollow successfull!";
            } else {
                echo "Error deleting record: " . $conn->error;
            }
        }
        else
        {
            $sql = "INSERT INTO `relations` (`user_id`, `target_type`, `target_id`) VALUES ('$userID', '$TargetType', '$TargetID')";
            
            if ($conn->query($sql) === TRUE) {
                echo "Follow successfull!";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }

        $this->updateFollowerCount($TargetType, $TargetID);
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