<?php

require_once '../../../app/model/Database.php';

header('Content-Type: application/json');

try {
    $db = new Database('cidade');
    $cidades = $db->select()->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($cidades);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erro ao buscar cidades']);
}