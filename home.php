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
                
            
          
            
          </div>
        </div>
      </nav>  
</body>
</html>
<?php
  
 
  if ( $_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST["logout"])){
      session_destroy();
      header("Location: index.php");
    }
  }
  include("abreconexao.php");
  $nome=$_SESSION["username"];
  $sql= "SELECT * FROM utilizador WHERE email='$nome'";
  $result=mysqli_query($conn,$sql);
  if(mysqli_num_rows($result) == 1){
    while ($row =mysqli_fetch_assoc($result)){
      $_SESSION["id"]=$row["id"];
    }
  }

  $idutilizador=$_SESSION["id"];
  
  $sql= "SELECT * FROM ocorrencia,estado WHERE ocorrencia.idutilizador ='$idutilizador' AND  ocorrencia.idestado =estado.id";
  $result=mysqli_query($conn,$sql);
  if(mysqli_num_rows($result)>0){
    
    echo "<div id='resultados'>";
    echo "<h1 id='cabecalho'>Resultado da Pesquisa:</h1><br>";
    echo "<table class='table table-dark table-hover'><tr><th>Localidade</th><th>Gravidade</th><th>Urgência</th><th>Estado</th></tr>";
    while($row= mysqli_fetch_assoc($result)){
      echo "<tr><td>".$row["localidade"]."</td><td>".$row["gravidade"]."</td><td>".$row["urgencia"]."</td><td>".$row["nome_estado"]."</td></tr>";
                
    };
    echo "</table>";
    echo "</div>";

            
  }
  else{
    echo "<div id='alerts'class='container mt-3'>";
    echo " <p>Não foram encontradas ocorrências criadas pelo utilizador e por resolver.</p>";  
    echo "</div>";      
  }
  mysqli_close($conn);
    
?>