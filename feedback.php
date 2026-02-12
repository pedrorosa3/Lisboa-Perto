<?php
    session_start();
    $idocorrencia = isset($_GET['idocorrencia']) ? $_GET['idocorrencia'] : null;
    $usermail = isset($_GET['userid']) ? $_GET['userid'] : null;
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="style1.css">
        <title>Feedback Form</title>
        <style>
            body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            }
            .container {
            width: 300px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: grey;
            }
            h1 {
            text-align: center;
            margin-bottom: 20px;
            }
            label {
            display: block;
            margin-bottom: 5px;
            }
            input[type="text"],
            input[type="email"],
            textarea {
            width: 100%;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 3px;
            }
            textarea {
            height: 100px;
            }
            input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 3px;
            cursor: pointer;
            margin-top: 10px;
            }
        </style>

        <script>
            
            var idocorrencia = "<?php echo $idocorrencia; ?>";
            var userid = "<?php echo $usermail; ?>";

            function showFeedback() {
                document.getElementById("showfeedback").innerText = "Ocorrência: " + idocorrencia + "\n Utilizador: " + userid;
            }
   
        </script>
        
    </head>
    

   
    <body onload="showFeedback()">
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
        <div class="container">
            <h1>Feedback Form</h1>
            <p id="showfeedback"><p>
            <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
                <label for="rating">Classificação:</label>
                <select id="rating" name="rating" required>
                    <option value="" aria-disabled="true">Select a rating</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option><br>
                </select>
                    

                <label for="feedback">Feedback:</label>
                <textarea id="feedback" name="feedback" required></textarea>
                <input type="submit" class="btn btn-primary my-2" name="submit" id="submit" value="Registar Feedback"> 
            </form>
        </div>
    
    </body>
</html>

<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["submit"])){
            include("abreconexao.php");
            $rating=$_POST["rating"];
            $feedback=$_POST["feedback"];
            
            $sql="SELECT * FROM utilizador WHERE email='$usermail'";
            $result=mysqli_query($conn,$sql);
            if(mysqli_num_rows($result) == 1){
                while ($row =mysqli_fetch_assoc($result)){
                    $userid=$row["id"];

                }
            }


            $stmt = $conn->prepare( "INSERT INTO feedback (mensagem,rating,idutilizador,idocorrencia) VALUES (?,?,?,?)" );
            $stmt->bind_param("siii",$feedback,$rating,$userid,$idocorrencia);
            $stmt->execute();
            $stmt->close();
            echo "<div id='alertssuccess' class='container mt-3' >";
            echo "  <p>Feedback registado com sucesso!</p>";
            echo "</div>";
            

        }
    }
?>

