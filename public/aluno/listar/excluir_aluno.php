<?php
// Ativa exibição de erros (apenas para ambiente de desenvolvimento)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Define que a resposta será JSON
header('Content-Type: application/json');

try {
    // Verifica o método da requisição
    if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
        http_response_code(405);
        echo json_encode([
            'success' => false,
            'message' => 'Método não permitido. Use DELETE.'
        ]);
        exit;
    }

    // Lê os dados JSON da requisição
    $input = json_decode(file_get_contents('php://input'), true);
    $id_aluno = $input['id_aluno'] ?? null;

    if (!$id_aluno || !is_numeric($id_aluno)) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'ID do aluno inválido ou não fornecido.'
        ]);
        exit;
    }

    // Carrega o controlador
    require_once '../../../app/controller/Aluno.php';

    $aluno = new Aluno();
    $aluno->id_aluno = $id_aluno;

    $resultado = $aluno->excluir();

    if ($resultado === true) {
        echo json_encode([
            'success' => true,
            'message' => 'Aluno excluído com sucesso.'
        ]);
    } else {
        http_response_code(409);
        echo json_encode([
            'success' => false,
            'message' => 'Não foi possível excluir o aluno. Verifique se há dados vinculados.'
        ]);
    }

} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Erro interno no servidor: ' . $e->getMessage()
    ]);
}
