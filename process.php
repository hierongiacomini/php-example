<?php

    require('./vendor/autoload.php');
    require('./system/connection.php');

    $connection = new Connection();
    $result = $connection->query("SELECT id, url FROM urls WHERE status IS NULL;");
    $rows = $result->fetch_all(MYSQLI_ASSOC);

    foreach($rows as $row){

        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->request('GET', $row['url'], ['allow_redirects' => false]);
            $status = $connection->escape($response->getStatusCode());
            $body = substr($connection->escape((string) ($response->getBody())), 0, 65534);
            $date = date('d/m/Y H:i:s');
            $connection->query("UPDATE urls SET status = '{$status}', body = '{$body}', date = '{$date}' WHERE id = {$row['id']};");
        }
        catch(Exception $exception){
            //#
        }
    
    }
