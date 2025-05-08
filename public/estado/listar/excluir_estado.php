<?php

require_once '../../../app/controller/estado.php';

header('Content-Type: application/json');

// Permitir apenas requisições DELETE
if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    echo json_encode(['success' => false, 'message' => 'Método não permitido']);
    http_response_code(405); // Method Not Allowed
    exit;
}

// Ler o corpo JSON
$input = json_decode(file_get_contents('php://input'), true);
$id_estado = $input['id_estado'] ?? null;

if (!$id_estado) {
    echo json_encode(['success' => false, 'message' => 'Id não fornecido']);
    exit;
}

$estado = new Estado();
$estado->id_estado = $id_estado;

if ($estado->excluir()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Erro ao excluir ou estado não encontrado']);
}
