
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agente 360</title>
    
    <!-- img topo do site -->
    <link rel="shortcut icon" type="image/png" href="../assets/img/logo_agente360.jpg">

    <!-- Css da pagina -->
    <link rel="stylesheet" href="../assets/css/login_css/login.css">
    
    <!-- Js do alert sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Js da pagina -->
     <script src="../assets/js/login_js/login.js"></script>



</head>

<body>

    <div class="loginBox">
        <img class="user" src="../assets/img/mosquito.png" height="100px" width="100px">
        <h3>Faça o login aqui</h3>
        <form action="./autenticacao.php" method="POST">
            <div class="inputBox"> 
                <input id="uname" type="email" name="email" placeholder="Email" required>
                <input id="pass" type="password" name="senha" placeholder="Senha" required> 
            </div> 
            <input type="submit" name="Login" value="Login">
        </form>
    </div>


    <svg width="100%" height="100%" viewBox="0 0 1000 1000" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" overflow="auto" shape-rendering="auto" fill="#ffffff">
  <defs>
   <path id="wavepath" d="M 0 2000 0 500 Q 105 421 210 500 t 210 0 210 0 210 0 210 0 210 0 210 0  v1000 z" />
   <path id="motionpath" d="M -420 0 0 0" /> 
  </defs>
  <g >
   <use xlink:href="#wavepath" y="183" fill="#115473">
   <animateMotion
    dur="5s"
    repeatCount="indefinite">
    <mpath xlink:href="#motionpath" />
   </animateMotion>
   </use>
  </g>
</svg>
		
</body>

<?php if (isset($_GET['erro']) && $_GET['erro'] == 1): ?>
<script>
    Swal.fire({
        icon: 'error',
        title: 'Falha no login',
        text: 'Email ou senha inválidos!',
        confirmButtonColor: '#115473'
    });
</script>
<?php endif; ?>
</html>