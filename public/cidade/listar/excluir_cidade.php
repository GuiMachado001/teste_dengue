<?php

require_once '../../../app/controller/cidade.php';

header('Content-Type: application/json');

// Permitir apenas requisições DELETE
if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    echo json_encode(['success' => false, 'message' => 'Método não permitido']);
    http_response_code(405); // Method Not Allowed
    exit;
}

// Ler o corpo JSON
$input = json_decode(file_get_contents('php://input'), true);
$id_cidade = $input['id_cidade'] ?? null;

if (!$id_cidade) {
    echo json_encode(['success' => false, 'message' => 'Id não fornecido']);
    exit;
}

$cidade = new Cidade();
$cidade->id_cidade = $id_cidade;

if ($cidade->excluir()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Erro ao excluir ou cidade não encontrado']);
}
