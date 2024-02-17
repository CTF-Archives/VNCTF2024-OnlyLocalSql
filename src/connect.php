<?php
$db_host = '127.0.0.1:33060';
$db_username = $_POST["db_username"];
$db_password = $_POST["db_password"];
$db_name = $_POST["db_name"];

try {
    $dsn = "mysql:host=$db_host;dbname=$db_name";
    $pdo = new PDO($dsn, $db_username, $db_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $response = array("success" => true);
    $_SESSION['dsn']=$dsn; 
    $_SESSION['db_username']=$db_username; 
    $_SESSION['db_password']=$db_password; 

    echo json_encode($response);

} catch (PDOException $e) {
    $response = array("success" => false, "message" => $e->getMessage());
    echo json_encode($response);
}
?>