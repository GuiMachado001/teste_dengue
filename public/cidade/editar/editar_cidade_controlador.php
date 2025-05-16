<?php

require_once '../../../app/controller/cidade.php';

$data = json_decode(file_get_contents('php://input'), true);

if(!$data || !isset($data['id_cidade']) || !isset($data['nome'])){
    echo 'dados inválidos';
    exit;
}

$cidade = new Cidade();
$cidade->id_cidade = intval($data['id_cidade']);
$cidade->nome = $data['nome'];

if($cidade->atualizar()){
    echo json_encode(['success' => true, 'message' => 'cidade atualizado com sucesso']);
}else{
    echo 'Erro ao atualizar o cidade.';
}