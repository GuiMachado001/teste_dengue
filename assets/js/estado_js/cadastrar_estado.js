document.querySelector('.btn_cancelar').addEventListener('click', function(){
    window.location = '../listar/estados.html';
})


document.getElementById('form_cadastro_estado').addEventListener('submit', function(e){
    e.preventDefault();

    const dados = {
        nome: this.nome.value
    };

    fetch("./cadastrar_estado.php",{
        method: "POST",
        headers: {"Content-Type": "application/json"},
        body: JSON.stringify(dados)
    })
    .then(res =>{
        if(!res.ok) throw new Error('erro na requisição: ' + res.status);
        return res.json();
    })
    .then(data => alert(data.message))
    .catch(err => console.error('Erro:', err.message));
});