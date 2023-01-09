<?php

    session_start();
    require('../../system/authenticated.php');
    require('../../system/response.php');

    $response = new Response();
    if(!isAuthenticated()){
        $response->send(['success' => true]);
    }

    unauthenticate();
    $response->send(['success' => true]);