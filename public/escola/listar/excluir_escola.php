<?php

require_once '../../../app/controller/escola.php';

header('Content-Type: application/json');

// Permitir apenas requisições DELETE
if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    echo json_encode(['success' => false, 'message' => 'Método não permitido']);
    http_response_code(405); // Method Not Allowed
    exit;
}

// Ler o corpo JSON
$input = json_decode(file_get_contents('php://input'), true);
$id_escola = $input['id_escola'] ?? null;

if (!$id_escola) {
    echo json_encode(['success' => false, 'message' => 'Id não fornecido']);
    exit;
}

$escola = new Escola();
$escola->id_escola = $id_escola;

if ($escola->excluir()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Erro ao excluir ou escola não encontrado']);
}
