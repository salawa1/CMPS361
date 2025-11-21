<?php

function logActivity($userId, $activityType, $activityDescription) {
    //Create a db connection
    $host = 'localhost';
    $db = 'authentication';
    $db_user = 'postgres';
    $db_pass = 'Amat1966';
    $port = '5432';

    $conn = pg_connect("host=$host port=$port dbname=$db user=$db_user password=$db_pass"); 

    //Validate the connection works
    if(!$conn){
        die("connection failed: " . pg_last_error());
    }

    //Capture IP addresses
    $ipAddress = $_SERVER['REMOTE_ADDR'];
    $userAgent = $_SERVER['HTTP_USER_AGENT'];
    $createAt = date('Y-m-d H:i:s');

    //Add tracking information to the database
    $sql = "insert into user_activity_logging(user_id,activity_type,activity_description,ip_address,user_agent,create_at) VALUES ($1, $2, $3, $4, $5, $6)";

    //Execute the SQL for the INSERT into table
    $result = pg_query_params($conn, $sql, array($userId, $activityType, $activityDescription, $ipAddress, $userAgent, $createAt));

    if(!$result) {
        echo "Error in query execution " . pg_last_error($conn);
    } else {
        echo "Activity logged successfully";
    }

    //Close the connection to the database
    pg_close($conn);
}
    
?>