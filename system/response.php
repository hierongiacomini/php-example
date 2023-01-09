<?php

    class Response {

        function send($data, $type = 'application/json'){

            if($type === 'application/json'){
                $data = json_encode($data);
            }

            header_remove('Cache-Control');
            header('Content-Type: ' . $type);
            echo($data);
            exit();
            
        }

    }

