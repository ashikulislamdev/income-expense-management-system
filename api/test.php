<?php
    header("Access-Control-Allow-Origin: *");


    // get request method
    $method = $_SERVER['REQUEST_METHOD'];
    if ($method == 'GET') {
        echo "THIS IS A GET REQUEST";
    }
    if ($method == 'POST') {
        $val = $_POST['email'];
        echo $val;
    }
    if ($method == 'PUT') {
        echo "THIS IS A PUT REQUEST";
    }
    if ($method == 'DELETE') {
        echo "THIS IS A DELETE REQUEST";
    }

?>