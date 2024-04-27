<?php

$requestJson= $_POST["r"];
$requestObject = json_decode($requestJson);

$from_user_id = $requestObject->from;

$to_user_id = $requestObject->to;

$message = $requestObject->message;

$date_time = date("Y-m-d H:i:s");

$connection = new mysqli("localhost","root","VXDRKHCB","chat");

$connection->query("INSERT INTO `chat`
(`from_user_id`,`to_user_id`,`message`,`date_time`,`status_id`) 
VALUE('".$from_user_id."','".$to_user_id."','".$message."',
'".$date_time."', 1) ");

echo("Success");

?>