<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

try {
    require_once '../../../app/controller/Escola.php';

    if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
        http_response_code(405);
        echo json_encode(['success' => false, 'message' => 'Método não permitido']);
        exit;
    }

    $input = json_decode(file_get_contents('php://input'), true);
    $id_escola = $input['id_escola'] ?? null;

    if (!$id_escola) {
        echo json_encode(['success' => false, 'message' => 'Id não fornecido']);
        exit;
    }

    $escola = new Escola();
    $escola->id_escola = $id_escola;

    $resultado = $escola->excluir();

    if ($resultado === true) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Esta escola possui séries vinculadas. Exclua as séries antes de excluir a escola.'
        ]);
    }
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Erro no servidor: ' . $e->getMessage()
    ]);
}
