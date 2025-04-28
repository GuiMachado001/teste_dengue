<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require '../app/model/Database.php';

$db = new Database();
$db->conecta();