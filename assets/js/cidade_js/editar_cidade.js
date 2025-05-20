document.querySelector('#btn_cancelar').addEventListener('click', function(){
    window.location = '../listar/listar_cidade.php';
});

document.addEventListener('DOMContentLoaded', function(){
    const urlParams = new URLSearchParams(window.location.search);
    const id_cidade = urlParams.get('id_cidade');

    if(!id_cidade){
        Swal.fire({
            title: "Erro!",
            text: "Id do cidade não informado!",
            icon: "error",
            confirmButtonText: "OK"
        }).then(() => {
            window.location.href = '../listar/listar_cidade.php';
        });
        return;
    }

    fetch(`./buscar_cidade.php?id_cidade=${id_cidade}`)
    .then(res => res.json())
    .then(data => {
        if(data){
            document.getElementById('id_cidade').value = data.id_cidade;
            document.getElementById('input').value = data.nome;
        } else {
            Swal.fire({
                title: "Erro!",
                text: "cidade não encontrado!",
                icon: "error",
                confirmButtonText: "OK"
            }).then(() => {
                window.location.href = '../listar/listar_cidade.php';
            });
        }
    });

    document.getElementById('form_editar_cidade').addEventListener('submit', (e) => {
        e.preventDefault();

        const nome = document.getElementById('input').value;

        fetch('./editar_cidade_controlador.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({
                id_cidade: id_cidade,
                nome: nome
            })
        })
        .then(res => res.json())
        .then(response => {
            Swal.fire({
                title: "Sucesso!",
                text: "cidade editado com sucesso!",
                icon: "success",
                confirmButtonText: "OK"
            }).then(() => {
                window.location.href = '../listar/listar_cidade.php';
            });
        });
    });
});
