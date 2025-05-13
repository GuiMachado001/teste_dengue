document.querySelector('.btn_cadastrar_estado').addEventListener('click', function(){
    window.location = '../cadastrar/cadastrar_estado.php';
});

document.addEventListener("DOMContentLoaded", function() {
    fetch("./listar_estado.php")
    .then(response => response.json())
    .then(estados => {
        const tbody = document.querySelector(".container_lista_estados tbody");
        tbody.innerHTML = estados.map(estado => {
            let acoes = '';
        if (perfilUsuario === 1) {
            acoes = `
                <a href="../editar/editar_estado.php?id_estado=${estado.id_estado}" class="btn btn-sm btn-primary">Editar</a>
                <button class="btn btn-sm btn-danger btn-excluir" data-id="${estado.id_estado}">Excluir</button>
            `;
        } else {
            acoes = `
                <a class="btn btn-sm btn-secondary disabled" tabindex="-1" aria-disabled="true">Editar</a>
                <button class="btn btn-sm btn-secondary" disabled>Excluir</button>
            `;
        }

            return `
                <tr>
                    <td>${estado.nome}</td>
                    <td>${acoes}</td>
                </tr>
            `;
        }).join('');
    })
    .catch(error => console.error("Erro ao carregar os estados: ", error));
});
