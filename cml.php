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
          <a class="navbar-brand" href="cml.php">Lisboa+Perto</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="mynavbar">
            <ul class="navbar-nav me-auto">
            
            <li class="nav-item">
                <a class="nav-link" href="cmlpesquisa.php"><button class="btn btn-secondary">Pesquisar Ocorrência</button></a>
              </li>

            </ul>

            <?php 
              session_start();
              echo ' <button class="btn btn-secondary" id="nomeutilizadores"> ' . "Funcionário CML" . "</button> ";
              if ( $_SERVER["REQUEST_METHOD"] == "POST"){
                if(isset($_POST["logout"])){
                header("Location: index.php");
                }
            }

            ?>
            <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
                <input class="btn btn-secondary" id = "logout" type="submit" name="logout" value="LogOut">
            </form> 
            
          </div>
        </div>
    </nav>
    <div id="titulos"class="container p-5 my-5 bg-dark text-white">
        <h1 class="text-center">Interface de Ocorrências</h1>
    </div>
    <script src="comportamento2.js"></script>

</body>
</html>
<?php

  include("abreconexao.php");

  $sql = "SELECT ocorrencia.descricao,ocorrencia.localidade,ocorrencia.gravidade,ocorrencia.urgencia,estado.nome_estado,ocorrencia.id FROM ocorrencia, estado WHERE ocorrencia.idestado =estado.id";
  $result=mysqli_query($conn,$sql);
  if(mysqli_num_rows($result)>0){
    echo "<div id='resultados'class='container mt-3'>";
    echo "<h1 id='cabecalho'>Resultado da Pesquisa:</h1><br>";
    echo "<table class='table table-dark table-hover'><tr><th>Localidade</th><th>Descrição</th><th>Urgência</th><th>Estado</th><th>Editar</th></tr>";
    while($row= mysqli_fetch_assoc($result)){
      echo "<tr><td>".$row["localidade"]."</td><td>".$row["descricao"]."</td><td>".$row["urgencia"]."</td><td>".$row["nome_estado"]."</td><td><input type='submit' name='submit' id='submit' value='Editar' onclick='openEdit(".$row["id"].")'></tr></tr>";
                
    };
    echo "</table>";
    echo "</div>";

            
  }
  mysqli_close($conn);
?>