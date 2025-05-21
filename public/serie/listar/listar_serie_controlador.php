<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

require_once '../../../app/controller/Serie.php';

$serie = new Serie();
$dados = $serie->buscar();

header('Content-Type: application/json');
echo json_encode($dados);
