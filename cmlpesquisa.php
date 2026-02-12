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
        <h1 class="text-center">Pesquisar Relatórios de Ocorrências</h1>
    </div>
    <div id="morada" class="container">
        <div class="col-12 col-sm-8 col-md-6 m-auto">
            <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
                <label for="categoria" class="form-label">Categoria</label>
                <select name="categoria" class="form-select">
                    <option disabled selected value> -- seleciona uma opção -- </option>
                    <option>Acidentes de Transito</option>
                    <option>Defeitos na via publica</option>
                    <option>Riscos de causas naturais</option>
                
                </select>
                <input class="btn btn-secondary" type="submit" name="filtrocategoria" value="Pesquisar"><br>
                <br>
                <label for="estado" class="form-label">Estado</label><br>
                <select name="estado" class="form-select">
                    <option disabled selected value> -- seleciona uma opção -- </option>
                    <option>Por Resolver</option>
                    <option>A ser Resolvido</option>
                    <option>Resolvido</option>

                </select>
                <input class="btn btn-secondary" type="submit" name="filtroestado" value="Pesquisar"><br>
                <br>
                <label for="localidade" class="form-label">Localidade</label><br>
                <input type="text" name="localidade" placeholder="Localidade">
                <input class="btn btn-secondary" type="submit" name="filtrolocalidade" value="Pesquisar"><br>
            </form>
        </div>
    </div>  
</body>
</html>
<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        if (isset($_POST["filtrocategoria"])){
            
            include("abreconexao.php");

            $pesquisa = $_POST["categoria"];
            //echo $pesquisa;
            $sql="SELECT * FROM ocorrencia,subcategorias,categorias,estado WHERE ocorrencia.subcategoria=subcategorias.id AND subcategorias.categoria=categorias.id AND categorias.nome='$pesquisa' AND ocorrencia.idestado=estado.id";
            $result=mysqli_query($conn,$sql);

            if(mysqli_num_rows($result)>0){
                echo "<div id='resultados'class='container mt-3'>";
                echo "<table class='table table-dark table-hover'><tr><th>Localidade</th><th>Gravidade</th><th>Urgência</th><th>Estado</th></tr>";
                while($row= mysqli_fetch_assoc($result)){
                    echo "<tr><td>".$row["localidade"]."</td><td>".$row["gravidade"]."</td><td>".$row["urgencia"]."</td><td>".$row["nome_estado"]."</td></tr>";
                    
                };
                echo "</table>";
                echo "</div>";
                
            }
            else{
                echo "<div id='alerts' class='container mt-3' >";
                echo "  <p>0 ocorrências encontradas</p>";
                echo "</div>";
            }
            mysqli_close($conn);
            
        }

        if(isset($_POST["filtroestado"])){

            include("abreconexao.php");

            $pesquisa = $_POST["estado"];

            //echo "<h1>".$pesquisa."</h1>";

            $sql="SELECT * FROM ocorrencia,estado WHERE estado.nome_estado='$pesquisa' AND ocorrencia.idestado=estado.id";

            $result=mysqli_query($conn,$sql);

            
            if(mysqli_num_rows($result)>0){
                echo "<div id='resultados'class='container mt-3'>";
                echo "<table class='table table-dark table-hover'><tr><th>Localidade</th><th>Gravidade</th><th>Urgência</th><th>Estado</th></tr>";
                while($row= mysqli_fetch_assoc($result)){
                    echo "<tr><td>".$row["localidade"]."</td><td>".$row["gravidade"]."</td><td>".$row["urgencia"]."</td><td>".$row["nome_estado"]."</td></tr>";
                    
                };
                echo "</table>";
                echo "</div>";

                
            }

            else{
                echo "<div id='alerts' class='container mt-3' >";
                echo "  <p>0 ocorrências encontradas</p>";
                echo "</div>";
                
            }
            
            mysqli_close($conn);
        }

        if(isset($_POST["filtrolocalidade"])){
            include("abreconexao.php");

            $pesquisa = $_POST["localidade"];
            $sql="SELECT * FROM ocorrencia,estado WHERE localidade LIKE '%$pesquisa%' AND ocorrencia.idestado=estado.id";
            $result=mysqli_query($conn,$sql);

            if(mysqli_num_rows($result)>0){
                echo "<div id='resultados'class='container mt-3'>";
                echo "<table class='table table-dark table-hover'><tr><th>Localidade</th><th>Gravidade</th><th>Urgência</th><th>Estado</th></tr>";
                while($row= mysqli_fetch_assoc($result)){
                    echo "<tr><td>".$row["localidade"]."</td><td>".$row["gravidade"]."</td><td>".$row["urgencia"]."</td><td>".$row["nome_estado"]."</td></tr>";
                    
                };
                echo "</table>";
                echo "</div>";

                
            }
            else{
                echo "<div id='alerts' class='container mt-3' >";
                echo "  <p>0 ocorrências encontradas nessa localidade</p>";
                echo "</div>";     
            }
            mysqli_close($conn);
        }   
        else{
            //echo "<div id='alerts' class='container mt-3' >";
            //echo "  <p>ERRO!</p>";
            //echo "</div>"; 
        }
    }
    
    
?>