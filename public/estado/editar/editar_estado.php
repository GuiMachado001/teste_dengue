<?php

require_once '../../../app/controller/estado.php';

$data = json_decode(file_get_contents('php://input'), true);

if(!$data || !isset($data['id_estado']) || !isset($data['nome'])){
    echo 'dados inválidos';
    exit;
}

$estado = new Estado();
$estado->id_estado = intval($data['id_estado']);
$estado->nome = $data['nome'];

if($estado->atualizar()){
    echo json_encode(['success' => true, 'message' => 'Estado atualizado com sucesso']);
}else{
    echo 'Erro ao atualizar o estado.';
}