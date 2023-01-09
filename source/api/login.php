<?php

    session_start();
    require('../../system/authenticated.php');
    require('../../system/connection.php');
    require('../../system/response.php');

    $response = new Response();

    if(isAuthenticated()){
        $response->send(['success' => true]);
    }

    if(!isset($_POST['email']) || !isset($_POST['password'])){
        $response->send([
            'success' => false,
            'error' => 'Email e senha são obrigatórios'
        ]);
    }

    $connection = new Connection();
    $email = $connection->escape($_POST['email']);
    $password = $connection->escape($_POST['password']);
    $result = $connection->query("SELECT id FROM users WHERE email = '{$email}' AND password = '{$password}'");

    if($result->num_rows !== 1){
        $response->send([
            'success' => false,
            'error' => 'Email e/ou senha inválidos'
        ]);
    }

    authenticate();
    $response->send(['success' => true]);
