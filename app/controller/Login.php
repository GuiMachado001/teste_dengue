<?php

require_once __DIR__ . '/../model/Database.php';

class Login{
    public function autenticar($email, $senha){
        $db = new Database('usuario');
        $login = $db->select("email = '$email'")->fetchObject();

        // Validação simples, sem hash
        if ($login && $login->senha === $senha) {
            return $login;
        } else {
            return null;
        }
    }


        // validação com criptografia
    // public function autenticar($email, $senha){
    //     $db = new Database('login');

    //     $login = $db->select("email = '$email'")->fetchObject();

    //     if($login && password_verify($senha, $login->senha)){
    //         return $login;
    //     }else{
    //         return null;
    //     }
    // }
}