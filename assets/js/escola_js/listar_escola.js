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

                return `
                    <tr>
                        <td>${escola.nome_escola}</td>
                        <td>${escola.nome_estado}</td>
                        <td>${acoes}</td>
                    </tr>
                `;
            }).join('');
        })
        .catch(error => console.error("Erro ao carregar as escolas: ", error));
});
