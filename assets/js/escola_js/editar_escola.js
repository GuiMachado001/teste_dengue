document.querySelector('#btn_cancelar').addEventListener('click', function(){
    window.location = '../listar/listar_escola.php';
});

document.addEventListener('DOMContentLoaded', function(){
    const urlParams = new URLSearchParams(window.location.search);
    const id_escola = urlParams.get('id_escola');

    if(!id_escola){
        Swal.fire({
            title: "Erro!",
            text: "Id do escola não informado!",
            icon: "error",
            confirmButtonText: "OK"
        }).then(() => {
            window.location.href = '../listar/listar_escola.php';
        });
        return;
    }

    fetch(`./buscar_escola.php?id_escola=${id_escola}`)
    .then(res => res.json())
    .then(data => {
        if(data){
            document.getElementById('id_escola').value = data.id_escola;
            document.getElementById('input').value = data.nome;
        } else {
            Swal.fire({
                title: "Erro!",
                text: "escola não encontrado!",
                icon: "error",
                confirmButtonText: "OK"
            }).then(() => {
                window.location.href = '../listar/listar_escola.php';
            });
        }
    });

    document.getElementById('form_editar_escola').addEventListener('submit', (e) => {
        e.preventDefault();

        const nome = document.getElementById('input').value;

        fetch('./editar_escola_controlador.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({
                id_escola: id_escola,
                nome: nome
            })
        })
        .then(res => res.json())
        .then(response => {
            Swal.fire({
                title: "Sucesso!",
                text: "escola editado com sucesso!",
                icon: "success",
                confirmButtonText: "OK"
            }).then(() => {
                window.location.href = '../listar/listar_escola.php';
            });
        });
    });
});
