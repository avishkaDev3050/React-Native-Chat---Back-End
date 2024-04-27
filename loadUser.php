<?php

    $userJsonText = $_POST["userJsonText"];
    $userPHPObject = json_decode($userJsonText);

    $fromId = $userPHPObject->id;
    // echo($fromId);

    $connection = new mysqli("localhost","root","VXDRKHCB","chat");
    $table = $connection->query("SELECT * FROM `user` WHERE `id` != '". $fromId."' ");
    
    $phpResponseArray = array();

    for($x = 0; $x < $table->num_rows; $x++) {

        $phpArrayItemObject = new stdClass();

        $user = $table->fetch_assoc();
        $toId = $user['id'];
        $phpArrayItemObject->pic = $user['profile'];
        $phpArrayItemObject->name = $user['name'];
        $phpArrayItemObject->id = $user['id'];

        $table2 = $connection->query("SELECT * FROM `chat` WHERE 
        `from_user_id` = '". $fromId ."' AND `to_user_id` = '". $toId ."' 
        OR 
        `from_user_id` = '". $toId ."' AND `to_user_id` = '". $fromId ."' ORDER BY `date_time` DESC ");
        
        if($table2->num_rows == 0) {
            $phpArrayItemObject->msg = "";
            $phpArrayItemObject->time = "";
            $phpArrayItemObject->count = "0";
        } else {

            // unseen chat count
            $unseenChatCount = 0;

            // first row
            $lastChatRow = $table2->fetch_assoc();
            if($lastChatRow["status_id"] == 2) {
                $unseenChatCount++;
            }

            $phpArrayItemObject->msg = $lastChatRow["message"];

            $phpDateTimeObject = strtotime($lastChatRow["date_time"]);
            $timeStr = date("h:i a", $phpDateTimeObject);

            $phpArrayItemObject->time = $timeStr;

            for($i = 0; $i < $table2->num_rows; $i++){
                // other row
                $newChatRow = $lastChatRow['status_id'];
                if($newChatRow == 2) {
                    $unseenChatCount++;
                }
            }

            $phpArrayItemObject->count = $unseenChatCount;

        }

        array_push($phpResponseArray, $phpArrayItemObject);
        
    }

    $jsonResponseText = json_encode($phpResponseArray);
    echo($jsonResponseText);
    
?>