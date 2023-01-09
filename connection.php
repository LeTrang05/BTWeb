<?php
$dbName = 'student';
$tableName = 'student';
$conn = new mysqli('localhost', 'root', '');
    if (!$conn) {
        die('Connection failed: ');
    }
    $sql = "CREATE DATABASE IF NOT EXISTS " . $dbName;
    if ($conn->query($sql) === TRUE) {
        if (mysqli_select_db($conn, $dbName)){
            $sql = "CREATE TABLE IF NOT EXISTS " . $tableName . "(
                    id int(11) NOT NULL AUTO_INCREMENT,
                    name varchar(250) NOT NULL,
                    gender int(1) NOT NULL,
                    faculty char(3) NOT NULL,
                    birthday date NOT NULL,
                    address varchar(250) DEFAULT NULL,
                    avatar text DEFAULT NULL,
                    PRIMARY KEY (ID)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
            if ($conn->query($sql)) {} 
        }        
    }
?>
