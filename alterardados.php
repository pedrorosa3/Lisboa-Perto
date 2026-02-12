<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style1.css">
    <title>Lisboa+Perto</title>
</head>
<body>
  <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
        <div class="container-fluid">
          <a class="navbar-brand" href="home.php">Lisboa+Perto</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="mynavbar">
            <ul class="navbar-nav me-auto">
              <!--
              <li class="nav-item">
                <a class="nav-link" href="javascript:void(0)">Histórico</a>
              </li>
                -->
              <li class="nav-item">
                <a class="nav-link" href="alterardados.php"><button class="btn btn-secondary">Alterar os seus Dados</button></a>
        
              </li>

              <li class="nav-item">
                <a class="nav-link" href="registarocorrencia2.php"><button class="btn btn-secondary">Registar Ocorrência </button></a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="pesquisaocorrencia.php"><button class="btn btn-secondary">Pesquisa Ocorrência </button></a>
              </li>
              
            </ul>
            <?php 
              session_start();
              echo ' <button class="btn btn-secondary" id="nomeutilizadores"> ' . $_SESSION['nomeutilizador'] . "</button> ";

            ?> 
            <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
                <input class="btn btn-secondary" id = "logout" type="submit" name="logout" value="LogOut">
            </form>
  </nav>
  <div id="titulos"class="container p-5 my-5 bg-dark text-white">
        <h1 class="text-center">Alteração dos dados</h1>
    </div>
    <div id="morada" class="container">
        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
            <label for="altermorada">Coloque a sua nova morada:</label><br>
            <input type="text" name="altermorada" id="altermorada">
            <input  class="btn btn-secondary"type="submit" name="salvar" value="Salvar Dados">
        </form>
        
    </div>  

</body>
</html>
<?php
    
    $email=$_SESSION["username"];
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST["salvar"])){
            $morada=$_POST["altermorada"];
            include "abreconexao.php";
            $sql="UPDATE utilizador SET morada='$morada' WHERE email='$email'";
            if(mysqli_query($conn,$sql)){
                echo"<div id='alertssuccess'class='container mt-3'>";
                echo" <p>Morada alterada com Sucesso</p>";
                echo"</div>";
            }
            else{
              echo"<div id='alertssuccess'class='container mt-3'>";
              echo" <p>Fail: ".mysqli_error($conn)."</p>";
              echo"</div>";
              
            }
            
            mysqli_close($conn);

        }
        

    }
    if ( $_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST["logout"])){
          session_destroy();
          header("Location: index.php");
        }
      }

?>