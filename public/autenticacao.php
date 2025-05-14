<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require __DIR__ . '/../app/controller/Login.php';


if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $loginObj = new Login();
    $usuario = $loginObj->autenticar($email, $senha);

    if($usuario){
        $_SESSION['usuario'] = [
            'id' => $usuario->id_usuario,
            'nome' => $usuario->nome,
            'perfil' => $usuario->id_perfil
        ];
header('Location: ./estado/listar/estados.php');

        exit;
    } else{
        header('Location: index.php?erro=1');
        exit;
    }
}