<?php
    $url = 'http://localhost:3005/api/v1/shows';

    $urlWithParams = $url;

    // initialize the session
    $session = curl_init();

    // set the session options
    curl_setopt($session, CURLOPT_URL, $urlWithParams); // endpoint
    curl_setopt($session, CURLOPT_RETURNTRANSFER, $true); // return a response

    // execute the request
    $response = curl_exec($session);

    // catch errors
    if ($response === false){
        echo 'Error' . curl_error($session);
    } else {
        // return JSON
        $responseData = json_decode($response, true);
        header('Content-Type: application/json');
        echo json_encode($responseData);
    }

    // close session
    curl_close($session);
?>