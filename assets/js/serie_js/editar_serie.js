document.querySelector('#btn_cancelar').addEventListener('click', function(){
    window.location = '../listar/listar_serie.php';
});

document.addEventListener('DOMContentLoaded', function(){
    const urlParams = new URLSearchParams(window.location.search);
    const id_serie = urlParams.get('id_serie');

    if(!id_serie){
        Swal.fire({
            title: "Erro!",
            text: "Id do serie não informado!",
            icon: "error",
            confirmButtonText: "OK"
        }).then(() => {
            window.location.href = '../listar/listar_serie.php';
        });
        return;
    }

    fetch(`./buscar_serie.php?id_serie=${id_serie}`)
    .then(res => res.json())
    .then(data => {
        if(data){
            document.getElementById('id_serie').value = data.id_serie;
            document.getElementById('input').value = data.nome;
        } else {
            Swal.fire({
                title: "Erro!",
                text: "serie não encontrado!",
                icon: "error",
                confirmButtonText: "OK"
            }).then(() => {
                window.location.href = '../listar/listar_serie.php';
            });
        }
    });

    document.getElementById('form_editar_serie').addEventListener('submit', (e) => {
        e.preventDefault();

        const nome = document.getElementById('input').value;

        fetch('./editar_serie_controlador.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({
                id_serie: id_serie,
                nome: nome
            })
        })
        .then(res => res.json())
        .then(response => {
            Swal.fire({
                title: "Sucesso!",
                text: "serie editado com sucesso!",
                icon: "success",
                confirmButtonText: "OK"
            }).then(() => {
                window.location.href = '../listar/listar_serie.php';
            });
        });
    });
});
