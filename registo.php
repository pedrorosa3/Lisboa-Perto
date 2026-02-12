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
                        <h1 class="text-center mx-auto">Registo de Utilizador</h1>
                        <svg class="mx-auto" xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                            <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                        </svg>
                        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
                            <input type="text" name="nome" id="nome" class="form-control my-4 py-2" placeholder="Primeiro Nome" required>
                            <input type="text" name="apelido" id="apelido" class="form-control my-4 py-2" placeholder="Apelido" required>
                            <input type="tel" name="telemovel" id="telemovel" class="form-control my-4 py-2" placeholder="Telemóvel" required>
                            <input type="tel" name="nif" id="nif" class="form-control my-4 py-2" placeholder="NIF" required>
                            <input type="email" name="email" id="email" class="form-control my-4 py-2" placeholder="Email" required>
                            <input type="password" name="passwd" id="passwd" class="form-control my-4 py-2" placeholder="Palavra Passe" required>
                            <div class="text-center mt-3">
                                
                                
                                <input type="submit" class="btn btn-primary my-2" value="Registar" name="registar" id="registar">
                                
                            </div>
                        </form>
                        <a href="index.php"><button class="btn btn-secondary">Voltar</button></a>
                        <a href="login.php"><p id="irlogin">Já tens uma conta? Login</p></a>

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
    $flag=False;
    
    
    // Estabelece uma ligação com a base de dados usando o programa abreconexao.php
    // A variável $conn é inicializada com a ligação estabelecida
  
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["registar"])){
            $flag=False;
            $nome = test_input($_POST["nome"]);
            $apelido = test_input($_POST["apelido"]);
            $telemovel = test_input($_POST["telemovel"]);
            $nif = test_input($_POST["nif"]);
            $email = test_input($_POST["email"]);
            $passwd = test_input($_POST["passwd"]);

            $nome = $nome ." ". $apelido;

            // Validar Nome
            //echo "<div id='alerts' class='container mt-3'>";
            if (!preg_match("/^[a-zA-Z ]*$/", $nome)) {
                echo "<div id='alerts' class='container mt-3' >";
                echo "  <p>Nome inválido. Apenas letras e espaços são permitidos.</p>";
                echo "</div>";

                $flag=True;
            }

            // Validar Telemovel
            if (!filter_var($telemovel, FILTER_VALIDATE_INT) || strlen($telemovel) != 9) {
                echo "<div id='alerts' class='container mt-3' >";
                echo "  <p>Número de telemóvel inválido.</p>";
                echo "</div>";
                $flag=True;
                
            }

            // Validar Idade
            if (!filter_var($nif, FILTER_VALIDATE_INT) || strlen($nif) != 9) {
                echo "<div id='alerts' class='container mt-3' >";
                echo "  <p>NIF inválido.</p>";
                echo "</div>";
                $flag=True;
            
            }

            // Validar Email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo "<div id='alerts' class='container mt-3' >";
                echo "  <p>Email inválido.</p>";
                echo "</div>";
                $flag=True;
                
                
                
            }

            if(checkmail($email)){
                echo "<div id='alerts' class='container mt-3' >";
                echo "  <p>Email já em uso.</p>";
                echo "</div>";
                $flag=True;
            }

            // Validar Senha
            if (strlen($passwd) < 8) {
                echo "<div id='alerts' class='container mt-3' >";
                echo "  <p>A senha deve ter pelo menos 8 caracteres.</p>";
                echo "</div>";
                $flag=True;
                
            }

            // Hash da senha
            $passwd_hash = password_hash($passwd, PASSWORD_DEFAULT);

            //echo "</div>";
            if($flag==False){
                
                include "abreconexao.php";
                $_SESSION["username"]=$email;
                $tipo="utilizador";
            
                $stmt = $conn->prepare( "INSERT INTO utilizador (nome,telemovel,nif,tipo,email,passwd) VALUES (?,?,?,?,?,?)" );
                $stmt->bind_param("siisss",$nome,$telemovel,$nif,$tipo,$email,$passwd_hash);
                $stmt->execute();
                
                $stmt->close();
                $conn->close();

                $_SESSION["nomeutilizador"]=$nome;
                
                header("Location: home.php");
            }
            
             

        }
    

    
    
    }

    function test_input($data) {
      
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function checkmail($email){
        include "abreconexao.php";
        $sql="SELECT * FROM utilizador WHERE email='$email'";
        $result=mysqli_query($conn,$sql);
        if(mysqli_num_rows($result) == 0){
            mysqli_close($conn);
            return False;
        }
        else{
            mysqli_close($conn);
            return True;
        }
    }
 
?>