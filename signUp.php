<?php

    $mobile = $_POST["mobile"];
    $name = $_POST["name"];
    $password = $_POST["password"];
    $verifypassword = $_POST["verifyPassword"];
    //$country = $_POST["country"];
    $country = "Sri Lanka";
    $f = $_FILES["profile_picture"]["tmp_name"];

    $connection = new mysqli("localhost","root","VXDRKHCB","chat");

    $table = $connection -> query("SELECT `id` FROM `country` WHERE `name`='".$country."'");

    $row = $table->fetch_assoc();
    $country_id = $row["id"];

    $connection->query("INSERT INTO `user`(`mobile`,`name`,`password`,`profile`,`country_id`) VALUE
    ('".$mobile."','".$name."','".$password."','".$mobile."','".$country_id."') ");

    move_uploaded_file($f,"uploads/".$mobile.".png");

    echo("Uploaded");

?>