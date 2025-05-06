document.querySelector('#btn_cancelar').addEventListener('click', function(){
    window.location = '../listar/estados.html';
})

document.addEventListener('DOMContentLoaded', function(){
    const urlParams = new URLSearchParams(window.location.search);
    const id_estado = urlParams.get('id_estado');

    if(!id_estado){
        alert('Id do estado não informado!');
        window.location.href = '../listar/listar_estados.html';
        return;
    }

    fetch(`./buscar_estado.php?id_estado=${id_estado}`)
    .then(res => res.json())
    .then(data => {
        if(data){
            document.getElementById('id_estado').value = data.id_estado;
            document.getElementById('input').value = data.nome;
        }else{
            alert('Estado não encontrado');
            window.location.href = '../listar/listar_estados.html';
        }
    });

    document.getElementById('form_editar_estado').addEventListener('submit', (e) => {
        e.preventDefault();

        const nome = document.getElementById('input').value;

        fetch('./editar_estado.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({
                id_estado: id_estado,
                nome: nome
            })
        })
        .then(res => res.json())
        .then(response => {
            Swal.fire({
                title: "Estado editado com sucesso!",
                icon: "success",
                backdrop: true,
                confirmButtonText: "OK"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '../listar/estados.html'; // caminho para a listagem
                }
            });
        });
    });

})