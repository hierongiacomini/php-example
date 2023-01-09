<?php

    function isAuthenticated(){
        return isset($_SESSION['authenticated']) && $_SESSION['authenticated'];
    }

    function authenticate(){
        $_SESSION['authenticated'] = true;
    }

    function unauthenticate(){
        $_SESSION['authenticated'] = false;
    }