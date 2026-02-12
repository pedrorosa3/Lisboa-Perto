<?php
    if ( $_SERVER["REQUEST_METHOD"] == "POST") {
            
        include("abreconexao.php");
        $rating = $_POST["rating"];
        $feedback = $_POST["feedback"];
        $user= $_POST["userid"];
        $ocorrencia=$_POST["idocorrencia"];

        $sql="SELECT * FROM utilizador WHERE email='$user'";
            $result=mysqli_query($conn,$sql);
            if(mysqli_num_rows($result) == 1){
                while ($row =mysqli_fetch_assoc($result)){
                    $userid=$row["id"];

                }
            }

                
            echo $rating;
            echo $feedback;
            echo $ocorrencia;
            echo $userid;

            $sql ="INSERT INTO feedback (mensagem,rating,idutilizador,idocorrencia) VALUES (?,?,?,?)";
            if(mysqli_query($conn,$sql)){
                echo "Sucesso";

            }else{
                echo "erro:".mysqli_error($conn);
            }
            
                    
            mysqli_close($conn);
    }    
?>