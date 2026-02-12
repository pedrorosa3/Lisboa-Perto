<!DOCTYPE html> 
<html lang="en"> 
    <head> 
        <meta charset="UTF-8"> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="style1.css"> 
        <link rel="stylesheet" href="style33.css">
        <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
        
        <title>Lisboa + Perto</title> 

        <style> 
            #map {
                height: 400px;
                margin: 10px 0;
            }
            body { font-family: Arial, sans-serif; }
        
            form {
                width: 300px;
                margin: 0 auto;
            }
        
            label {
                display: block;
                margin-top: 10px;
            }
        
            input[type="text"],
            input[type="file"] {
                width: 100%;
                padding: 5px;
            }
        
            textarea {
                width: 100%;
                height: 100px;
            }

            select {
             width: 100%;
                padding: 5px;
            }
        
            button {
                background-color: blue;
                color: white;
                border: none;
                padding: 10px;
                cursor: pointer;
                margin-top: 10px;
            }
        </style>
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
                    echo ' <p class="btn btn-secondary" id="nomeutilizadores"> ' . $_SESSION['nomeutilizador'] . "</p> ";
                    if ( $_SERVER["REQUEST_METHOD"] == "POST"){
                        if(isset($_POST["logout"])){
                        session_destroy();
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

        <br>

        <div id="caixa">

            <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post" enctype="multipart/form-data"> 
                <h1>Registar Ocorrência</h1> 
                <label for="categoria">Categoria:</label> 
                <select id="categoria" name="categoria" required> 
                    <option value="">Selecione uma categoria</option>
                    <?php
                        session_start();
                        include "abreconexao.php";

                        $sql= "SELECT * FROM categorias ";
                        $result=mysqli_query($conn,$sql);
                        
                        if(mysqli_num_rows($result)>0){
                            while($row= mysqli_fetch_assoc($result)){
                                
                                echo "<option value='".$row['nome']."'>". $row["nome"]."</option>";
                                
                                            
                            };
                            
                            
                        }
                        mysqli_close($conn);

                        
                    ?>  
                    
                </select>
                        
                <label for="subcategoria">Subcategoria:</label>
                <select id="subcategoria" name="subcategoria" required>
                    <option value="">Selecione uma subcategoria</option>
                    
                    
                </select>
            
                <label for="descricao">Descrição:</label>
                <textarea id="descricao" name="descricao" required minlength="5"></textarea>
            
                <label for="fileToUpload">Foto da ocorrência:</label>
                <input type="file" id="fileToUpload" name="fileToUpload" accept="image/*" required>

                <label for="mapa">Mapa:</label>
                <div id="map"></div>
                
                <label for="latitude">Latitude:</label>
                <input type="text" id="latitude" name="latitude" readonly required>

                <label for="longitude">Longitude:</label>
                <input type="text" id="longitude" name="longitude" readonly required>

                <label for="moradaa">Rua:</label>
                <input type="text" id="moradaa" name="moradaa" readonly required>

                <label for="localidade">Localidade:</label>
                <input type="text" id="localidade" name="localidade" readonly required>

                
            
                <input type="submit" class="btn btn-primary my-2" name="submit" id="submit" value="Registar">
                </form>

                <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
                    <script>
                        document.addEventListener("DOMContentLoaded", function () {
                            var map = L.map('map').setView([38.7071,  -9.13549], 10);

                            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                attribution: '© OpenStreetMap contributors'
                            }).addTo(map);

                            var marker;

                            map.on('click', function (e) {
                                var lat = e.latlng.lat;
                                var lng = e.latlng.lng;

                                if (marker) {
                                    map.removeLayer(marker);
                                }

                                marker = L.marker([lat, lng]).addTo(map);

                                document.getElementById('latitude').value = lat;
                                document.getElementById('longitude').value = lng;
                               
                                fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`)
                                    .then(response => response.json())
                                    .then(data => {
                                        document.getElementById('moradaa').value = data.address.road || '';
                                        document.getElementById('localidade').value = data.address.city || data.address.town || data.address.village || '';
                                    })
                                    .catch(error => console.error('Error:', error));
                            });
                        });
                    </script>
        </div>
    <script src="comportamento.js"></script>
    </body> 
</html>

<?php
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["submit"])){
            $pasta = "./uploads/";
            $arquivo=$_FILES["fileToUpload"];

            $nomedoarquivo=$arquivo["name"];
            $novonomearquivo=uniqid();
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($nomedoarquivo,PATHINFO_EXTENSION));
            
            $target_file=$pasta.$novonomearquivo.".".$imageFileType;
            
            
            // Check if file already exists
            if (file_exists($target_file)) {
                echo "<div id='alerts' class='container mt-3' >";
                echo "  <p>Já existe um ficheiro com esse nome</p>";
                echo "</div>";
                
                $uploadOk = 0;
            }

            // Check file size
            if ($arquivo["size"] > 500000) {
                echo "<div id='alerts' class='container mt-3' >";
                echo "  <p>O tamanho do ficheiro é demasiado grande.</p>";
                echo "</div>";
                
                $uploadOk = 0;
            }

            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
                echo "<div id='alerts' class='container mt-3' >";
                echo "  <p>Apenas são suportados os formatos jpg,jpeg,png,gif</p>";
                echo "</div>";
                
                $uploadOk = 0;
            }
            
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "<div id='alerts' class='container mt-3' >";
                echo "  <p>Não foi possível dar upload ao seu ficheiro!</p>";
                echo "</div>";
            
            // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($arquivo["tmp_name"], $target_file)) {
                    echo "<div id='alertssuccess' class='container mt-3' >";
                    echo "  <p>A ocorrencia foi registada com sucesso</p>";
                    echo "</div>";
                    //echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
                    include "abreconexao.php";
                    $subcategorianome=$_POST["subcategoria"];
                    $sql="SELECT * FROM subcategorias WHERE nome='$subcategorianome'";
                    $result=mysqli_query($conn,$sql);
                    if(mysqli_num_rows($result) == 1){
                        while ($row =mysqli_fetch_assoc($result)){
                            $subcategoria=$row["id"];
                        }
                    }
                    $nomeutilizador=$_SESSION["nomeutilizador"];
                    $sql="SELECT * FROM utilizador WHERE nome='$nomeutilizador'";
                    $result=mysqli_query($conn,$sql);
                    if(mysqli_num_rows($result) == 1){
                        while ($row =mysqli_fetch_assoc($result)){
                            $idutilizador=$row["id"];
                        }
                    }


                    $descricao=$_POST["descricao"];
                    $foto=$novonomearquivo.".".$imageFileType;
                    $morada=$_POST["moradaa"];
                    $localidade=$_POST["localidade"];
                    $latitude = $_POST['latitude'];
                    $longitude = $_POST['longitude'];
                    $localizacao = $latitude . ';' . $longitude;
                    $idestado=1;
                    
                    $stmt = $conn->prepare( "INSERT INTO ocorrencia (subcategoria,descricao,foto,morada,localidade,idestado,idutilizador,localizacao) VALUES (?,?,?,?,?,?,?,?)" );
                    $stmt->bind_param("issssiis",$subcategoria,$descricao,$foto,$morada,$localidade,$idestado,$idutilizador,$localizacao);
                    $stmt->execute();
                     
                    
                    $stmt->close();
                    $estado=1;
                    $sql="SELECT COUNT(*) FROM ocorrencia ";
                    $result=mysqli_query($conn,$sql);
                    if(mysqli_num_rows($result) == 1){
                        while ($row =mysqli_fetch_assoc($result)){
                            $idocorrencia=$row["COUNT(*)"];
                        }
                    }


                    
                    $stmt = $conn->prepare( "INSERT INTO mudancaEstado (ocorrencia,estado) VALUES (?,?)" );
                    $stmt->bind_param("ii",$idocorrencia,$estado);
                    $stmt->execute();
                    
                    
                    $stmt->close();

                    $conn->close();
                    
                    
                } else {
                    echo "<div id='alerts' class='container mt-3' >";
                    echo "  <p>Houve um problema ao registar a sua ocorrência!</p>";
                    echo "</div>";
                    //echo "Sorry, there was an error uploading your file.";
                }
                

                
            }
            
        }
        
    }
?>