<?php
    session_start();
    include("abreconexao.php");

    if ( $_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST["logout"])){
          session_destroy();
          header("Location: index.php");
        }
    }

    $idocorrencia = isset($_GET['idocorrencia']) ? $_GET['idocorrencia'] : null;
    $usermail = isset($_GET['userid']) ? $_GET['userid'] : null;


   

    $sql="SELECT * FROM utilizador WHERE email='$usermail'";
    $result=mysqli_query($conn,$sql);
    if(mysqli_num_rows($result) == 1){
        while ($row =mysqli_fetch_assoc($result)){
            $userid=$row["id"];

        }
    }

    

    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["submit"])){
        
            $user = $userid;
            $message = $_POST['message'];

            $user2=28;
            
        
            $stmt = $conn->prepare("INSERT INTO chat (mensagem, utilizador1,utilizador2,ocorrencia) VALUES (?,?,?,?)");
            $stmt->bind_param("siii", $message, $user,$user2,$idocorrencia);
            
            $stmt->execute();
            $stmt->close();
            
        }
    }
    
    $messages = $conn->query("SELECT * FROM chat WHERE (chat.utilizador1=$userid OR chat.utilizador2=$userid) AND chat.ocorrencia=$idocorrencia ORDER BY tempo_mensagem ASC");
    
    
    
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style1.css">
    <title>Lisboa+Perto</title>
    <style>
        body { font-family: Arial, sans-serif; }
        #chat-box { width: 500px; height: 400px; border: 1px solid #ccc; overflow-y: scroll; margin-bottom: 10px; background-color: grey; }
        .message { margin: 10px 0; }
        .message .user { font-weight: bold; }
        .message .timestamp { font-size: 0.8em; color: #999; }
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
              
              echo ' <button class="btn btn-secondary" id="nomeutilizadores"> ' . $_SESSION['nomeutilizador'] . "</button> ";


            ?> 
            <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
                <input class="btn btn-secondary" id = "logout" type="submit" name="logout" value="LogOut">
            </form>
                
            
          
            
          </div>
        </div>
      </nav>  

    <div id="chat-box">
        <?php while($row = $messages->fetch_assoc()): ?>
            <div class="message">
                <div class="user">
                    <?php 
                        $idutilizador=$row["utilizador1"];
                        $tempomensagem=$row["tempo_mensagem"];
                        $mensagem=$row["mensagem"];
                        $sql="SELECT * FROM utilizador WHERE id='$idutilizador'";
                        $result=mysqli_query($conn,$sql);
                        if(mysqli_num_rows($result) == 1){
                            while ($row =mysqli_fetch_assoc($result)){
                                $nomedouser=$row["nome"];

                            }
                        }

                        echo $nomedouser; 
                
                    ?>
                </div>
                <div class="timestamp"><?php echo $tempomensagem; ?></div>
                <div class="text"><?php echo $mensagem; ?></div>
            </div>
        <?php endwhile; ?>
    </div>
    
    <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
        
        <textarea id="message" name="message" placeholder="Digite sua mensagem" required></textarea>
        <input type="submit" class="btn btn-primary my-2" name="submit" id="submit" value="Enviar">

    </form>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#chat-form').on('submit', function(e) {
                e.preventDefault();
                
                var user = $('#user').val();
                var message = $('#message').val();

                $.post('chat.php', {user: user, message: message}, function() {
                    $('#message').val('');
                    loadMessages();
                });
            });

            function loadMessages() {
                <?php
                    $messages = $conn->query("SELECT * FROM chat WHERE (chat.utilizador1=$userid OR chat.utilizador2=$userid) AND chat.ocorrencia=$idocorrencia ORDER BY tempo_mensagem ASC");
                ?>
                
            }

            setInterval(loadMessages, 3000); 
        });
    </script>
    
    
</body>
</html>