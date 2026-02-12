<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Lisboa+Perto</title>
</head>
<body>
    <div class="container-fluid p-3 bg-primary text-white text-center">
        <h1>Lisboa+Perto</h1>
        
    </div>
    <div class="container mt-5 pt-5">
        <div class="row">
            <div class="col-12 col-sm-8 col-md-6 m-auto">
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <h1 class="text-center mx-auto">Login</h1>
                        <svg class="mx-auto" xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                            <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                        </svg>
                        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
                            <input type="email" name="email" id="email" class="form-control my-4 py-2" placeholder="Email" required>
                            <input type="password" name="passwd" id="passwd" class="form-control my-4 py-2" placeholder="Palavra Passe" required>
                            <div class="text-center mt-3">
                                
                                
                                <input type="submit" class="btn btn-primary my-2" value="Login" name="login" id="login">
                                
                            </div>
                        </form>
                        <a href="index.php"><button class="btn btn-secondary">Voltar</button></a>
                        <a href="registo.php"><p>Ainda não tens conta? Registo</p></a>

                    </div>
                </div>
            </div>
        </div>
    </div>

    
</body>
</html>

<?php
    session_start();
    if (isset($_SESSION["username"])){
        header("Location: home.php");
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["login"])){
            

            $email = $_POST["email"];
            $passwd = $_POST["passwd"];

        }

        checkmailwithpass($email,$passwd);
        
    }



    function checkmailwithpass($email,$passwd){

        include "abreconexao.php";
        
        $sql="SELECT * FROM utilizador WHERE email='$email'";
        $result=mysqli_query($conn,$sql);
        if(mysqli_num_rows($result) == 1){
            while ($row =mysqli_fetch_assoc($result)){
                if(password_verify($passwd,$row["passwd"])){
                    if($row["tipo"]=="utilizador"){
                        $_SESSION["username"]=$row["email"];
                        $_SESSION["nomeutilizador"]=$row["nome"];
                        header("Location: home.php");
                    }
                    else{
                        header("Location: cml.php");
                    }
                    
                }else{
                    echo "<div id='alerts' class='container mt-3' >";
                    echo "  <p>Password Incorreta!</p>";
                    echo "</div>";
                }
            }
            mysqli_close($conn);
        }else{
            echo "<div id='alerts' class='container mt-3' >";
            echo "  <p>Não existe nenhum utilizador com esse email!</p>";
            echo "</div>";
            mysqli_close($conn);
        }
            
            
               
    }
?>