<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../../../app/controller/estado.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $input = json_decode(file_get_contents('php://input'), true);
    $nome = $input['nome'] ?? '';
    
    if (!$nome) {
        http_response_code(400);
        echo json_encode(['message' => 'Nome do estado é obrigatório.']);
        exit;
    }

    $controller = new Estado();
    $controller->nome = $nome;

    // Tentar cadastrar
    if ($controller->cadastrar()) {
        echo json_encode(['message' => 'Estado cadastrado com sucesso']);
    } else {
        http_response_code(500);
        echo json_encode(['message' => 'Erro ao cadastrar o estado!']);
    }
} else {
    http_response_code(405);
    echo json_encode(['message' => 'Método não permitido']);
}
?>
