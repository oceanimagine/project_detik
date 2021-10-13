<?php

header('Content-Type: application/json');
$host = "localhost";
$user = "root";
$pass = "";
$data = "project_api_detik";
$connect = mysqli_connect($host, $user, $pass, $data);