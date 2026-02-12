<?php
    session_start();
    $idocorrencia = isset($_GET['idocorrencia']) ? $_GET['idocorrencia'] : null;
?>
<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="style1.css">
        <title>Alterar Estado da Ocorrência</title>
        <style>
            
            .form-container {
                background-color: #ffffff;
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }
            .form-container h2 {
                margin-top: 0;
                text-align: center;
            }
            .form-container label {
                display: block;
                margin-bottom: 10px;
                font-weight: bold;
            }
            .form-container select,
            .form-container input[type="number"] {
                width: 100%;
                padding: 10px;
                margin-bottom: 20px;
                border: 1px solid #ccc;
                border-radius: 5px;
            }
            .form-container button {
                width: 100%;
                padding: 10px;
                background-color: #007BFF;
                color: #fff;
                border: none;
                border-radius: 5px;
                font-size: 16px;
                cursor: pointer;
            }
            .form-container button:hover {
                background-color: #0056b3;
            }
        </style>

        <script>  

            var idocorrencia = "<?php echo $idocorrencia; ?>";
            <?php
                include("abreconexao.php");
                $sql="SELECT * FROM ocorrencia WHERE id='$idocorrencia'";
                $result=mysqli_query($conn,$sql);
                if(mysqli_num_rows($result) == 1){
                    while ($row =mysqli_fetch_assoc($result)){

                        $estadoocorrencia=$row["idestado"];
                        $urgenciaocorrencia=$row["urgencia"];
                        $gravidadeocorrencia=$row["gravidade"];
                        if ($estadoocorrencia==1){
                            $estadoocrnome="Por Resolver";
            
                        }
                        if ($estadoocorrencia==2){
                            $estadoocrnome="A ser Resolvido";
            
                        }
                        if ($estadoocorrencia==3){
                            $estadoocrnome="Resolvido";
            
                        }

                    }
                }

            ?>

            function showOcr() {
                document.getElementById("show").innerText = "ID Ocorrência:" + idocorrencia +"\n Estado Atual:\n Estado: " + "<?php echo $estadoocrnome; ?>" + "\n Gravidade: "+"<?php echo $gravidadeocorrencia; ?>"+"\nUrgência: "+"<?php echo $urgenciaocorrencia; ?>";
            }

        </script>

    </head>

    <body onload="showOcr()">
        <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
            <div class="container-fluid">
            <a class="navbar-brand" href="cml.php">Lisboa+Perto</a>
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
                    
                        
                        
                        
                    </ul>
                    <?php 

                        
                        

                        echo ' <p class="btn btn-secondary" id="nomeutilizadores"> ' . "Funcionário CML" . "</p> ";
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
        <div class="form-container">
            <h2>Alterar Estado da Ocorrência</h2>
            <p id="show"></p>
            <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post" id="estadoForm">
                <label for="estado">Estado:</label>
                <select id="estado" name="estado">
                    <option value="resolvido">Resolvido</option>
                    <option value="a_resolver">A ser Resolvido</option>
                    <option value="por_resolver">Por Resolver</option>
                </select>
                
                <label for="gravidade">Gravidade:</label>
                <select id="gravidade" name="gravidade">
                    <option value="Fraca">Fraca</option>
                    <option value="Moderada">Moderada</option>
                    <option value="Grave">Grave</option>
                    <option value="Muito Grave">Muito Grave</option>
                </select>
                
                <label for="urgencia">Urgência (1 a 5):</label>
                <input type="number" id="urgencia" name="urgencia" min="1" max="5">
                
                <input type="submit" class="btn btn-primary my-2" name="submit" id="submit" value="Registar Alteração">
            </form>
        </div>
        
    </body>
</html>

<?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["submit"])){
            include("abreconexao.php");

            $estado=$_POST["estado"];
            $gravidade=$_POST["gravidade"];
            $urgencia=$_POST["urgencia"];
            $urgencia=strval($urgencia);
            
            
            if ($estado=="resolvido"){
                $estadonome=3;

            }
            if ($estado=="a_resolver"){
                $estadonome=2;

            }
            if ($estado=="por_resolver"){
                $estadonome=1;

            }


            
            $sql="SELECT * FROM ocorrencia WHERE id='$idocorrencia'";
            $result=mysqli_query($conn,$sql);
            if(mysqli_num_rows($result) == 1){
                while ($row =mysqli_fetch_assoc($result)){

                    $estadoocr=$row["idestado"];
                    $urgenciaocr=$row["urgencia"];
                    $gravidadeocr=$row["gravidade"];

                }
            }

            

            if($estadonome!=$estadoocr){

                $stmt = $conn->prepare( "INSERT INTO mudancaEstado (ocorrencia,estado) VALUES (?,?)" );
                $stmt->bind_param("ss",$idocorrencia,$estadonome);
                $stmt->execute();
                $stmt->close();

            }

            


            $stmt = $conn->prepare( "UPDATE ocorrencia SET idestado=?, urgencia=?, gravidade=? WHERE id=?" );
            $stmt->bind_param("sssi",$estadonome,$urgencia,$gravidade,$idocorrencia);
            $stmt->execute();
            $stmt->close();
            echo "<div id='alertssuccess' class='container mt-3' >";
            echo "  <p> Ocorrência alterada com sucesso!</p>";
            echo "</div>";
            

        }
    }
?>