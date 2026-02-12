<?php
    include "abreconexao.php";

    $categoria=$_GET["categoria"];

    $sql= "SELECT subcategorias.nome FROM categorias,subcategorias WHERE subcategorias.categoria=categorias.id AND categorias.nome='$categoria' ";
    $result=mysqli_query($conn,$sql);
    if(mysqli_num_rows($result)>0){
        echo '<option value="">Selecione uma subcategoria</option>';
        while($row= mysqli_fetch_assoc($result)){
            
        ?>
            <option value="<?php echo $row['nome']?>"><?php echo $row['nome']?></option>
        <?php
                        
        };
        
        
    }
    mysqli_close($conn);
?>