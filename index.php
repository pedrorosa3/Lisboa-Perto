
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
          <a class="navbar-brand" href="index.php">Lisboa+Perto</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="mynavbar">
            <ul class="navbar-nav me-auto">
              <!--
              <li class="nav-item">
                <a class="nav-link" href="javascript:void(0)">Histórico</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="javascript:void(0)">Recentes</a>
              </li>
              -->
              <li class="nav-item">
                <a class="nav-link" href="registo.php"><button class="btn btn-secondary">Registar</button></a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="login.php"><button class="btn btn-secondary">Login</button></a>
              </li>
            </ul>
            <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post" class="d-flex">
              <input class="form-control me-2" type="text" name="item" placeholder="Pesquisa">
              <input type="submit" name="pesquisa" value="Pesquisa" class="btn btn-primary">
            </form>
          </div>
        </div>
      </nav>  
</body>
</html>

<?php
  session_start();
  if (isset($_SESSION["username"])){
    header("Location: home.php");
  }
    
  if ( $_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST["pesquisa"])){
      include("abreconexao.php");

      $pesquisa = $_POST["item"];
            
      $sql= "SELECT * FROM ocorrencia,estado WHERE ( localidade LIKE'%$pesquisa%' OR morada  LIKE '%$pesquisa%') AND ocorrencia.idestado=estado.id";
      $result=mysqli_query($conn,$sql);

      if(mysqli_num_rows($result)>0){
        echo "<div id='resultados'class='container mt-3'>";
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
        echo " <p>Não foram encontradas ocorrências nessa morada/localidade.</p>";  
        echo "</div>";      
      }
      mysqli_close($conn);
    }
        
        

  }
        

?>