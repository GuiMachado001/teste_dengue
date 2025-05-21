document.querySelector('.btn_cadastrar_escola').addEventListener('click', function(){
    window.location = '../cadastrar/cadastrar_escola.php';
});

document.addEventListener("DOMContentLoaded", function() {
    fetch("/teste_dengue/public/escola/listar/listar_escola_controlador.php")
        .then(response => response.json())
        .then(escolas => {
            const tbody = document.querySelector(".container_lista_escolas tbody");
            tbody.innerHTML = escolas.map(escola => {
                let acoes = '';
                if (perfilUsuario === 1) {
                    acoes = `
                        <a href="../editar/editar_escola.php?id_escola=${escola.id_escola}" class="btn btn-sm btn-primary">Editar</a>
                        <button class="btn btn-sm btn-danger btn-excluir" data-id="${escola.id_escola}">Excluir</button>
                    `;
                } else {
                    acoes = `
                        <a class="btn btn-sm btn-secondary disabled" tabindex="-1" aria-disabled="true">Editar</a>
                        <button class="btn btn-sm btn-secondary" disabled>Excluir</button>
                    `;
                }

                let status = '';
                if (escola.ativo == 0) {
                    status = `<button class="btn btn-sm btn-danger btn-status" data-id="${escola.id_escola}" data-ativo="0">Inativo</button>`;
                } else {
                    status = `<button class="btn btn-sm btn-success btn-status" data-id="${escola.id_escola}" data-ativo="1">Ativo</button>`;
                }

                
                return `
                    <tr>
                        <td>${escola.nome_escola}</td>
                        <td>${escola.nome_cidade}</td>
                        <td>${acoes}</td>
                        <td>${status}</td>
                    </tr>
                `;
            }).join('');
        })
        .catch(error => console.error("Erro ao carregar as escolas: ", error));
});

document.addEventListener('click', function(e){
    if(e.target.classList.contains('btn-status')){
        const id = e.target.getAttribute('data-id');
        const ativoAtual = parseInt(e.target.getAttribute('data-ativo'));
        const novoStatus = ativoAtual == 1 ? 0:1;

        fetch(`/teste_dengue/public/escola/listar/alterar_status.php`, {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ id_escola: id, ativo: novoStatus})
        })
        .then(res => res.json())
        .then(resposta => {
            if(resposta.success){
                window.location.reload();
            }else{
                Swal.fire('Erro', resposta.message || 'Erro ao atualizar o status.', 'error');
            }
        })
        .catch(() => {
            Swal.fire('Erro', 'Erro ao conectar com o servidor.', 'error');
        });
    }
})