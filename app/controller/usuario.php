<?php

require_once __DIR__ . '/../model/Database.php';

class Usuario{
    public function autenticar($email, $senha){
        $db = new Database('usuario');
        $usuario = $db->select("email = '$email'")->fetchObject();

        // Validação simples, sem hash
        if ($usuario && $usuario->senha === $senha) {
            return $usuario;
        } else {
            return null;
        }
    }


        // validação com criptografia
    // public function autenticar($email, $senha){
    //     $db = new Database('usuario');

    //     $usuario = $db->select("email = '$email'")->fetchObject();

    //     if($usuario && password_verify($senha, $usuario->senha)){
    //         return $usuario;
    //     }else{
    //         return null;
    //     }
    // }
}