<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

require_once '../../../app/controller/cidade.php';

$cidade = new Cidade();
$lista = $cidade->buscar_com_estado();

header('Content-Type: application/json');
echo json_encode($lista);