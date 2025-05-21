<?php

require_once '../../../app/controller/Escola.php';

$data = json_decode(file_get_contents('php://input'), true);

if(!$data || !isset($data['id_escola']) || !isset($data['nome'])){
    echo 'dados inválidos';
    exit;
}

$escola = new Escola();
$escola->id_escola = intval($data['id_escola']);
$escola->nome = $data['nome'];

if($escola->atualizar()){
    echo json_encode(['success' => true, 'message' => 'escola atualizado com sucesso']);
}else{
    echo 'Erro ao atualizar o escola.';
}