<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "bank_sql";
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    echo "连接成功\n"; 
}
catch(PDOException $e)
{
    echo $e->getMessage();
}