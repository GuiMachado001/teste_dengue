<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: /TodosContraDengueWebSite/public/index.php');
    exit;
}

$perfilUsuario = $_SESSION['usuario']['perfil'];