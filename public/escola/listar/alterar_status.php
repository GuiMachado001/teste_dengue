<?php
header('Content-Type: application/json');

require_once '../../../app/controller/Escola.php';

$input = json_decode(file_get_contents("php://input"), true);
$id = $input['id_escola'] ?? null;
$ativo = $input['ativo'] ?? null;

if (!$id || ($ativo !== 0 && $ativo !== 1 && $ativo !== '0' && $ativo !== '1')) {
    echo json_encode(['success' => false, 'message' => 'Dados inválidos']);
    exit;
}

try{
    $escola = new Escola();
    $escola->id_escola = $id;

    if((int)$ativo === 1){
        $res = $escola->ativar();
    }else {
        $res = $escola->inativar();
    }
    echo json_encode(['success' => $res]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}