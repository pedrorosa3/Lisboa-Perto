




function openFeedback(id,idutilizador){
    window.location.href = "feedback.php?idocorrencia="+id+"&userid="+idutilizador;
}

function openEdit(id){
    console.log(id);
    window.location.href = "editocorrencia.php?idocorrencia="+id;

}


function openChat(id,idutilizador){
    window.location.href= "chat.php?idocorrencia="+id+"&userid="+idutilizador;
}



