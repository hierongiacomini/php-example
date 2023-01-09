<?php

    session_start();
    require('../../system/authenticated.php');
    require('../../system/connection.php');
    require('../../system/response.php');

    if(!isAuthenticated()){
        echo('Você precisa estar autenticado');
        exit();
    }

    $connection = new Connection();
    $response = new Response();

    if($_SERVER['REQUEST_METHOD'] === 'GET'){

        if(isset($_GET['id']) && $_GET['id']){
            $result = $connection->query("SELECT id, url, status, header, body, date FROM urls WHERE id = {$connection->escape($_GET['id'])};");
        }
        else{
            $result = $connection->query("SELECT id, url, status, header, body, date FROM urls;");
        }

        $rows = $result->fetch_all(MYSQLI_ASSOC);
    
        $response->send($rows);

    }
    elseif($_SERVER['REQUEST_METHOD'] === 'POST'){
        
        if(!isset($_POST['url'])){
            $response->send([
                'success' => false,
                'error' => 'Url obrigatória'
            ]);
        }

        $url = $connection->escape($_POST['url']);

        $result = $connection->query("INSERT INTO urls (url) VALUES ('$url')");

        $result = $connection->query("SELECT id, url, status, header, body, date FROM urls WHERE id = {$connection->getLastId()}");
        $rows = $result->fetch_all(MYSQLI_ASSOC);

        $response->send([
            'success' => true,
            'url' => $rows[0]
        ]);

    }

