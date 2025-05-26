document.querySelector('#btn_cancelar').addEventListener('click', function(){
    window.location = '../listar/escolher_escola.php';
});

document.addEventListener('DOMContentLoaded', function(){
    const urlParams = new URLSearchParams(window.location.search);
    const id_aluno = urlParams.get('id_aluno');

    if(!id_aluno){
        Swal.fire({
            title: "Erro!",
            text: "Id do aluno não informado!",
            icon: "error",
            confirmButtonText: "OK"
        }).then(() => {
            window.location.href = '../listar/escolher_escola.php';
        });
        return;
    }

    fetch(`./buscar_aluno.php?id_aluno=${id_aluno}`)
    .then(res => res.json())
    .then(data => {
        if(data){
            document.getElementById('id_aluno').value = data.id_aluno;
            document.getElementById('input').value = data.nome;
        } else {
            Swal.fire({
                title: "Erro!",
                text: "aluno não encontrado!",
                icon: "error",
                confirmButtonText: "OK"
            }).then(() => {
                window.location.href = '../listar/escolher_escola.php';
            });
        }
    });

    document.getElementById('form_editar_aluno').addEventListener('submit', (e) => {
        e.preventDefault();

        const nome = document.getElementById('input').value;

        fetch('./editar_aluno_controlador.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({
                id_aluno: id_aluno,
                nome: nome
            })
        })
        .then(res => res.json())
        .then(response => {
            Swal.fire({
                title: "Sucesso!",
                text: "aluno editado com sucesso!",
                icon: "success",
                confirmButtonText: "OK"
            }).then(() => {
                window.location.href = '../listar/escolher_escola.php';
            });
        });
    });
});
