<?php

require_once __DIR__ . '/../model/Database.php';

class Estado{
    public string $nome;

    public function cadastrar(){
        $db = new Database('estado');

        $res = $db->insert([
                'nome' => $this->nome
            ]
        );
        return $res;
    }
}