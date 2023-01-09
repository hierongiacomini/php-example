<?php

    class Connection {

        private $host;
        private $database;
        private $user;
        private $password;
        private $connection;


        function __construct(){

            date_default_timezone_set('America/Sao_Paulo');

            $this->host = 'localhost:3306';
            $this->database = 'desafio';
            $this->user = 'root';
            $this->password = '';

            try {
                $this->connection = new mysqli($this->host, $this->user, $this->password, $this->database);
            }
            catch(Exception $error) {
                echo('Falha ao conectar ao banco de dados');
                exit();
            }

        }

        function query($sql){

            try {
                return $this->connection->query($sql);
            }
            catch(Exception $error) {
                echo('Falha ao executar query');
                exit();
            }

        }

        function escape($data){
            return $this->connection->real_escape_string($data);
        }

        function getLastId(){
            return $this->connection->insert_id;
        }

    }

