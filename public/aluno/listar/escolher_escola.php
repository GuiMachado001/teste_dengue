<?php require_once __DIR__ . '/../../../app/helpers/auth.php'; ?>

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
    <link rel="stylesheet" href="../../../assets/css/aluno_css/escolher_escolas.css">
    <link rel="stylesheet" href="../../../assets/css/aluno_css/style.css">

    <!-- variável JS com valor do PHP -->
    <script>
      const perfilUsuario = <?= $perfilUsuario ?>;
    </script>

    <!-- Js do alert sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Js da pagina -->
     <!-- <script src="../../../assets/js/aluno_js/escolher_aluno.js" defer></script> -->
     <script src="../../../assets/js/aluno_js/escolher_escola.js" defer></script>

    <!-- Fonte -->
     <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

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
                  <li><a class="dropdown-item" href="">Listar</a></li>
                  <?php if($perfilUsuario == 1) { ?>
                    <li><a class="dropdown-item" href="../cadastrar/cadastrar_cidade.php">Cadastrar</a></li>
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

              <!-- Dropdown serie -->
              <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle title_dropdown" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      Serie
                  </a>
                  <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="../../serie/listar/escolher_escola.php">Listar</a></li>
                    <?php if($perfilUsuario == 1) { ?>
                      <li><a class="dropdown-item" href="../../serie/cadastrar/cadastrar_serie.php">Cadastrar</a></li>
                    <?php } ?>
                  </ul>
              </li>

              <!-- Dropdown aluno -->
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle title_dropdown" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Aluno
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <li><a class="dropdown-item" href="">Listar</a></li>
                  <?php if($perfilUsuario == 1) { ?>
                    <li><a class="dropdown-item" href="../cadastrar/cadastrar_aluno.php">Cadastrar</a></li>
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

<div class="container_btn_cadastrar_aluno">
    <button 
        class="btn_cadastrar_aluno" 
        <?php if($perfilUsuario != 1) echo 'disabled style="background-color: grey; cursor: not-allowed;"'; ?>>
        Cadastrar
    </button>
</div>
        
        <div class="container_title_pagina">
          <span class="span_container_title_pagina">
            <div class="container_img">
              <img src="../../../assets/img/mosquito.png" alt="">
            </div>
              Listar Alunos
            <div class="container_img">
              <img src="../../../assets/img/mosquito.png" alt="">
            </div>
          </span>
        </div>




        <div class="container_explicacao">
          <span>Esolha a escola para listar os alunos</span>
        </div>

        <div class="container_escolas_cadastradas" id="listas_de_escola">

          <div class="card_escola" id="escola">
            <div class="container_icon">
              <img class="icon_escola" src="../../../assets/img/icons/icon_escola.svg" alt="">
            </div>

            <div class="nome_escola">
              <span>Nome Da Escola Aqui</span>
            </div>
          </div>

 

        </div>
      
        </section>
  
</body>
</html>