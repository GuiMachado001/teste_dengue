<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: /teste_dengue/public/index.php');
    exit;
}

$perfilUsuario = $_SESSION['usuario']['perfil']; 
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agente 360</title>

    <!-- img topo do site -->
    <link rel="shortcut icon" type="image/png" href="../../../assets/img/logo_agente360.jpg">

    <!-- Link para o Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Link para o Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous" defer></script>

    <!-- Css da pagina -->
     <link rel="stylesheet" href="../../../assets/css/escola_css/style.css">
     <link rel="stylesheet" href="../../../assets/css/escola_css/cadastrar_escola.css">

         <!-- Js do alert sweetalert2 -->
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Js da pagina -->
     <script src="../../../assets/js/escola_js/escola.js" defer></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
          <div class="containerImgLogo">
            <img class="img_logo" src="../../../assets/img/logo_agente360.jpg" alt="">
          </div>
          
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
      
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">

      
              <!-- Dropdown Estado -->
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle title_dropdown" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Estado
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <li><a class="dropdown-item" href="../../estado/listar/estados.php">Listar</a></li>
                  <?php if($perfilUsuario == 1) { ?>
                    <li><a class="dropdown-item" href="../../estado/cadastrar/cadastrar_estado.php">Cadastrar</a></li>
                  <?php } ?>
                </ul>
              </li>
      
              <!-- Dropdown Cidade -->
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle title_dropdown" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Cidade
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <li><a class="dropdown-item" href="../../cidade/listar/listar_cidade.php">Listar</a></li>
                  <?php if($perfilUsuario == 1) { ?>
                    <li><a class="dropdown-item" href="">Cadastrar</a></li>
                  <?php } ?>
                </ul>
              </li>
      
              <!-- Dropdown Escola -->
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle title_dropdown" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Escola
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <li><a class="dropdown-item" href="../../escola/listar/listar_escola.php">Listar</a></li>
                  <?php if($perfilUsuario == 1) { ?>
                    <li><a class="dropdown-item" href="../../escola/cadastrar/cadastrar_escola.php">Cadastrar</a></li>
                  <?php } ?>
                </ul>
              </li>


              <li class="nav-item">
                <a class="nav-link title_dropdown" href="../../logout.php">Sair</a>
              </li>
              <!-- <a href="../../logout.php">Sair</a> -->
            </ul>
          </div>
        </div>
      </nav>


    <div class="cotainer_img_logo_fesp">
      <img class="img_logo_background" src="../../../assets/img/fesplogo.png" alt="">
    </div>
    <section class="main">
        <form id="form_cadastro_escola" method="POST" class="form_cadastrar_escola"> 

            <div class="continer_inp_nome">
                <div class="input-container">
                    <input type="text" id="input" name="nome" required="">
                    <label for="input" class="label">Nome da Escola</label>
                    <div class="underline"></div> 
                </div>
            </div>

            
            <div class="container_dropdown_estados">
            <label for="id_estado" class="form-label fw-semibold text-white">
                <i class="bi bi-geo-alt-fill me-1 text-primary"></i> Selecione o estado
            </label>
            <select class="form-select shadow-sm" name="id_estado" id="id_estado" required>
            <option value="" disabled selected>Selecionar...</option>
            </select>
            </div>
                        
            <div class="container_buttons">
              <button class="btn_cancelar" id="btn_cancelar"> Cancelar </button>
              <button class="btn_verde" type="submit" name="Cadastrar" > Cadastrar </button>
          </div>
        </form>
    </section>



</body>
</html>