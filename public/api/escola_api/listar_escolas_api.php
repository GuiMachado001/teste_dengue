<?php

require_once '../../../app/model/Database.php';

header('Content-Type: application/json');

try {
    $db = new Database('escola');
    $escolas = $db->select()->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($escolas);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erro ao buscar escolas']);
}