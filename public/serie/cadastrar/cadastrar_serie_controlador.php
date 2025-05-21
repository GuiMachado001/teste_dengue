<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../../../app/controller/Serie.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $input = json_decode(file_get_contents('php://input'), true);
    $nome = $input['nome'] ?? '';
    $id_escola = $input['id_escola'] ?? '';
    
    if (!$nome || !$id_escola) {
        http_response_code(400);
        echo json_encode(['message' => 'Nome da serie e escola são obrigatórios.']);
        exit;
    }

    $controller = new Serie();
    $controller->nome = $nome;
    $controller->id_escola = $id_escola;

    // Tentar cadastrar
    if ($controller->cadastrar()) {
        echo json_encode(['message' => 'serie cadastrado com sucesso']);
    } else {
        http_response_code(500);
        echo json_encode(['message' => 'Erro ao cadastrar o serie!']);
    }
} else {
    http_response_code(405);
    echo json_encode(['message' => 'Método não permitido']);
}
?>
