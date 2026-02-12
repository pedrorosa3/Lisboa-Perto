let categoriaselecionada=document.getElementById("categoria");


categoriaselecionada.onchange = () => {
    
    
    let subcategoriaselecionada=document.getElementById("subcategoria");
    let valor = categoriaselecionada.value;
    

    fetch("selected_subcategoria.php?categoria=" + valor)
        .then(response => {
            return response.text();
        })
        .then(texto =>{
            
            subcategoriaselecionada.innerHTML=texto;
        });
    
}
 



